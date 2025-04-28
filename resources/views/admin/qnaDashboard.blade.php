@extends('layout/admin-layout')

@section('space-work')
    <h2>Q&A</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addQnaModal">
        Add Q&A
    </button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Question</th>
                <th scope="col">Answer</th>
            </tr>
        </thead>
        <tbody>
            @if(count($questions)>0)
                @foreach($questions as $question)
                <tr>
                    <th scope="row">{{$question->id}}</th>
                    <td>{{$question->question}}</td>
                    <td>
                        <a href="#" class="ansButton" data-id="{{$question->id}}" data-toggle="modal" data-target="#showAnsModal">See Answer</a>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Questions $ Answer not found</td>
                </tr>
            @endif
        </tbody>
    </table>
     <!-- Add Exam Modal -->
     <div class="modal fade" id="addQnaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Q&A</h5>
                    <button id="addAnswer" class="ml-5 btn btn-info">Add Answer</button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="addQna">
                    @csrf
                    <div class="modal-body">
                        <div class="row answers">
                            <div class="col">
                                <input type="text" id="question" name="question" class="w-100" placeholder="Enter Exam" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color:red;"></span>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Q&A</button>
                    </div> 
                </form>
                
            </div>
        </div>
    </div>

     <!-- Show Answer Modal -->
     <div class="modal fade" id="showAnsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Show Answer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Answer</th>
                                <th scope="col">Is Correct</th>
                            </tr>
                        </thead>
                        <tbody class="showAnswers">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <span class="error" style="color:red;"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div> 
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function(){
        //form submission
        $("#addQna").submit(function(e){
            e.preventDefault();
            if ($(".answers").length < 2) {
                $(".error").text("Please add mininum two answers.")
                setTimeout(function(){
                    $(".error").text("");
                },2000);
            } else {
                var checkIsCorrect=false;
                for (let i = 0; i < $(".is_correct").length; i++) {
                    if ($(".is_correct:eq("+i+")").prop('checked') == true) {

                        checkIsCorrect=true;
                        $(".is_correct:eq("+i+")").val( $(".is_correct:eq("+i+")").next().find('input').val() );
                    }
                }
                if (checkIsCorrect) {
                    var formData=$(this).serialize();
                    $.ajax({
                        url:"{{route('addQna')}}",
                        type:"POST",
                        data:formData,
                        success:function(data){
                            console.log(data);
                            if (data.success == true) {
                                location.reload();
                            }
                            else{
                                alert(data.msg);
                            }
                        }
                    });



                } else {
                    $(".error").text("Please select any correct answer.")
                    setTimeout(function(){
                        $(".error").text("");
                    },2000);
                }
            }
        });

        //add answers
        $("#addAnswer").click(function(){

            if ($(".answers").length > 6) {
                $(".error").text("You can add maximum 6 answers.")
                setTimeout(function(){
                    $(".error").text("");
                },2000);
            } else {
                var html =`
                <div class="row mt-2 answers">
                    <input type="radio" name="is_correct" class="is_correct">
                    <div class="col">
                        <input type="text" name="answers[]" required class="w-100" placeholder="Enter Answer">
                    </div>
                    <button class="btn btn-danger removeButton">Remove</button>
                </div>
            `;
            $(".modal-body").append(html);
            }
        });

        $(document).on("click",".removeButton",function(){
            $(this).parent().remove();
        });

        //Show Answer
        $(".ansButton").click(function(){
            var questions=@json($questions);
            var qid=$(this).attr("data-id");
            var html='';

            for (let i = 0; i < questions.length; i++) {
                if (questions[i]['id'] == qid) {
                    
                    var answersLength=questions[i]['answers'].length;
                    for (let j = 0; j < answersLength; j++) {
                        let is_correct='No';
                        if (questions[i]['answers'][j]['is_correct'] == 1) {
                            is_correct='Yes';
                        }
                        html +=`
                            <tr>
                                <td>`+(j+1)+`</td>
                                <td>`+questions[i]['answers'][j]['answer']+`</td>
                                <td>`+is_correct+`</td>
                            </tr>
                        `;                 
                    }
                    break;
                }
            }

            $('.showAnswers').html(html);
        });
    });
</script>


@endsection
