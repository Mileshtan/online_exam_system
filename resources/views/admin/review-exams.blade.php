@extends('layout/admin-layout')

@section('space-work')
    <h2>Student Exam Review</h2>
    <!-- Button trigger modal -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Exam Name</th>
                <th scope="col">Status</th>
                <th scope="col">Review</th>
            </tr>
        </thead>
        <tbody>
            
            @if(count($attempts)>0)
                @php $x=1; @endphp
                @foreach($attempts as $attempt)
                    <tr>
                        <td>{{$x++}}</td>
                        <td>{{$attempt->user->name}}</td>
                        <td>{{$attempt->exam->exam_name}}</td>
                        <td>
                            @if($attempt->status == 0)
                                <span style="color:red">Pending</span>
                            @else
                                <span style="color:green">Approved</span>
                            @endif
                        </td>
                        <td>
                            @if($attempt->status == 0)
                                <a href="#">Review & Approved</a>
                            @else
                                Completed
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">
                        Student exam review not found
                    </td>
                </tr>
            @endif

        </tbody>
    </table>

@endsection