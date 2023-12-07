<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
        <style>
        tr.selected {
            background-color: #c7ecf2;
        }
    </style>
       
    </head>
    <body>
      


            <h2 class="text-center">Ball Bucket Task</h2>

            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<div class="container">
    <div class="row">
      <!-- bucket form -->
    <div class="col-sm-5 border border-dark  m-2 p-5">
    <h5 class="text-center mb-5">Create Bucket </h5>
    
    <form role="form" id="createBucketform" method="POST" action="{{ route('createBucket') }}" >
       {{ csrf_field() }}
    <div class="form-group row">
    <label for="bucketName" class="col-sm-3 col-form-label">Bucket Name</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" id="bucket-name" name="bucketName" placeholder="Enter Bucket Name" required>
     
    </div>
  </div>

  <div class="form-group row">
    <label for="bucketVolume" class="col-sm-3 col-form-label">Volume</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="bucketVolume" id="bucket-volume" placeholder="Enter Bucket Size" required>
    </div>
  </div>
  <button type="submit" class="btn btn-primary" id="bucketSubmit">Save</button>
</form>
    </div>

<!-- ball form -->
    <div class="col-sm-5 border border-dark m-2 p-5">
    <h5 class="text-center mb-5">Create Ball</h5>
    <form role="form" id="createBallform" method="POST" action="{{ route('createBall') }}" >
       {{ csrf_field() }}
    <div class="form-group row">
    <label for="name" class="col-sm-3 col-form-label">Ball Name</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" id="name" name="name" placeholder="Enter Ball Name" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="size" class="col-sm-3 col-form-label">Size</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" id="size"  name="size" placeholder="Enter Ball Size" required>
    </div>
  </div>
  <button type="submit" class="btn btn-primary ">Save</button>
</form>
    </div>
</div>

<!-- suggestion form -->




<div class="row">
      
      <div class="col-sm-5 border border-dark  m-2 p-5">
      <h5 class="text-center mb-5"> Suggest Bucket</h5>
      
      <form role="form" id="suggestform" method="POST" >
       {{ csrf_field() }}
    <table class="table table-hover" id="suggestTable">
        <thead>
            <tr>
                <th>Ball</th>
                <th>Quantity</th>
               
               
            </tr>
        </thead>
        <tbody>

        
        @foreach($balls->groupBy('color') as $color => $groupedBalls)
        <tr class="selectable-row" >
        <td>{{ $color }}</td>
        <td>{{  $groupedBalls->count()}}</td>
         
         </tr>
       
    @endforeach

          
        </tbody>

        
    </table>

    <button type="submit"  id="SuggestButton" class="btn btn-primary ">Suggest</button>
    <p>(Click on table row to suggest balls)<p>
</form>
      </div>
    
      <div class="col-sm-5 border border-dark  m-2 p-5">


<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                 <th>Bucket Name</th>
                   
                 <th>Balls Details</th>
                </tr>
            </thead>
            <tbody>
             @foreach($buckets as $bucket)
               @if($bucket->balls->count() > 0)
                 <tr>
                <td>{{ $bucket->name }}</td>
                            
                 <td>
                <ul>
                 @foreach($bucket->balls as $ball)
                 <li>{{ $ball->color }} -  {{ $ball->pivot->quantity }}</li>
                                       
                 @endforeach
                </ul>
                 </td>
                 </tr>
                 @endif
                @endforeach
             </tbody>
             </table>
    </div>
</div>
 </div>
</div>
</div>
   
            
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
   $(document).ready(function () {
$('#suggestTable tbody').on( 'click', 'tr', function () {
 
  $(this).toggleClass('selected');
} );

} );


$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).ready(function () {
    $('#suggestform').submit(function (e) {
        e.preventDefault(); 

        const selectedRows = $('.selectable-row.selected');

    
        const selectedBalls = selectedRows.map(function () {
            return $(this).find('td:first-child').text();
        }).get();
        
        const quantity = selectedRows.map(function () {
            return $(this).find('td:last-child').text();
        }).get();
        var token = $('meta[name="csrf-token"]').attr('content');
       
        const selectedBallsJSON = JSON.stringify(selectedBalls);


           

      
        $.ajax({
            type: 'POST',
            url: '{{ route('storeSuggestedBalls') }}',
        
            data: { selectedBalls: selectedBallsJSON ,
              quantity: quantity,
              _token: token,},
            dataType: 'json',
           
            success: function (response) {
                console.log("response");
                toastr.success(response.message);
                 window.setTimeout(function () {
                   
                    location.reload();
                }, 3000);
                
            },
            error: function (error) {
                console.error(error);
            
                toastr.error(error.message);
            }
        });
    });

  });

        </script>
    </body>
</html>
