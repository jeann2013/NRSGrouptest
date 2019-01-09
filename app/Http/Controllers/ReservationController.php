<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{

    /**
     * ReservationController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function news(Request $request)
    {
        if ($request->isMethod('post')) {

            $butacas = $request->butacas;
            $DateSearch = date('Y-m-d');

            Reservation::where('created_at','>=',$DateSearch." 00:00:00")
                ->where('created_at','<=',$DateSearch." 23:59:59")
                ->where('user_id','=',Auth::id())
                ->delete();

            foreach ($butacas as $butaca){

                $butacaRowCol = explode("-",$butaca);
                $row = $butacaRowCol[0];
                $col = $butacaRowCol[1];

                $reservation = Reservation::create([
                    'col' => $col,
                    'row' => $row,
                    'user_id' => Auth::user()->id
                ]);

            }

            Log::debug('Se creo nueva reservacion:'. $reservation->id ." Usuario: ". Auth::user()->name ." ". Auth::user()->lname );
        }
        return redirect('home');
    }
}
