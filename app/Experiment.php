<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{

    protected $fillable = [
        'title',
        'text',
        'element',
        'key'
    ];


    /**
     * Ersteller des Experimentes
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {

        return $this->belongsTo('App/User');

    }
}
