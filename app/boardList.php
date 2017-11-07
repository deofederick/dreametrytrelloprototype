<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class boardList extends Model
{
    public function status(){
        return $this->belongsTo('App\Status');
    }

    public function board(){
        return $this->belongsTo('App\Board');
    }
}
