<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">
          <h1>All Students</h1>
        </div>
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addstd">Add Student</button>
        <table class="table table-bordered">
      <thead>
        <td>#</td>
        <td>Name</td>
        <td>Email</td>
      </thead>
      <tbody>
        @foreach($students as $std)
           <tr>
            <td>{{ $std->id }}</td>
            <td>{{ $std->name }}</td>
            <td>{{ $std->email }}</td>
           </tr>
        @endforeach
      </tbody>
        </table>
    </div>

          <!-- Modal for export QnA -->
          <div class="modal fade" id="addstd" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                <form id="addstudents">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Show Answers</h4>
                    </div>
                    
                    <div class="modal-body">
                       <div class="form-group">
                        <input type="text" name="name" id="" placeholder="Enter Name" required>
                       </div>
                       <div>
                        <input type="text" name="email" id="" placeholder="Enter email" required>
                       </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Add</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                 </form>
                </div>
            </div>
        </div>
    
</body>
</html>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        $("#addstudents").submit(function(e){
          e.preventDefault();

          var form = $('#addstudents')[0];
          var formData= new FormData(form);

           $.ajax({
            url: "{{ url('/add-std') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                alert("DATA ADDED");
                location.reload();
            }
           })

        })
    })
</script>