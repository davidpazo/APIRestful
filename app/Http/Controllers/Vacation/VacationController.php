<?php

namespace App\Http\Controllers\Vacation;

use App\Http\Controllers\ApiController;
use App\Transformers\VacationTransformer;
use App\Vacation;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class VacationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:' . VacationTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:manage-account')->except('index');
    }

    public function index()
    { // quitar if/throw si no funciona, scope para verificar si es admin o no para ver todas las vacaciones
        if (request()->user()->tokenCan('read-list') || request()->user()->tokenCan('manage-accounts')) {
            $vacation = Vacation::all();
            return $this->showAll($vacation);
        }
        throw new AuthenticationException;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**try {
         * $decrypted_id = \Crypt::decrypt($worker);
         * $decrypted_name = \Crypt::decrypt($name_worker);
         * } catch (DecryptException $e) {
         * return redirect('/home');
         * }
         * return view('vacation.create')->with('id_worker',$decrypted_id)->with('name_worker',$decrypted_name);*/
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
            'type' => 'required',
            'days_taken' => 'required',
            'reason' => 'required',
            'observations' => 'required',
            'date_init' => 'required',
            'worker_id' => 'required',
        ];
        $this->validate($request, $rules);

        $vacation = new Vacation();
        $vacation->type = $request['type'];
        $vacation->days_taken = $request['days_taken'];
        $vacation->reason = $request['reason'];
        $vacation->observations = $request['observations'];
        $vacation->date_init = date("Y-m-d", strtotime($request['date_init']));
        $vacation->worker_id = $request['worker_id'];

        $vacation->save();

        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vacation $vacation)
    {
        return $this->showOne($vacation, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
