@extends('business.layout.main')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

@if (session()->has('success'))
<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Contract List</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">
                            <svg class="stroke-icon">
                                <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                </use>
                            </svg></a></li>
                    <li class="breadcrumb-item"> Dashboard</li>
                    <li class="breadcrumb-item active">Contract List</li>
                </ol>
            </div>
        </div>
    </div>
</div>


          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="display" id="basic-1">
                        <thead>
                          <tr>
                            <th>Sl. No.</th>
                            <th>Title</th>
                            <th>Agreement With</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                        @foreach($contract_list as $list)
                        @php
                            $user = \App\Models\User::where('id', $list->person_two)->first();
                        @endphp
                          <tr>
                            <td>{{ $i }}.</td>
                            @php $i++; @endphp
                            <td>{{ $list->title }}</td>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>
                                @if($list->status == 1)
                                    <span class="badge badge-warning">In Progress</span>
                                @elseif($list->status == 2)
                                    <span class="badge badge-success">Confirmed</span>
                                @else
                                    <span class="badge badge-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ date('F d, Y', strtotime($list->created_at)) }}</td>
                            <td class="d-flex">                          
                                <button class="btn btn-success dropdown-toggle" id="btnGroupVerticalDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                  <a href="{{ route('business.make.contract', $list->id) }}" class="dropdown-item">Viw or Edit Contract</a>
                                    @if($list->status == 2)
                                      <a href="{{ route('business.contract.workstatus', $list->id) }}" class="dropdown-item">Work Status</a>
                                      <a href="{{ route('business.download.contract', $list->id) }}" target="_blank" class="dropdown-item">Download Contract</a>
                                    @endif
                                </div>
                            </td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>
          </div>
          <!-- Container-fluid Ends-->
@endsection
