@include('layout.header')

<div class="row">
<div class="col-12">
<div class="card mb-4">
<div class="card-body">
<form id="members_form" method="POST" action="">
@csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Member Id</label>
    <input type="hidden" name="id" value="{{$data->id}}">
    <input type="text" class="form-control" id="id" name="member_id" value="{{$data->member_id}}" aria-describedby="emailHelp" placeholder="Enter Member Id" required>
   </div>
   <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{$data->name}}" aria-describedby="emailHelp" placeholder="Enter Member Name" required>
   </div>
   <div class="form-group">
    <label for="exampleInputEmail1">Place</label>
    <input type="text" class="form-control" id="author" name="place" value="{{$data->place}}" aria-describedby="emailHelp" placeholder="Enter Place" required>
   </div>
   {{-- <div class="form-group">
    <label for="exampleInputEmail1">Batch</label>
    <input type="hidden" id="select" value="{{$data->batch}}">
    <select id="batchsel" class="form-control" name="batch" required>
  <option value="Plus One">Plus One</option>
  <option value="Plus Two">Plus Two</option>
  <option value="Degree 1">Degree 1</option>
  <option value="Degree 2">Degree 2</option>
  <option value="Degree 3">Degree 3</option>
  <option value="PG 1">PG 1</option>
  <option value="PG 2">PG 2</option>
  <option value="Arabic Academy">Arabic Academy</option>
  <option value="MIGS">MIGS</option>
  <option value="Usthad">Usthad</option>
  <option value="Others">Others</option>

</select>
   </div> --}}

  <!-- <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div> -->
  <button type="submit" class="btn btn-primary" id="submit">
<span class="spinner-border spinner-border-sm" role="status" id="loading" style="display:none"></span>
<span id="submit_text">Submit</span></button>
</form>

</div>
</div>
</div>
</div>

<script>
//     var select = $('#select').val();
// $("#batchsel > option").each(function() {
//     if(this.value == select){
//         $('#batchsel > option[value="'+this.value+'"]').attr("selected","selected");
//     }
// });
$('#members_form').submit(function (){
    $('#loading').show();
    $('#submit_text').text('loading');
    $.ajax({
        
        url:"/members/update",
        data:$("#members_form").serialize(),
        method:"post",
        success:function (response){
         $("#loading").hide();
         if(response.success==true){
            Swal.fire(
            'Done !',
            'Member Updated successfully',
            'success'
            );
            window.location.replace('/members')
         }
        },
        error:function (err){
         $("#loading").hide();
         Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!'
            });
        }
    });
});

</script>
@include('layout.footer')
