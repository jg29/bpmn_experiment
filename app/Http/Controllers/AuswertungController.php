<?php

namespace App\Http\Controllers;

use App\Field;
use App\Answer;
use App\Experiment;
use App\Element;
use Illuminate\Http\Request;

use Excel;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AuswertungController extends Controller
{
    public $experiment;

    public function excel($id) {
        $this->experiment = Experiment::findOrFail($id);

        //



        Excel::create('Download', function($excel) {
            $excel->sheet('Seite', function($sheet) {
                $experiment = $this->experiment;
                $sheet->loadView('export.auswertung', compact('experiment'));
            });
        })->download('xls');


        //return view('export.auswertung', compact('experiment'));
    }

    public function show($id)
    {
        $experiment = Experiment::findOrFail($id);
        $elements = array();
        $element =  Element::find($experiment->element_id);
        $xor2 = array();
        $xorElement = null;
        $antworten = array();
        while($element != null) {
            if($element->type == 5) {
                $xorElement = $element;
                $xor = json_decode($element->ref, true);


                $xor2 = array();
                if(is_array($xor)) {
                    foreach($xor as $pkey => $pfad) {
                        foreach($pfad as $ekey => $el) {
                            $ele =  Element::find($el);
                            if($ele->type == 2 or $ele->type == 3 or $ele->type == 4) {
                                $xor2[$pkey][$ekey] = $ele;
                                $antwortenObjects = Answer::where("element", $ele->id)->where("experiment", $id)->get();
                                foreach($antwortenObjects as $antwortObject) {
                                    $antworten[$antwortObject->student][$ele->id] = $antwortObject;
                                }
                            }
                        }
                    }
                }

            } elseif($element->type == 2 OR $element->type == 4 or $element->type == 3) {
                $elements[] = Element::findOrFail($element->id);

                $antwortenObjects = Answer::where("element", $element->id)->where("experiment", $id)->get();
                foreach($antwortenObjects as $antwortObject) {
                    $antworten[$antwortObject->student][$element->id] = $antwortObject;
                }

            }
            $element = $element->next();
        }
        $elements = array_merge($elements, [$xor2]);
        $fields = array();
        $fields2 = Field::all();
        foreach($fields2 as $field){
            $fields[$field->id] = $field;
        }


        return view('auswertung.show', compact('experiment', 'elements', 'antworten', 'xorElement', 'fields'));
    }



    public function timeline($element, $student) {

        $diagramme = Answer::where("element", $element)->where('student', $student)->get();
        //->where("experiment", 2)

        return view('auswertung.timeline', compact('diagramme'));

    }

}
