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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function experiment()
    {
        return $this->hasOne('App\Experiment');
    }

    /**
     * Experimente eines Users anzeigen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prev()
    {
        return $this->belongsTo('App\Element', 'element_id');
    }

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
        return $this->belongsTo('App\Field');
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
