<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Field;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
 * Wird nur inderekt per Javascript verwendet. Hat keinen direkten View
 *
 *
 *
 */


class FieldController extends Controller
{

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

        $field = new Field();
        $field->element_id = $request->element_id;
        $field->type = $request->type;
        $field->name = $request->name;
        $field->validation = $request->validation;
        $field->settings = $request->settings;
        $f = Field::orderBy('sort', 'DESC')->first();
        if($f != null) {
            $field->sort = $f->sort+1;
        } else{
            $field->sort = 1;
        }
        $field->save();


        return $request->element_id;
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
        $field = Field::findOrFail($id);
        $field->update($request->all());
        return $field->element_id;

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
        $field = Field::findOrFail($id);
        $r = $field->element_id;
        $field->delete();
        return $r;
    }

    public function up() {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        $eid = $_GET['eid'];

        $vor = Field::findOrFail($_GET['id']);
        $sortvor = $vor->sort;

        $next = Field::where('sort', '<', $sortvor)->orderBy('sort', 'DESC')->where('element_id', $eid)->first();
        $sortnext = $next->sort;

        $vor->sort = $sortnext;
        $next->sort = $sortvor;
        $vor->save();
        $next->save();


        return $next;
    }

    public function down() {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        $eid = $_GET['eid'];

        $vor = Field::findOrFail($_GET['id']);
        $sortvor = $vor->sort;

        $next = Field::where('sort', '>', $sortvor)->orderBy('sort', 'ASC')->where('element_id', $eid)->first();
        $sortnext = $next->sort;

        $vor->sort = $sortnext;
        $next->sort = $sortvor;
        $vor->save();
        $next->save();


        return $next;
    }

}
