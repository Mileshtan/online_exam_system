@extends('layout.student-layout')
@section('space-work')
    <h2>Exams</h2>
    <table class="table">
        <thead>
            <th>#</th>
            <th>Exam Name</th>
            <th>Subject Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Total Attempt</th>
            <th>Available Attempt</th>
            <th>Exam Link</th>
        </thead>
        <tbody>
            @if(count($exams)>0)
                @php $count=1; @endphp
                @foreach($exams as $exam)
                    <tr>
                        <td>{{$count++}}</td>
                        <td>{{$exam->exam_name}}</td>
                        <td>{{$exam->subjects[0]['subject']}}</td>
                        <td>{{$exam->date}}</td>
                        <td>{{$exam->time}} Hrs</td>
                        <td>{{$exam->attempt}} Time</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8">
                        No Exam Available
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection