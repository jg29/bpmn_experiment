<?php

namespace App\Http\Controllers;

use App\Field;
use App\Answer;
use App\Experiment;
use App\Element;

use Excel;
use App\Http\Requests;

class AuswertungController extends Controller
{
    public $table;

    public function excel($id) {
        $experiment = Experiment::findOrFail($id);

        $element = Element::findOrFail($experiment->element_id);

        while($element != null) {
            if($element->type == 5) {
                $xor = json_decode($element->ref, true);
                if(is_array($xor)) {
                    foreach($xor as $pkey => $pfad) {
                        foreach($pfad as $ekey => $el) {
                            $ele =  Element::find($el);
                            if($ele->type == 2) {
                                $fields = Field::where("element_id", $ele->id)->orderBy('sort')->get();
                                foreach($fields as $field) {
                                    $rows[$element->id][$ele->id][]['field'] = $field->id;
                                }
                            } elseif($ele->type == 4 or $ele->type == 3) {
                                $rows[$element->id][$ele->id][]['element'] = $ele->id;
                            }
                        }
                    }
                }

            } elseif($element->type == 2) {
                $fields = Field::where("element_id", $element->id)->orderBy('sort')->get();
                foreach($fields as $field) {
                    $rows[$element->id][]['field'] = $field->id;
                }
            } elseif($element->type == 4 or $element->type == 3) {
                $rows[$element->id][]['element'] = $element->id;
            }
            $element = $element->next();
        }
        $this->table = $rows;

        $users = Answer::where('experiment', $id)->groupBy("student")->get();

        //print_r($rows);
        $this->table = compact('rows', 'experiment', 'users');
        if(isset($_GET['show']) and $_GET['show']=="html") {
            return view('export.auswertung', $this->table);
        }
        Excel::create('Download', function($excel) {
            $excel->sheet('Seite', function($sheet) {
                $sheet->loadView('export.auswertung', $this->table);
                $sheet->setAutoSize(true);
                $sheet->setAutoFilter('A3:BZ3');
            });
        })->download('xls');


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

        return view('auswertung.timeline', compact('diagramme'));

    }

}
