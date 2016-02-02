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

}
