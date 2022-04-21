<!DOCTYPE html>
<html>
<head>
    <title>Let IT Grow</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{url('logo-white.png')}}">
</head>
<body>
    
    <div class="container mt-5">
        <h2 class="mb-4">Lecturer's List</h2> <br>
        <span data-href="/csv" id="export" class="btn btn-success btn-sm" onclick="exportTasks(event.target);">Export</span>
        <button><a href="{{url('/add-lecturer')}}">Add Lecturer</a></button>
        <table class="table table-bordered yajra-datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Nationality</th>
                    <th>DOB</th>
                    <th>Faculty</th>
                    <th>Modules</th>


                </tr>
            </thead>
            <tbody>
                @foreach($lecturer as $l)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$l->lecturer_name}}</td>
                    <td>{{$l->email}}</td>
                    <td>{{$l->gender}}</td>
                    <td>{{$l->phone_no}}</td>
                    <td>{{$l->address}}</td>
                    <td>{{$l->nationality}}</td>
                    <td>{{$l->dob}}</td>
                    <td>{{$l->faculty}}</td>
                    <td>{{$l->module}}</td>
                </tr>
                @endforeach
            </tbody>  
        </table> 
    </div>
    {{ $lecturer->links() }}
  
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
   function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>
    @if (Session::has('message'))
        <script>
            swal("Thank You", "{!! Session::get('message') !!}", "success", {
                button: "OK",
            });
        </script>

    @endif


</html>