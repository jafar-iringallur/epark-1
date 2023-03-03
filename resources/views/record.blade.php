@include('layout.header')
<div class="row">
<div class="col-md-6">
</div>
<div class="col-md-6">
  <select id="record-type" name="record-type" onchange="changeType()" style="margin-right:3%;width:30%;float:right;">
  <option value="">Type </option>
    <option value="ml">ML</option>
    <option value="en">Lang</option>
    <option value="research">Research</option>
</select>
</div>
 
</div>

<div class="container-fluid py-4" style="padding-bottom:5%">
    
    <div class="row">

        <div class="col-md-5 mt-4">
            <div class="card h-100 mb-4">
                <!-- <div class="card-header pb-0 px-3">
            <h6 class="mb-0">New Record</h6>
            </div> -->
                <div class="card-body pt-4 p-3">
                    <form id="record_form" method="POST" action="">
                        @csrf
                        <input type="hidden" name="type" id="type" value="{{$type}}">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Member</label>
                            <select id="selMember" class="form-control" name="member" required
                                onchange="selectMember()">
                                <option value='0'>-- Select a Member --</option>
                                @foreach($members as $member)
                                <option value="{{$member->id}}">{{$member->member_id}} - {{$member->name}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group" id="bookSelection" style="display:none">
                            <label for="exampleInputEmail1">Book</label><br>
                            <select id="selBook" class="form-control" name="book" required>
                                <option value='0'>-- Select a Book --</option>
                                @foreach($books as $book)
                                <option value="{{$book->id}}">{{$book->book_id}} - {{$book->name}}</option>
                                @endforeach
                            </select>
                            <br><br><br>
                            <div class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-sm">Book Details</h6>
                                    <span class="mb-2 text-xs">Name: <span id="bookName"
                                            class="text-dark font-weight-bold ms-sm-2"></span></span>
                                    <span class="mb-2 text-xs">Author: <span id="bookAuthor"
                                            class="text-dark ms-sm-2 font-weight-bold"></span></span>
                                    <span class="text-xs">Category: <span id="bookCategory"
                                            class="text-dark ms-sm-2 font-weight-bold"></span></span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-sm  btn-success  btn-round mt-2 mb-0 me-1 ml-3"
                                id="submit">
                                <span class="spinner-border spinner-border-sm" role="status" id="loading"
                                    style="display:none"></span>
                                <span id="submit_text">Submit</span></button>
                        </div>



                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7 mt-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Details</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <ul class="list-group">
                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-3 text-sm">Member Details</h6>
                                <span class="mb-2 text-xs">Name: <span id="memberName"
                                        class="text-dark font-weight-bold ms-sm-2"></span></span>
                                <span class="mb-2 text-xs">Place: <span id="memberPlace"
                                        class="text-dark ms-sm-2 font-weight-bold"></span></span>
                                <span class="text-xs">Batch: <span id="memberBatch"
                                        class="text-dark ms-sm-2 font-weight-bold"></span></span>
                            </div>

                        </li>
                        <div class="card-header pb-0 px-3" id="prev-head" style="display:none">
                    <h6 class="mb-0">Previous Record</h6>
                </div>
                <div id="record-items">
                    
</div>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
<div style="margin-bottom:5%;"></div>
<Script>

function changeType(){
  var type = $('#record-type').val();
  if(type == 'ml'){
    window.location.replace("{{route('admin.records','ml')}}");
  }
  else if(type == 'en'){
    window.location.replace("{{route('admin.records','en')}}");
  }
  else{
    window.location.replace("{{route('admin.records','research')}}");
  }
}

function selectMember() {
    var id = $('#selMember').val();
    var type = $('#type').val();
    $.ajax({
        url: "{{route('admin.records.getmember',$type)}}",
        data: {
            "_token": "{{ csrf_token() }}",
            "id": id
        },
        method: "post",
        success: function(response) {
          $('#record-items li').remove();
          $('#prev-head').hide();
            $('#memberName').text(response.name);
            $('#memberPlace').text(response.place);
            $('#memberBatch').text(response.batch);
            if (response.record != '') {
              $('#prev-head').show();
              $('#bookSelection').hide();
                $.each(response.record, function(key,value){
                  if(value.status != 0){
                    $('#bookSelection').show();
                    $('#record-items').append(`<li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                      <div class="d-flex flex-column">
                      <span class="mb-2 text-xs">Book: 
                      <span class="text-dark ms-sm-2 font-weight-bold">`+value.book+`</span></span>
                      <span class="mb-2 text-xs">Take Date: 
                      <span class="text-dark font-weight-bold ms-sm-2">`+value.created_at+`</span></span>
                      <span class="text-xs">Closed Date: 
                      <span class="text-dark ms-sm-2 font-weight-bold">`+value.updated_at+`</span></span>
                      </div></li>`);
                  }
                  else{
                    console.log(value);
                    if(value.type == 2){
                      $('#bookSelection').show();
                    }
                    else{
                      $('#bookSelection').hide();
                    }                   
                    $('#record-items').append(`<li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                      <div class="d-flex flex-column">
                      <span class="mb-2 text-xs">Book: 
                      <span class="text-dark ms-sm-2 font-weight-bold">`+value.book+`</span></span>
                      <span class="mb-2 text-xs">Take Date: 
                      <span class="text-dark font-weight-bold ms-sm-2">`+value.created_at+`</span></span>
                      <span class="text-xs">Closed Date: 
                      <span class="text-dark ms-sm-2 font-weight-bold"></span></span>
                      <div id="tranClose">
                      <span class="text-xs">Fine: 
                      <input type="text" id="fine" value="0" name="fine" style="width:40px"></span><br>
                      <button onclick="closeRecord(`+value.id+`)" class="btn btn-sm  btn-danger  btn-round mt-2 mb-0 me-1 ml-3" style="padding: 0.3rem 1rem;">
                      <span class="spinner-border spinner-border-sm" role="status" id="loading" style="display:none"></span>
                      <span id="">Mark as Closed</span></button>
                      <button onclick="renewRecord(`+value.id+`)" class="btn btn-sm  btn-success  btn-round mt-2 mb-0 me-1 ml-3" style="padding: 0.3rem 1rem;">
                      <span class="spinner-border spinner-border-sm" role="status" id="loading" style="display:none"></span>
                      <span id="">Renew</span></button>
                      </div></div></li>`);
                  }
                });
            } else {
               $('#prev-head').hide();
                $('#bookSelection').show();
            }
        },
        error: function(err) {
            alert(err);
        }
    });
}
$('#selBook').change(function() {
    var id = $('#selBook').val();
    $.ajax({
        url: "{{route('admin.records.getbook',$type)}}",
        data: {
            "_token": "{{ csrf_token() }}",
            "id": id
        },
        method: "post",
        success: function(response) {
            $('#bookName').text(response.name);
            $('#bookAuthor').text(response.author);
            $('#bookCategory').text(response.category);
        },
        error: function(err) {
            alert(err);
        }
    });
});
$('#record_form').submit(function() {
    $('#loading').show();
    $('#submit_text').text('loading');
    $.ajax({

        url: "{{route('admin.records.save',$type)}}",
        data: $("#record_form").serialize(),
        method: "post",
        success: function(response) {
            $("#loading").hide();
            if (response.success == true) {
                Swal.fire(
                    'Done !',
                    'Record added successfully',
                    'success'
                );
            }
        },
        error: function(err) {
            $("#loading").hide();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!'
            });
        }
    });
});

function closeRecord(id) {
    $('#loading').show();
    var fine = $('#fine').val();

    $.ajax({
        url: "{{route('admin.records.close',$type)}}",
        data: {
            "_token": "{{ csrf_token() }}",
            "id": id,
            "fine": fine
        },
        method: "post",
        success: function(response) {
            $('#loading').hide();
            Swal.fire(
                'Done !',
                'Record closed successfully',
                'success'
            );
            selectMember();
        },
        error: function(err) {
            alert(err);
        }
    });
}

function renewRecord(id) {
    $('#loading').show();
    var fine = $('#fine').val();
    $.ajax({
        url: "{{route('admin.records.renew',$type)}}",
        data: {
            "_token": "{{ csrf_token() }}",
            "id": id,
            "fine": fine
        },
        method: "post",
        success: function(response) {
            $('#loading').hide();
            Swal.fire(
                'Done !',
                'Record renewed successfully',
                'success'
            );
            location.reload();
        },
        error: function(err) {
            alert(err);
        }
    });
}
</script>


@include('layout.footer')