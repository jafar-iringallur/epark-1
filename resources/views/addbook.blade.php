@include('layout.header')

<div class="row">
<div class="col-12">
<div class="card mb-4">
<div class="card-body">
<form id="books_form" method="POST" action="">
@csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Book Id</label>
    <input type="text" class="form-control" id="id" name="book_id" aria-describedby="emailHelp" placeholder="Enter Book Id" required>
   </div>
   <div class="form-group">
    <label for="exampleInputEmail1">Book Name</label>
    <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter Book Name" required>
   </div>
   <div class="form-group">
    <label for="exampleInputEmail1">Author</label>
    <input type="text" class="form-control" id="author" name="author" aria-describedby="emailHelp" placeholder="Enter Book Author Name" required>
   </div>
   <div class="form-group">
    <label for="exampleInputEmail1">Category</label>
     <select id="categorysel" class="form-control" name="category" required>
@foreach($categories as $category)
  <option value="{{$category->id}}">{{$category->name}}</option>
  @endforeach

</select>
   </div>

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

$('#books_form').submit(function (){
    $('#loading').show();
    $('#submit_text').text('loading');
    $.ajax({
        
        url:"/books/save",
        data:$("#books_form").serialize(),
        method:"post",
        success:function (response){
         $("#loading").hide();
         if(response.success==true){
            Swal.fire(
            'Done !',
            'Book added successfully',
            'success'
            )
}
         else{
            Swal.fire(
            'Error',
            'Book Id already Used',
            'error'
            )
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
