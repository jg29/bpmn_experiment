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
        session(["user"=>null]);
        return view('pages.danke');
    }
}
