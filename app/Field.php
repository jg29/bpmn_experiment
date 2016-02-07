<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Field extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'element_id',
        'settings',
        'validation'
    ];


    public function element()
    {
        return $this->belongsTo('App\Element', 'element_id');
    }



    public static function getFieldAnswers($field, $value) {

        $feld = Field::findOrFail($field);
        $ret = "";
        if(is_array($value)) {
            foreach($value as $v) {
                $ret .= explode("\n", $feld->settings)[$v]." ";
            }
        } else {
            $ret = explode("\n", $feld->settings)[$value];
        }



        return $ret;

    }

}
