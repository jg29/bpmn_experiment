<?php

namespace App\Http\Controllers;

use App\Experiment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Requests\ExperimentRequest;

use App\Http\Controllers\Controller;

class ExperimentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        $experiments = Auth::user()->experiments()->get();

        return view('experiment.index', compact('experiments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        return view('experiment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExperimentRequest $request)
    {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        $experiment = new Experiment($request->all());
        $experiment->key = $rest = substr(bcrypt(($request->title).random_bytes(5)), -6);
        Auth::user()->experiments()->save($experiment);

        return redirect('experiment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        $experiment = Experiment::findOrFail($id);
        return view('experiment.show', compact('experiment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        $experiment = Experiment::findOrFail($id);

        $element =  $experiment->element()->first();

        //return dd($element->next());
        return view('experiment.edit', compact('experiment','element'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExperimentRequest $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        $experiment = Experiment::findOrFail($id);

        $experiment->update($request->all());
        return redirect('experiment');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        $experiment = Experiment::findOrFail($id);
        $experiment->delete();
        return redirect('experiment');
    }
}
