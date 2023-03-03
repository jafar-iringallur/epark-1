@include('layout.header')

<div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0"> 
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                    <input class="form-control" id="myInput" type="text" placeholder="Search..">
                    </div>
                   
                </div>
            </div>
            <div class="card-body px-0 pt-2 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Book Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Author</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Taken Date</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Closed Date</th>
                   
                    </tr>
                  </thead>
                  <tbody id="myTable">
                  @foreach($records as $record)
                    <tr>
                        <td>
                        <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">{{$record->book}}<h6>
                        </div>
                        </td>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <p class="text-xs font-weight-bold mb-0">{{$record->author}}</p>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$record->category}}</p>
                      </td>
                      <td>
                      @if($record->type == 1)
                        <p class="text-xs font-weight-bold mb-0">Normal</p>
                        @else
                        <p class="text-xs font-weight-bold mb-0">Research</p>
                        @endif
                      </td>
                      <td class="align-middle text-center text-sm">
                      <span class="text-secondary text-xs font-weight-bold">{{$record->created_at}}</span>
                      </td>
                      <td class="align-middle text-center">
                      @if($record->status == 1)
                      <span class="text-secondary text-xs font-weight-bold">{{$record->updated_at}}</span>
                      @else
                     <span class="badge badge-sm bg-gradient-danger" style="font-size: 0.58em;">Not Closed</span>
                      @endif
                      </td>
                   
                    </tr>
      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      @include('layout.footer')
