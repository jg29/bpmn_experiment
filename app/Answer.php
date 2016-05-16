<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    public static function getPfad($student) {
        $answer = Answer::where('student', $student)->where('element',0)->first();
        return $answer->value;
    }

    public static function getValue($element, $field, $user) {
        $answer = Answer::where('student', $user)->where('element', $element)->first();
        if(is_object($answer) and array_key_exists($field,json_decode($answer->value, true))) {
            return json_decode($answer->value, true)[$field];
        } else {
            return "";
        }


    }


}
