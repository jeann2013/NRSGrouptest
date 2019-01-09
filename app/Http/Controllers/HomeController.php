<?php

namespace App\Http\Controllers;

use App\Reservation;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        $DateSearch = date('Y-m-d');
        $reservationsUser = DB::table('reservation')->where('user_id','=',Auth::id())
        ->where('created_at','>=',$DateSearch." 00:00:00")
            ->where('created_at','<=',$DateSearch." 23:59:59")->get();

        $reservationsAll = DB::table('reservation')
            ->where('created_at','>=',$DateSearch." 00:00:00")
            ->where('created_at','<=',$DateSearch." 23:59:59")->get();

        return view('home', compact('reservationsUser','reservationsAll'));
    }
}
