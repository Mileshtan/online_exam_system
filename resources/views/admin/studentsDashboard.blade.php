@extends('layout/admin-layout')

@section('space-work')
    <h2>Students</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">
        Add Student
    </button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Edit</th> 
                <!-- <th scope="col">Delete</th> -->
            </tr>
        </thead>
        <tbody>
            @if(count($students)>0)
                @foreach($students as $student)
                <tr>
                    <th scope="row">{{$student->id}}</th>
                    <td>{{$student->name}}</td>
                    <td>{{$student->email}}</td>
                    <td>
                        <button type="button" class="btn btn-info editButton" data-id="{{$student->id}}" data-name="{{$student->name}}" data-email="{{$student->email}}" data-toggle="modal" data-target="#editStudentModal">
                            Edit
                        </button>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Students not found</td>
                </tr>
            @endif
        </tbody>
    </table>

     <!-- Add Student Modal -->
     <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="addStudent">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="text" id="name" name="name" class="w-100" placeholder="Enter Student Name" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input type="email" id="email" name="email" class="w-100" placeholder="Enter Student Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary addButton">Add Student</button>
                    </div> 
                </form>
                
            </div>
        </div>
    </div>



      <!-- Edit Student Modal -->
      <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="editStudent">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="id" id="id">
                                <input type="text" id="edit_name" name="edit_name" class="w-100" placeholder="Enter Student Name" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input type="email" id="edit_email" name="edit_email" class="w-100" placeholder="Enter Student Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary updateButton">Update Student</button>
                    </div> 
                </form>
                
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function(){
            //Add student
            $("#addStudent").submit(function(e){
                e.preventDefault();
                $('.addButton').prop('disabled',true);
                var formData=$(this).serialize();

                $.ajax({
                    url:"{{route('addStudent')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        // console.error("AJAX Error:", xhr.responseText);
                        alert("Something went wrong. See console for details.");
                    }
                });



            });

            //Edit button click and show values
            $(".editButton").click(function(){

                $("#id").val($(this).attr('data-id'));
                $("#edit_name").val($(this).attr('data-name'));
                $("#edit_email").val($(this).attr('data-email'));

            });

            //Update Student
            $("#editStudent").submit(function(e){
                e.preventDefault();
                $('.updateButton').prop('disabled',true);
                var formData=$(this).serialize();

                $.ajax({
                    url:"{{route('editStudent')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        // console.error("AJAX Error:", xhr.responseText);
                        alert("Something went wrong. See console for details.");
                    }
                });
            });

        });
    </script>

@endsection
