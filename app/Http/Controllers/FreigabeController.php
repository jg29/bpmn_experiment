<?php

namespace App\Http\Controllers;

use App\Experiment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Psy\Exception\ErrorException;

/*
 * Kümmert sich um die Freigabe von Experimenten
 *
 */


class FreigabeController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function freigabe($experiment) {
        $experiment = Experiment::findOrFail($experiment);
        $rechte = json_decode($experiment->group,true);
        $editUser = array();
        $viewUser = array();
        $users = array();

        if(is_array($rechte)) {
            $keys = array("edit", "view");
            foreach($keys as $key) {
                if (array_key_exists($key, $rechte)) {
                    foreach ($rechte[$key] as $recht) {
                        $users[$recht] = User::findOrFail($recht);
                        if($key == "edit"){
                            $editUser[] = $recht;
                        }
                        if($key == "view"){
                            $viewUser[] = $recht;
                        }
                    }
                }
            }
        }
        return view("freigabe.index", compact('experiment','editUser', 'viewUser', 'users'));
    }


    public function save( $experiment, Request $request ) {
        $experiment = Experiment::findOrFail($experiment);
        $experiment->group = json_encode($request->recht);
        $experiment->save();
        return redirect("/freigabe/".$experiment->id);
    }

    public function mail() {
        $user = User::where("email", $_POST['mail'])->first();
        if(is_object($user) and $user->isEditor() and $user->id != Auth::user()->id ) {
            return $user;
        } elseif(is_object($user) and $user->isEditor()) {
            return "error_selbst";
        } elseif(is_object($user) and $user->id != Auth::user()->id) {
            return "error_recht";
        }
        return "";
    }

}
