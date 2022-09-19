<?php

namespace App\Imports;

use App\Question;
use App\Answer;
use Maatwebsite\Excel\Concerns\ToModel;

class QnaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        \Log::info($row);

        if($row[0] != 'questions'){
            $q_id = Question::insertGetId([
                'question' => $row[0]
            ]);
            


            for($i=1; $i<count($row)-1; $i++){
               $is_correct =0;
               if($row[3] == $row[$i]){
                $is_correct = 1;
               }

               Answer::insert([
                 'question_id' => $q_id,
                 'answer' => $row[$i],
                 'is_correct' => $is_correct
               ]);

            }
        }

        // return new Question([
        //     //
        // ]);
    }
}
