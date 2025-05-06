@extends('layout.layout-common')
@section('space-work')
    <div class="container">
        <p style="color:black;">Welcome, {{Auth::user()->name}}</p>
        <h1 class="text-center">{{$exam[0]['exam_name']}}</h1>
        @php $qcount=1; @endphp
        @if($success == true)
            @if(count($qna)>0)
                <form action="" method="post" class="mb-5" onsubmit="return isValid()">
                    <input type="hidden" name="exam_id" id="exam_id" value="{{$exam[0]['id']}}">
                    
                    @foreach($qna as $data)
                        <div>
                            <h5>Q {{$qcount++}}. {{$data['question'][0]['question']}}</h5>
                            <input type="hidden" name="q[]" id="" value="{{$data['question'][0]['id']}}">
                            <input type="hidden" name="ans_{{$qcount-1}}" id="ans_{{$qcount-1}}">
                            @php $acount=1; @endphp
                            @foreach($data['question'][0]['answers'] as $answer)
                                <p>
                                    <b>{{$acount++}}). </b> {{$answer['answer']}}
                                    <input type="radio" name="radio_{{$qcount-1}}" value="{{$answer['id']}}" class="select_ans" data-id="{{$qcount-1}}">
                                </p>
                            @endforeach
                            <br>
                        </div>
                    @endforeach
                    <div class="text-center">
                        <input type="submit" class="btn btn-info">
                    </div>
                </form>
            @else
                <h3 style="color:red;" class="text-center">Question and answer not available</h3>
            @endif
        @else
            <h3 style="color:red;" class="text-center">{{$msg}}</h3>
        @endif
    </div>

    <script>
        $(document).ready(function(){
            $('.select_ans').click(function(){
                var no=$(this).attr('data-id');
                $('#ans_'+no).val($(this).val());
            });

            
        });
        function isValid(){
            var result=true;    
            var qlength=parseInt("{{$qcount}}")-1;
            $('.error_msg').remove();
            // console.log(qlength);
            for (let i = 1; i <= qlength; i++) {
                if ($('#ans_'+i).val()=="") {
                    result=false;
                    $('#ans_'+i).parent().append('<span style="color:red;" class="error_msg">Please select anyone answer</span>');
                    setTimeout(() => {
                        $('.error_msg').remove();
                    }, 5000);
                }
                
            }
            return result;
        }
    </script>
@endsection