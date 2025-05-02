@extends('layout/admin-layout')

@section('space-work')
    <h2>Students</h2>
    <!-- Button trigger modal -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <!-- <th scope="col">Edit</th>
                <th scope="col">Delete</th> -->
            </tr>
        </thead>
        <tbody>
            @if(count($students)>0)
                @foreach($students as $student)
                <tr>
                    <th scope="row">{{$student->id}}</th>
                    <td>{{$student->name}}</td>
                    <td>{{$student->email}}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Students not found</td>
                </tr>
            @endif
        </tbody>
    </table>

@endsection
