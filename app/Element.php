<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Element extends Model
{
    const MESSAGE = 1;
    const SURVAY = 2;
    const MODEL = 3;
    const FEEDBACK = 4;
    const XORs = 5;


    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'element_id',
        'type'
    ];





    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function next()
    {
        return $this::find($this->element_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields()
    {


        return $this->hasMany('App\Field')->orderBy('sort', 'ASC');


    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getRef()
    {
        $array = json_decode($this->ref, true);
        foreach($array as $i => $a) {
            foreach($a as $j => $element) {
                $array[$i][$j] = Element::findOrFail($element);
            }
        }
        if($this->content < count($array)) {

        }
        return $array;

    }

    public function getClass() {
        switch ($this->type) {
            case 1: return "message";
            case 2: return "survey";
            case 3: return "edit";
            case 4: return "feedback";
            case 5: return "xor";
        }
    }


}
