<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QnaExam;
use App\Models\User;
use App\Imports\QnaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{
    //Add Subject
    public function addSubject(Request $request)
    {
        try {
            Subject::insert([
                'subject'=>$request->subject,
            ]);
            return response()->json(['success'=>true,'msg'=>'Subject added successfully']);



        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //Edit Subject
    public function editSubject(Request $request)
    {
        try {
            $subject=Subject::find($request->id);
            $subject->subject=$request->subject;
            $subject->save();
            return response()->json(['success'=>true,'msg'=>'Subject Updated successfully']);



        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //Delete Subject
    public function deleteSubject(Request $request)
    {
        try {
            Subject::where('id',$request->id)->delete();
            return response()->json(['success'=>true,'msg'=>'Subject Updated successfully']);



        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }


    //Exam Dashboard Load
    public function examDashboard()
    {
        $subjects=Subject::all();
        $exams=Exam::with('subjects')->get();
        return view('admin.exam-dashboard',['subjects'=>$subjects,'exams'=>$exams]);
    }

    //Add Exam
    public function addExam(Request $request)
    {
        try {
            Exam::insert([
                'exam_name'=>$request->exam_name,
                'subject_id'=>$request->subject_id,
                'date'=>$request->date,
                'time'=>$request->time,
                'attempt'=>$request->attempt
            ]);
            return response()->json(['success'=>true,'msg'=>'Exam added successfully']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //Edit Exam
    public function getExamDetail($id)
    {
        try {
            $exam=Exam::where('id',$id)->get();
            return response()->json(['success'=>true,'data'=>$exam]);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //Update Exam
    public function updateExam(Request $request)
    {
        try {
            $exam=Exam::find($request->exam_id);
            $exam->exam_name=$request->exam_name;
            $exam->subject_id=$request->subject_id;
            $exam->date=$request->date;
            $exam->time=$request->time;
            $exam->attempt=$request->attempt;
            $exam->save();
            return response()->json(['success'=>true,'msg'=>'Exam Updated Successfully']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //Delete Exam
    public function deleteExam(Request $request)
    {
        try {
            Exam::where('id',$request->exam_id)->delete();
            
            return response()->json(['success'=>true,'msg'=>'Exam deleted Successfully']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //Q&A Dashboard
    public function qnaDashboard()
    {
        $questions=Question::with('answers')->get();
        return view('admin.qnaDashboard',compact('questions'));
    }

    //Add Qna
    public function addQna(Request $request)
    {
        // return response()->json($request->all());

        try {
            $questionId=Question::insertGetId([
                'question'=>$request->question
            ]);
            
            foreach($request->answers as $answer)
            {
                $is_correct=0;
                if ($request->is_correct == $answer) {
                    $is_correct=1;
                }
                Answer::insert([
                    'question_id'=>$questionId,
                    'answer'=>$answer,
                    'is_correct'=>$is_correct,
                ]);
            }

            return response()->json(['success'=>true,'msg'=>'Question added Successfully']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function getQnaDetails(Request $request)
    {
        $qna=Question::where('id',$request->qid)->with('answers')->get();
        return response()->json(['data'=>$qna]);
    }

    public function deleteAns(Request $request)
    {
        Answer::where('id',$request->id)->delete();
        return response()->json(['success'=>true,'msg'=>'Answer deleted successfully']);
    }

    public function updateQna(Request $request)
    {
        try {
            Question::where('id',$request->question_id)->update([
                'question'=>$request->edit_question
            ]);


            //Old answer update
            if (isset($request->answers)) {
                
                foreach($request->answers as $key => $value){

                    $is_correct=0; 
                    if ($request->is_correct == $value) {
                        $is_correct=1;
                    }

                    Answer::where('id',$key)->update([
                        'question_id'=>$request->question_id,
                        'answer'=>$value,
                        'is_correct'=> $is_correct
                    ]);
                }
            }

            //new answer added
            if (isset($request->new_answers)) {
                
                foreach($request->new_answers as $answer){

                    $is_correct=0; 
                    if ($request->is_correct == $answer) {
                        $is_correct=1;
                    }

                    Answer::insert([
                        'question_id'=>$request->question_id,
                        'answer'=>$answer,
                        'is_correct'=> $is_correct
                    ]);
                }
            }

            return response()->json(['success'=>true,'msg'=>'Qna updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function deleteQna(Request $request)
    {
        Question::where('id',$request->id)->delete();
        Answer::where('question_id',$request->id)->delete();
        return response()->json(['success'=>true,'msg'=>'Qna deleted successfully!']);
    }

    public function importQna(Request $request){
        try {
            Excel::import(new QnaImport,$request->file('file'));
            return response()->json(['success'=>true,'msg'=>'Import Q&a successfully']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //Student dashboard
    public function studentsDashboard(){
        $students=User::where('is_admin',0)->get();
        return view('admin.studentsDashboard',compact('students'));
    }

    //Add student
    public function addStudent(Request $request)
    {
        try {
            
            $password=Str::random(8);
            User::insert([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($password)
            ]);
            
            $url=URL::to('/');

            $data['url']=$url;
            $data['name']=$request->name;
            $data['email']=$request->email;
            $data['password']=$password;
            $data['title']="Student Registration on Online Examination System";

            Mail::send('registrationMail',['data'=>$data],function($message) use($data){
                $message->to($data['email'])->subject($data['title']);
            });
            return response()->json(['success'=>true,'msg'=>'Student Added successfully']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //Update Student
    public function editStudent(Request $request)
    {
        try {
            
           $user=User::find($request->id);

           $user->name=$request->edit_name;
           $user->email=$request->edit_email;
           $user->save();
            
            $url=URL::to('/');

            $data['url']=$url;
            $data['name']=$request->edit_name;
            $data['email']=$request->edit_email;

            $data['title']="Student Profile Updated on Online Examination System";

            Mail::send('updateProfileMail',['data'=>$data],function($message) use($data){
                $message->to($data['email'])->subject($data['title']);
            });
            return response()->json(['success'=>true,'msg'=>'Student Updated successfully']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //Delete Student
    public function deleteStudent(Request $request)
    {
        try {
            User::where('id',$request->student_id)->delete();
            return response()->json(['success'=>true,'msg'=>'Student deleted successfully!']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //Get question in exam
    public function getQuestions(Request $request){
        try {
           
            $questions=Question::all();
            if (count($questions)>0) {
                $data=[];
                $counter=0;
                foreach($questions as $question)
                {
                    $qnaExam=QnaExam::where(['exam_id'=>$request->exam_id,'question_id'=>$question->id])->get();
                    if (count($qnaExam)==0) {
                        $data[$counter]['id']=$question->id;
                        $data[$counter]['questions']=$question->question;
                        $counter++;
                    }
                }
                return response()->json(['success'=>true,'msg'=>'Question data','data'=>$data]);
            }
            else {
                return response()->json(['success'=>false,'msg'=>'Questions not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function addQuestions(Request $request)
    {
        try {
            
            if (isset($request->questions_ids)) {
                foreach ($request->questions_ids as $qid) {
                    QnaExam::insert([
                        'exam_id'=>$request->exam_id,
                        'question_id'=>$qid
                    ]);
                }
            }
            return response()->json(['success'=>true,'msg'=>'Questions added succesfully']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function getExamQuestions(Request $request)
    {
        try {
            
            $data=QnaExam::where('exam_id',$request->exam_id)->with('question')->get();
            return response()->json(['success'=>true,'msg'=>'Questions Details','data'=>$data]);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function deleteExamQuestions(Request $request)
    {
        try {
            
            $data=QnaExam::where('id',$request->id)->delete();
            return response()->json(['success'=>true,'msg'=>'Questions deleted']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }


}
