<?php

namespace App\Http\Controllers;

use App\Experiment;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FreigabeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function freigabe($experiment)
    {
        $experiment = Experiment::findOrFail($experiment);

        $recht = json_decode($experiment->group,true);
        $users = User::all();

        return view("freigabe.index", compact('experiment','recht','users'));
    }


    public function save( $experiment, Request $request ) {
        $experiment = Experiment::findOrFail($experiment);
        $experiment->group = json_encode($request->recht);
        $experiment->save();



        return redirect("/experiment");
    }

}
