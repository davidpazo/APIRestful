<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function getVacations()
    {
        return view('vacaciones.vacations');
    }


   /**public function getTokens()
    {
        return view('personal-tokens');
    }

    public function getClients()
    {
        return view('tokens.personal-clients');
    }

    public function getAuthorizedClients()
    {
        return view('tokens.authorized-clients');
    }*/

}
