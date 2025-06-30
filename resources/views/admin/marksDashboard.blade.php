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
                <th scope="col">Passing Marks</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
        <tbody>
           @if(count($exams)>0)
                @php
                    $x = $exams->firstItem();
                @endphp
                @foreach($exams as $exam)
                    <tr>
                        <td>{{$x ++}}</td>
                        <td>{{$exam->exam_name}}</td>
                        <td>{{$exam->marks}}</td>
                        <td>{{count($exam->getQnaExam) * $exam->marks}}</td>
                        <td>{{$exam->pass_marks}}</td>
                        <td>
                            <button class="btn btn-primary editMarks" data-toggle="modal" data-target="#editMarksModal" data-id="{{$exam->id}}" data-marks="{{$exam->marks}}" data-totalq="{{count($exam->getQnaExam)}}" data-pass-marks="{{$exam->pass_marks}}">Edit</button>
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
    <div class="d-flex justify-content-center">
        {{ $exams->links() }}
    </div>


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
                       
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label for="">Marks/Q</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="hidden" name="exam_id" id="exam_id">
                                <input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57 ||event.charCode ==46" name="marks" id="marks" placeholder="Enter Marks per Question">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label for="">Total Marks</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" id="tmarks" disabled placeholder="Total Marks">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label for="">Pass Marks</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57 ||event.charCode ==46" name="pass_marks" id="pass_marks" placeholder="Enter Pass Marks per Question">
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

                $('#pass_marks').val($(this).attr('data-pass-marks'));
            });

            $('#marks').keyup(function(){

                $('#tmarks').val(($(this).val() * totalQna).toFixed(1));

            });

            $('#pass_marks').keyup(function(){

                $('.pass-error').remove();
                var tmarks=$('#tmarks').val();
                var pmarks=$(this).val();

                if (parseFloat(pmarks) >= parseFloat(tmarks)) {
                    $(this).parent().append('<p style="color:red;" class="pass-error">Pass Marks cannot be greater than total marks!</p>');
                    setTimeout(() => {
                        $('.pass-error').remove();
                    }, 2000);
                }
            });

            $('#editMarks').submit(function(){
                event.preventDefault();
                $('.pass-error').remove();
                var tmarks=$('#tmarks').val();
                var pmarks=$('#pass_marks').val();

                if (parseFloat(pmarks) >= parseFloat(tmarks)) {
                    $('#pass_marks').parent().append('<p style="color:red;" class="pass-error">Pass Marks cannot be greater than total marks!</p>');
                    setTimeout(() => {
                        $('.pass-error').remove();
                    }, 2000);

                    return false;
                }



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
