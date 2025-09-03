@extends('influencer.layout.main')
@section('content')
<style>
  .nav-tabs {
      display: flex;
      justify-content: center !important;
      border-bottom-color: #efefef00 !important;
      background-color: #ffffff;
      padding: 10px;
      box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
      border-radius: 40px;
  }
  .nav-tabs .nav-item button {
      padding: 5px 20px;
      /* background-color: #2979ff; */
      color: #838383;
      border-radius: 20px;
      margin: 10px;
  }
  .nav-tabs .nav-item button:hover {
      background-color: #2979ff;
      color: #ffffff;
  }
  .nav-tabs .nav-item .active {
      padding: 5px 20px;
      background-color: #2979ff;
      color: #ffffff;
      border-radius: 20px;
      margin: 10px;
  }
</style>
    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif


    @if (session()->has('error'))
        <script>
            Swal.fire({
                position: "center",
                icon: "error",
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    
    <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-6">
              <h3>Support Ticket</h3>
            </div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">                                       
                    <svg class="stroke-icon">
                      <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use>
                    </svg></a></li>
                <li class="breadcrumb-item">Tickets</li>
                <li class="breadcrumb-item active"> Ticket List</li>
              </ol>
            </div>
          </div>
        </div>
      </div>


      <!-- Container-fluid starts-->
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="py-2">

              <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="open-tab" data-bs-toggle="tab" data-bs-target="#open" type="button" role="tab" aria-controls="open-tab" aria-selected="false">Open</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="solved-tab" data-bs-toggle="tab" data-bs-target="#solved" type="button" role="tab" aria-controls="solved-tab" aria-selected="false">Solved</button>
                  </li>
              </ul>


              
              <div class="card tab-content mt-4" id="myTabContent">
                    <div class="tab-pane fade show active" id="open" role="tabpanel" aria-labelledby="open-tab">
          
                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="display" id="data-source-1" style="width:100%">
                            <thead>
                              <tr>
                                <th>Sr. No.</th>
                                <th>Ticket ID</th>
                                <th>Subject</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Created On</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($ticket_list as $list)
                                    <tr>
                                        <td class="ticketlistborder">{{ $i }}</td>@php $i++; @endphp
                                        <td class="ticketlistborder">{{ $list->ticket_id }}</td>
                                        <td class="ticketlistborder">{{ $list->title }}</td>
                                        <td class="ticketlistborder">{{ $list->ticket_type }}</td>
                                        <td class="ticketlistborder" style="text-align: center;">
                                            {!! \Illuminate\Support\Str::limit($list->desc, 20) !!}
                                        </td>
                                        <td class="ticketlistborder">{{ date('F d, Y', strtotime($list->created_at)) }}</td>
                                        <td class="d-flex ticketlistborder">
                                            @if ($list->status == 1)
                                                <button type="button" class="btn btn-success" onclick="closeTicket({{ $list->id }})"><i class="fa fa-check"></i></button>
                                                <form id="close-ticket-form{{ $list->id }}" action="{{ route('influencer.close.ticket') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $list->id }}">
                                                </form>
                                            @endif
                                                &nbsp;
                                                <a href="{{ route('influencer.reply.ticket', $list->ticket_id) }}">
                                                  <button class="btn btn-primary"><i class="fa fa-commenting"></i></button>
                                                </a>
        
                                                &nbsp;
                                                <button type="button" class="btn btn-danger" onclick="deleteTicket({{ $list->id }})"><i class="fa fa-trash"></i></button>
                                                <form id="delete-ticket-form{{ $list->id }}" action="{{ route('influencer.delete.ticket') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $list->id }}">
                                                </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @if (count($ticket_list) > 0)
                            <tfoot>
                                <tr>
                                  <th>Sr. No.</th>
                                  <th>Ticket ID</th>
                                  <th>Subject</th>
                                  <th>Type</th>
                                  <th>Description</th>
                                  <th>Created On</th>
                                  <th>Action</th>
                                </tr>
                            </tfoot>
                            @endif
                          </table>
                        </div>
                      </div>

                    </div>

                    <div class="tab-pane fade" id="solved" role="tabpanel" aria-labelledby="solved-tab">
          
                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="display" id="data-source-2" style="width:100%">
                            <thead>
                              <tr>
                                <th>Sr. No.</th>
                                <th>Ticket ID</th>
                                <th>Subject</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Created On</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($solved_ticket_list as $list)
                                    <tr>
                                        <td class="ticketlistborder">{{ $i }}</td>@php $i++; @endphp
                                        <td class="ticketlistborder">{{ $list->ticket_id }}</td>
                                        <td class="ticketlistborder">{{ $list->title }}</td>
                                        <td class="ticketlistborder">{{ $list->ticket_type }}</td>
                                        <td class="ticketlistborder" style="text-align: center;">
                                            {!! \Illuminate\Support\Str::limit($list->desc, 20) !!}
                                        </td>
                                        <td class="ticketlistborder">{{ date('F d, Y', strtotime($list->created_at)) }}</td>
                                        <td class="d-flex ticketlistborder">
                                                
                                              <a href="{{ route('influencer.reply.ticket', $list->ticket_id) }}">
                                                <button class="btn btn-primary"><i class="fa fa-commenting"></i></button>
                                              </a>
                                              &nbsp;
        
                                              <button type="button" class="btn btn-danger" onclick="deleteTicket({{ $list->id }})"><i class="fa fa-trash"></i></button>
                                              <form id="delete-ticket-form{{ $list->id }}" action="{{ route('influencer.delete.ticket') }}" method="POST" style="display: none;">
                                                  @csrf
                                                  <input type="hidden" name="id" value="{{ $list->id }}">
                                              </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @if (count($ticket_list) > 0)
                            <tfoot>
                                <tr>
                                  <th>Sr. No.</th>
                                  <th>Ticket ID</th>
                                  <th>Subject</th>
                                  <th>Type</th>
                                  <th>Description</th>
                                  <th>Created On</th>
                                  <th>Action</th>
                                </tr>
                            </tfoot>
                            @endif
                          </table>
                        </div>
                      </div>

                    </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- Container-fluid Ends-->
      
    <script>
        function closeTicket(ticketId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to close this ticket?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, close it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('close-ticket-form' + ticketId).submit();
                }
            });
        }

        function deleteTicket(ticketId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-ticket-form' + ticketId).submit();
                }
            });
        }
    </script>
@endsection
