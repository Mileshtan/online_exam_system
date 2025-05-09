@extends('layout/admin-layout')

@section('space-work')
    <h2>Marks</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Exam Name</th>
                <th scope="col">Marks/Q</th>
                <th scope="col">Total Marks</th> 
                <th scope="col">Edit</th>
            </tr>
        </thead>
        <tbody>
           @if(count($exams)>0)
                @php
                    $x=1;
                @endphp
                @foreach($exams as $exam)
                    <tr>
                        <td>{{$x ++}}</td>
                        <td>{{$exam->exam_name}}</td>
                        <td>{{$exam->marks}}</td>
                        <td>{{count($exam->getQnaExam) * $exam->marks}}</td>
                        <td>
                            <button class="btn btn-primary editMarks" data-toggle="modal" data-target="#editMarksModal" data-id="{{$exam->id}}" data-marks="{{$exam->marks}}" data-totalq="{{count($exam->getQnaExam)}}">Edit</button>
                        </td>
                    </tr>
                @endforeach
           @else
            <tr>
                <td colspan="5">Exams not added!</td>
            </tr>
           @endif
        </tbody>
    </table>



       <!-- Edit Marks Modal -->
       <div class="modal fade" id="editMarksModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Marks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editMarks">
                    @csrf
                    <div class="modal-body">
                       
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="">Marks/Q</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="hidden" name="exam_id" id="exam_id">
                                <input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57 ||event.charCode ==46" name="marks" id="marks" placeholder="Enter Marks per Question">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <label for="">Total Marks</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" id="tmarks" disabled placeholder="Total Marks">
                            </div>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Marks</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function(){
            var totalQna=0;

            $('.editMarks').click(function(){
                // console.log("ok");
                var examId=$(this).attr('data-id');
                var examMarks=$(this).attr('data-marks');
                var totalQ=$(this).attr('data-totalq');

                $('#exam_id').val(examId);
                $('#marks').val(examMarks);
                $('#tmarks').val((examMarks * totalQ).toFixed(1));

                totalQna=totalQ;
            });

            $('#marks').keyup(function(){

                $('#tmarks').val(($(this).val() * totalQna).toFixed(1));

            });

            $('#editMarks').submit(function(){
                event.preventDefault();

                var formData=$(this).serialize();
                $.ajax({
                    url:"{{route('updateMarks')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if(data.success == true)
                        {
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
