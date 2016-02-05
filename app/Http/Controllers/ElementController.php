<?php

namespace App\Http\Controllers;


use App\Experiment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Element;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ElementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->save(new Experiment($request->all()));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        $id = Element::create($request->all())->id;

        return $id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $element = Element::findOrFail($id);
        if($element->type == Element::SURVAY || $element->type == Element::XORs ) {
            $fields = $element->fields;
            return view('element.edit', compact('element','fields'));
        }

        return view('element.edit', compact('element'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        $element = Element::findOrFail($id);
        $element->update($request->all());
        return $element->id;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function order(Request $request) {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        $order = explode(",",$_POST['order']);

        $experiment = Experiment::find($_POST['experiment']);
        $experiment->element_id = $order[0];
        $experiment->save();
        for($i=0; $i<count($order)-1;$i++) {
            $element = Element::find($order[$i]);
            $element->element_id = $order[$i+1];
            $element->save();
        }

        return "ok";
    }

    public function orderXor(Request $request) {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }

        $element = Element::findOrFail($request->element);
        $element->ref = json_encode($request->array);
        $element->save();

        return 'ok';
    }



}
