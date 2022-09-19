<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Subset;

class Exam extends Model
{
    //
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
