<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Experiment;
use App\Element;
use App\Answer;
use App\Field;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /**
     * @param $e_id
     * @param $f_id
     * @param $request
     * @return mixed
     */
    public function save( $e_id, $f_id,Request $request ) {
        $experiment = Experiment::where("key", $e_id)->first();


        $answer = new Answer();
        $answer->student = session('user');
        $answer->element = $f_id;
        $answer->experiment = $experiment->id;
        $answer->value = json_encode($request['form']);

        //$array = json_decode($answer->value, true);

        $answer->save();
        //return ;
        return redirect($request->url);
    }


    /**
     * @param $id
     * @param $element
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function element($id, $element) {
        $experiment = Experiment::where("key", $id)->first();
        if($experiment == null) {
            return redirect('/');
        }
        $element =  Element::find($element);
        if(!in_array($element->id, session('fields'))) {
            return redirect('/');
        }


        if($element->type == 5) {
            $fieldnr = session("field");
            $field_id = substr($fieldnr, 0,-2);
            $field_type = substr($fieldnr, -2);

            $field = Field::where('id',$field_id)->where('type',$field_type)->first();

        }



        return view('student.element', compact('experiment','element', 'field'));
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
