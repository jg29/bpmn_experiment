<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function element()
    {
        return $this->belongsTo('App\Element', 'element_id');
    }
}
