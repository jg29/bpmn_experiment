<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    public function home() {
        return view('pages.start');
    }

    public function danke() {
        return view('pages.danke');
    }

    public function test() {
        return view('pages.test');
    }

    public function redirect() {
        $array = explode("-", $_POST['key']);

        if(count($array) == 2 and $array[0] != '' and $array[1] != '') {
            session(['experiment'=>$array[0],'field'=>$array[1]]);
            if(session("user") == "") {
                session(["user"=>time()]);
            }





            return redirect('experiment/'.$array[0]);
        } else {
            return redirect('/');
        }

    }
}
