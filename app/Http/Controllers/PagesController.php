<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Answer;
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

        $diagramme = Answer::where("element", 9)->where("experiment", 2)->where('student', 1454509618)->get();


        return view('pages.test', compact('diagramme'));

    }

}
