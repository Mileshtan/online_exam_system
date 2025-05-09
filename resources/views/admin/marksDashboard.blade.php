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
                    </tr>
                @endforeach
           @else
            <tr>
                <td colspan="5">Exams not added!</td>
            </tr>
           @endif
        </tbody>
    </table>









@endsection
