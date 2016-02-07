<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Experiment;
use App\Element;
use App\Answer;
use App\Field;

use App\Http\Requests;

/**
 * Class StudentController
 * @package App\Http\Controllers
 */
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
     * @param $num
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function element($id, $num) {
        $experiment = Experiment::where("key", $id)->first();
        if($experiment == null) {
            return redirect('/');
        }
        $elements = session('elements');
        $element =  Element::find($elements[$num]);
        if($element == null) {
            return redirect('/');
        }
        $next = $num+1;
        return view('student.element', compact('experiment','element','next','elements'));
    }


    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirect() {
        $array = explode("-", $_POST['key']);

        if(count($array) == 2 and $array[0] != '' and $array[1] != '') {

            if(session("user") == "") {
                session(["user"=>time()]);
            }




            $experiment = Experiment::where("key", $array[0])->first();
            if($experiment == null) {
                return redirect('/');
            }
            $elements = array();
            $element =  Element::find($experiment->element_id);
            while($element != null) {
                if($element->type == 5) {
                    $hash = $array[1]{0}.substr(md5(date("s", strtotime($element->created_at)).$array[1]{0}), -2);
                    if(trim($hash) != trim($array[1])) {
                        return redirect('/');
                    }

                    $xor = json_decode($element->ref, true);
                    $elements = array_merge($elements, $xor[$array[1]{0}]);
                } else {
                    $elements[] = $element->id;
                }
                $element = $element->next();
            }
            session(['experiment'=>$array[0],'elements'=>$elements]);

            $antwort = new Answer();
            $antwort->element = 0;
            $antwort->experiment = $experiment->id;
            $antwort->value = $array[1]{0};
            $antwort->student = session("user");
            $antwort->save();

            return redirect('/experiment/'.$array[0].'/0');
        } else {
            return redirect('/');
        }

    }


    public function saveDraw($e_id, $f_id) {

        $experiment = Experiment::where("key", $e_id)->first();

        $answer = new Answer();
        $answer->student = session('user');
        $answer->element = $f_id;
        $answer->experiment = $experiment->id;
        $answer->value = $_POST['draw'];

        //$array = json_decode($answer->value, true);

        $answer->save();
        //return ;
        return "ok";
    }
}
