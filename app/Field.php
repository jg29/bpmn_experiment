<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'element_id',
        'settings'
    ];


    public function element()
    {
        return $this->belongsTo('App\Element', 'element_id');
    }
}
