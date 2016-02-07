<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    public static function getPfad($student) {
        $answer = Answer::where('student', $student)->where('element',0)->first();
        return $answer->value;
    }
}
