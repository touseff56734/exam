<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QnaExam extends Model
{
    public $table = "exam_qna";
    protected $fillable= ['exam_id','question_id'];
}
