<!DOCTYPE html>
<html>
  <head>
    <title>Let IT Grow</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="{{url('logo-white.png')}}">
  </head>
<body>

<h2>Add Lecturer</h2>

<form action="{{url('store-lecturer')}}" method="post">
    @csrf
  <label for="name">Lecturer name:</label><br>
  <input type="text" id="name" name="name"><br><br>
  @error('name')
    <span style="color: red;">
        <strong>{{$message}}</strong>
    </span>
    @enderror
    <br>

  <label>Please select gender:</label><br>
  <input type="radio" name="gender" value="male">
  <label for="male">male</label><br>
  <input type="radio" name="gender" value="female">
  <label for="female">female</label><br>
  <input type="radio" name="gender" value="other">
  <label for="other">other</label><br>
@error('gender')
    <span style="color: red;">
        <strong>{{$message}}</strong>
    </span>
    @enderror
    <br>



  <label>Phone number:</label><br>
  <input type="number" id="number" name="phone_no"><br><br>
  @error('phone_no')
    <span style="color: red;">
        <strong>{{$message}}</strong>
    </span>
    @enderror
    <br>

  <label>email:</label><br>
  <input type="email" id="email" name="email"><br><br>
  @error('email')
    <span style="color: red;">
        <strong>{{$message}}</strong>
    </span>
    @enderror
    <br>

  <label for="fname">Address:</label><br>
  <input type="text" name="address"><br><br>
  @error('address')
    <span style="color: red;">
        <strong>{{$message}}</strong>
    </span>
    @enderror
    <br>

  <label for="fname">Nationality:</label><br>
  <input type="text" name="nationality"><br><br>
  @error('nationality')
    <span style="color: red;">
        <strong>{{$message}}</strong>
    </span>
    @enderror
    <br>

  <label for="fname">DOB:</label><br>
  <input type="date" name="dob"><br><br>
  @error('dob')
    <span style="color: red;">
        <strong>{{$message}}</strong>
    </span>
    @enderror
    <br>

  <label for="fname">Faculty:</label><br>
  <select id="faculty" class="form-control select2" name="faculty">
        <option disabled selected>----Select Faculty----</option>
        @foreach($finalresult['faculty'] as $f)
        <option value="{{$f['id']}}">{{$f['faculty_name']}}</option>
        @endforeach
    </select> 
    <br>
    @error('faculty')
    <span style="color: red;">
        <strong>{{$message}}</strong>
    </span>
    @enderror
    <br>

    <label for="fname">Module:</label><br>
    <select data-placeholder="Choose Modules" multiple class="chosen-select" name="module[]" id="module" style="width: 300px;">
    <option value=""></option>
    
  </select>
    <br>
    @error('faculty')
    <span style="color: red;">
        <strong>{{$message}}</strong>
    </span>
    @enderror
    <br>



  




  <input type="submit" value="Submit">
</form> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<script>
  $(".chosen-select").chosen({
    no_results_text: "Oops, nothing found!"
  })
</script>
<script>
  $('#faculty').on('change', function(){
    let faculty = $('#faculty').val()
    $.ajax({
      type:'GET',
      url:'/module/'+ faculty,
      success:function(data) {
                  $.each(data, function(index, value)
                  
                  {
                    console.log(value)
                    let option = `<option value = "${value.id}"> ${value.module_name} </option>`
                    $('#module').append(option)
                    $(".chosen-select").trigger('chosen:updated')
                  })

               }  
    })
  })
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @if (Session::has('message'))
        <script>
            swal("Thank You", "{!! Session::get('message') !!}", "success", {
                button: "OK",
            });
        </script>

    @endif

</body>
</html>