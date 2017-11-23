<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Mail\UserCreated;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'verify', 'resend']);
        $this->middleware('client.credentials')->only(['store', 'resend']);
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:manage-account')->only(['show', 'update']);
        $this->middleware('can:view,user')->only('show');
        $this->middleware('can:update,user')->only('update');
        $this->middleware('can:delete,user')->only('destroy');
    }

    public function index()
    {
        $this->allowedAdminAction();
        $usuarios = User::all();
        return $this->showAll($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
        $this->validate($request, $rules);

        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        $campos['verification_token'] = User::generateVerificationToken();
        $campos['admin'] = User::USUARIO_REGULAR;

        $usuario = User::create($campos);

        //return response() -> json(['data'=> $usuario],201);
        return $this->showOne($usuario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function show(User $user)
    {
        //return response ()-> json(['data' => $usuario],200);
        //$usuario = User::findOrFail($id);
        return $this->showOne($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'email' => 'email|unique:users',
            'password' => 'min:6|confirmed',
            'admin' => 'in' . User::USUARIO_ADMIN . ',' . User::USUARIO_REGULAR,
        ];
        $this->validate($request, $rules);

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::USUARIO_NO_VERIFICADO;
            $user->verification_token = User::generateVerificationToken();
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        if ($request->has('admin')) {
            $this->allowedAdminAction();
            if (!$user->esVerificado()) {
                return response()->json(['error' => 'Unicamente los usuarios verificados pueden cambiar su valor de administrador', 'code' => 409], 409);
            }
            $user->admin = $request->admin;
        }
        if (!$user->isDirty()) {
            return response()->json(['error' => 'Se debe especificar al menos un valor diferente para actualizar', 'code' => 422], 422);
        }
        $user->save();
        //return response()->json(['data'=> $user],200);
        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //TODO: REALIZAR LA RESPUESTA
        $user->delete();
        //return response() -> json(['data'=> $user],200);
        return $this->showOne($user);
    }

    /**
     * VERIFICAR USUARIOS
     */
    public function verify($token)
    {

        $user = User::where('verification_token', $token)->firstOrFail();
        $user->verified = User::USUARIO_VERIFICADO;
        $user->verification_token = null;
        $user->save();
        return $this->showOne('Cuenta verificada');
    }

    /**
     * VERIFICAR USUARIOs, reenvio de correo para la verificacion,
     * comprueba si esta o no verificado en el sistema el usuario
     */
    public function resend(User $user)
    {
        if ($user->esVerificado()) {
            return $this->errorResponse('Este usuario ya ha sido verificado', 409);
        }
        //retry->numero de intentos
        retry(3, function () use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);
        return $this->showMessage('El correo de verificación se ha reenviado');
    }
}
