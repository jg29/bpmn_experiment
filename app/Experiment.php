<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'text',
        'element_id',
        'key'
    ];


    /**
     * Ersteller des Experimentes
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {

        return $this->belongsTo('App\eeUser');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function element() {

        return $this->belongsTo('App\Element');
    }

}