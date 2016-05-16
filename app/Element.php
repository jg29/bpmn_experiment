<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Element extends Model
{

    const MESSAGE = 1;
    const SURVAY = 2;
    const MODEL = 3;
    const FEEDBACK = 4;
    const XORGATE = 5;

    /**
     * @var Sicherheitseinstellung Laravel fillable
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
    public function fields() {
        return $this->hasMany('App\Field')->orderBy('sort', 'ASC');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getRef() {
        if($this->ref != "") {
            $array = json_decode($this->ref, true);
            if(is_array($array)) {
                foreach ($array as $i => $a) {
                    foreach ($a as $j => $element) {
                        $array[$i][$j] = Element::findOrFail($element);
                    }
                }
                if ($this->content < count($array)) {

                }

                return $array;
            }
        }
        return array();
    }

    /**
     * @return string
     */
    public function getClass() {
        switch ($this->type) {
            case 1: return "message";
            case 2: return "survey";
            case 3: return "edit";
            case 4: return "feedback";
            case 5: return "xor";
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getElement($id) {
        return Element::findOrFail($id);
    }

    /**
     * @param $array
     * @return int
     */
    public static function countArray($array) {
        $num = 0;
        foreach ($array as $a) {
            $num += count($a);

        }
        return $num;
    }

}
