<?php

namespace App\Http\Controllers;

use App\Field;
use App\Experiment;
use App\Element;
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
        $experiment = Experiment::where("key", $id)->first();
        if($experiment == null) {
            return redirect('/');
        }
        $element =  $experiment->element()->first();
        return view('experiment.show', compact('experiment','element'));
    }

    public function element($id, $element) {
        $experiment = Experiment::where("key", $id)->first();
        if($experiment == null) {
            return redirect('/');
        }
        $element =  Element::find($element);

        if($element->type == 5) {
            $fieldnr = session("field");
            $field_id = substr($fieldnr, 0,-2);
            $field_type = substr($fieldnr, -2);

            $field = Field::where('id',$field_id)->where('type',$field_type)->first();

        }



        return view('experiment.element', compact('experiment','element', 'field'));
    }

    /**
     * @param $e_id
     * @param $f_id
     * @param $request
     * @return mixed
     */
    public function save( $e_id, $f_id,Request $request ) {


        return redirect($request->url);
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
