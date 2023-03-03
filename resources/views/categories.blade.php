@include('layout.header')

<div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0"> 
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                   
                    </div>
                    <div class="col-6 text-end">
                      <a class="btn bg-gradient-dark mb-0" href="/books/add"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add New Book</a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-2 pb-2">
            <div class="row p-3">
        @foreach($data as $category)
                <div class="col-md-4 mb-3">
                  <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                    <a href="/booklist/{{$category['id']}}"><h6 class="mb-0">{{$category['name']}}</h6></a>
                  </div>
                </div>
           @endforeach
              </div>


            </div>
          </div>
        </div>
      </div>
      @include('layout.footer')
