Hola{{$user->name}}


@component('mail::message')
    #Hola{{$user->name}}
    Gracias por crear una cuenta. Por favor verifica usando el siguiente enlace
    @component('mail::button', ['url' => route('verify',$user->verification_token)])
        Confirmar cuenta
    @endcomponent

    Gracias,<br>
    {{ config('app.name') }}
@endcomponent