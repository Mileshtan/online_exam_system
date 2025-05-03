@extends('layout/admin-layout')

@section('space-work')
<h2>Exam</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExamModal">
        Add Exam
    </button>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Exam Name</th>
            <th scope="col">Subject</th>
            <th scope="col">Date</th>
            <th scope="col">Time</th>
            <th scope="col">Attempt</th>
            <th scope="col">Add Question</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
           @if(count($exams)>0)
                @foreach($exams as $exam)
                    <tr>
                        <td>{{$exam->id}}</td>
                        <td>{{$exam->exam_name}}</td>
                        <td>{{$exam->subjects[0]['subject']}}</td>
                        <td>{{$exam->date}}</td>
                        <td>{{$exam->time}} Hrs</td>
                        <td>{{$exam->attempt}} Time</td>
                        <td>
                            <a href="#" class="addQuestion" data-id="{{$exam->id}}" data-toggle="modal" data-target="#addQnamModal">Add Question</a>
                        </td>
                        <td>
                            <button class="btn btn-info editButton" data-id="{{$exam->id}}" data-toggle="modal" data-target="#editExamModal">Edit</button>
                        </td>
                        <td>
                            <button class="btn btn-danger deleteButton" data-id="{{$exam->id}}" data-toggle="modal" data-target="#deleteExamModal">Delete</button>
                        </td>
                    </tr>
                @endforeach
           @else
                <tr>
                    <td colspan="5">
                        Exams not found
                    </td>
                </tr>
           @endif
        </tbody>
    </table>
     <!-- Add Exam Modal -->
     <div class="modal fade" id="addExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addExam">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="exam_name" id="exam_name" placeholder="Enter Exam Name" class="w-100" required>
                        <br><br>
                        <select name="subject_id" id="subject_id" class="w-100" required>
                            <option value="">Select Subject</option>
                            @if(count($subjects)>0)
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->subject}}</option>
                                @endforeach
                            @endif
                        </select>
                        <br><br>
                        <input type="date" name="date" id="date" class="w-100" required min="@php echo date('Y-m-d'); @endphp">
                        <br><br>
                        <input type="time" name="time" id="time" class="w-100" required>
                        <br><br>
                        <input type="number" name="attempt" id="attempt" required placeholder="Enter exam attempt time" class="w-100" min="1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Exam</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>

    <!-- Edit Exam Modal -->
    <div class="modal fade" id="editExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editExam">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="exam_id">
                        <input type="text" name="exam_name" id="edit_exam_name" placeholder="Enter Exam Name" class="w-100" required>
                        <br><br>
                        <select name="subject_id" id="edit_subject_id" class="w-100" required>
                            <option value="">Select Subject</option>
                            @if(count($subjects)>0)
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->subject}}</option>
                                @endforeach
                            @endif
                        </select>
                        <br><br>
                        <input type="date" name="date" id="edit_date" class="w-100" required min="@php echo date('Y-m-d'); @endphp">
                        <br><br>
                        <input type="time" name="time" id="edit_time" class="w-100" required>
                        <br><br>
                        <input type="number" name="attempt" id="edit_attempt" required placeholder="Enter exam attempt time" class="w-100" min="1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Exam</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>


    <!-- Delete Exam Modal -->
    <div class="modal fade" id="deleteExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteExam">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="deleteExamId">
                        <p>Are you sure you want to delete exam?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete Exam</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>


     <!-- Add Qna Modal -->
     <div class="modal fade" id="addQnamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addQna">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="addExamId">
                        <input type="search" class="w-100" name="search" id="search" placeholder="Search Here">
                        <br><br>
                        <table class="table">
                            <thead>
                                <th>Select</th>
                                <th>Question</th>
                            </thead>
                            <tbody class="addBody">
                                
                            </tbody>
                        </table>
                        <!-- <br><br>
                        <select name="question" id="" multiple multiselect-search="true" multiselect-select-all="true" onchange="console.log(this.selectedOptions)">
                            <option value="1">Hi</option>
                        </select> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Question</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            //Add Exam
           $("#addExam").submit(function(e){ 
                e.preventDefault();
                var formData=$(this).serialize();
                $.ajax({
                    url:"{{route('addExam')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) {
                            
                            location.reload();
                        }
                        else{
                            alert(data.msg);
                        }
                    }
                });
           });

           //Edit Exam
           $(".editButton").click(function(){
                var id=$(this).attr('data-id');
                $("#exam_id").val(id);

                var url='{{route("getExamDetail","id")}}';
                url=url.replace('id',id);

                $.ajax({
                    url:url,
                    type:"GET",
                    success:function(data){
                        if (data.success==true) {

                            var exam=data.data;
                            $("#edit_exam_name").val(exam[0].exam_name);
                            $("#edit_subject_id").val(exam[0].subject_id);
                            $("#edit_date").val(exam[0].date);
                            $("#edit_time").val(exam[0].time);
                            $("#edit_attempt").val(exam[0].attempt);

                        } else {  
                            console.log("error");  
                            alert(data.msg);
                        }
                    }
                });
           });

           $("#editExam").submit(function(e){ 
            // console.log("ok");
                e.preventDefault();
                var formData=$(this).serialize();
                $.ajax({
                    url:"{{route('updateExam')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) {
                            
                            location.reload();
                        }
                        else{
                            alert(data.msg);
                        }
                    }
                });
           });

           //Delete Exam
           $(".deleteButton").click(function(){
                var id=$(this).attr('data-id');
                $("#deleteExamId").val(id);
           });

           $("#deleteExam").submit(function(e){ 
            // console.log("ok");
                e.preventDefault();
                var formData=$(this).serialize();
                $.ajax({
                    url:"{{route('deleteExam')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) {
                            
                            location.reload();
                        }
                        else{
                            alert(data.msg);
                        }
                    }
                });
           });


           //Add question to exam
           $('.addQuestion').click(function(){
                var id=$(this).attr('data-id');

                $("#addExamId").val(id);

                $.ajax({
                    url:"{{route('getQuestions')}}",
                    type:"GET",
                    data:{exam_id:id},
                    success:function(data){
                        if (data.success==true) {
                            var questions=data.data;
                            var html='';
                            if (questions.length > 0) {
                                for(let i=0;i<questions.length;i++)
                                {
                                    html +=`
                                        <tr>
                                            <td><input type="checkbox" value="`+questions[i]['id']+`" name="questions_ids[]"></td>
                                            <td>`+questions[i]['questions']+`</td>
                                        </tr>
                                    `;
                                }
                            }
                            else{
                                html+=`
                                    <tr>
                                        <td colspan="2">Question not available</td>
                                    </tr>
                                `;
                            }
                            $('.addBody').html(html);
                        } else {
                            alert(data.msg);
                        }
                    }
                });

           });

           $("#addQna").submit(function(e){ 
            // console.log("ok");
                e.preventDefault();
                var formData=$(this).serialize();
                $.ajax({
                    url:"{{route('addQuestions')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) {
                            
                            location.reload();
                        }
                        else{
                            alert(data.msg);
                        }
                    }
                });
           });
        });
    </script>
@endsection
