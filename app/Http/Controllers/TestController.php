<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use App\Answer;
use App\Question;
use App\Imports\QnaImport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Mail;


class TestController extends Controller
{
    public function user()
    {
        dd('aa');
    }

    public function exam()
    {
        $subjects = Subject::all();
        $exams = Exam::all();
        return view('exam', compact('subjects', 'exams'));
    }

    public function addExam(Request $request)
    {
        //  dd($request->all());
        $exam = new Exam();
        $exam->name = $request->exam_name;
        $exam->subject_id = $request->subject_id;
        $exam->date = $request->date;
        $exam->time = $request->time;
        $exam->save();

        return 1;
    }

    public function editExam($id)
    {
        // dd($id);
        $subjects = Subject::all();
        $exam = Exam::find($id);
        return view('editExam', compact('exam', 'subjects'));
    }

    public function qna()
    {
        $questions = Question::with('answers')->get();
        return view('qna',compact('questions'));
    }

    public function getqna(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'question' => 'required|min:2',
        ]);

        try {
            $qid = Question::insertGetId([
                'question' => $request->question
            ]);
            foreach ($request->answers as $answer) {
                $is_correct = 0;
                if ($request->is_correct == $answer) {
                    $is_correct = 1;
                }
                Answer::insert([
                    'question_id' => $qid,
                    'answer' => $answer,
                    'is_correct' => $is_correct,
                ]);
            }
            return response()->json([
                'success' => true,
                'msg' => 'added successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'not added'
            ]);
        }
    }
    //import QnA
    public function import(Request $request){
      //  dd($request->all());
        Excel::import(new QnaImport, $request->file);
        return response()->json([
            'status' => true,
            'msg' => 'Import QnA Sucessfully'
        ]);
    }
    //show all students
    public function allstd(){
        $students = User::all();

        return view('all_std',compact('students'));
    }
    //add Students
    public function addstd(Request $request){
       // dd($request->all());
       
       $password = Str::random(8);
       User::insert([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($password)
       ]);

       $url = URL::to('/');
       $data['url'] = $url;
       $data['name'] = $request->name;
       $data['email'] = $request->email;
       $data['password'] = $password;
       $data['title'] = "Student Registration";

       Mail::send('stdmail',['data'=> $data], function($msg) use ($data){
            $msg->to($data['email'])->subject($data['title']);
       });

       return response()->json([
        'status' => true,
        'msg' => 'successfully'
       ]);
    }
}
