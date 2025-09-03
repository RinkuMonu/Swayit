@extends('business.layout.main')
@section('content')
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
                    <h3>Campaign List</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Dashboard</li>
                        <li class="breadcrumb-item active">Campaign List</li>
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
                                        <th>Campaign</th>
                                        <th>Total Influencers</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Active Status</th>
                                        <th>Campaign Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($campaign_list as $list)
                                    @php
                                        $totalInfluencers = \App\Models\CampaignInfluencer::where('campaign_id', $list->id)->where('user_id', $current_user->id)->count();
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}.</td>
                                        @php $i++; @endphp
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $totalInfluencers }}</td>
                                        <td>{{ date('F d, Y', strtotime($list->start_date)) }}</td>
                                        <td>{{ date('F d, Y', strtotime($list->end_date)) }}</td>
                                        <td>
                                            @if($list->status == 1)
                                                <span class="badge badge-danger">Closed</span>
                                            @else
                                                <span class="badge badge-success">Active</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($list->camp_status == 1)
                                                <span class="badge badge-primary">To Do</span>
                                            @elseif($list->camp_status == 2)
                                                <span class="badge badge-info">Assigned</span>
                                            @elseif($list->camp_status == 3)
                                                <span class="badge badge-warning">In Progress</span>
                                            @elseif($list->camp_status == 4)
                                                <span class="badge badge-primary">Waiting for Approval</span>
                                            @else
                                                <span class="badge badge-success">Approved</span>
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                            @if($list->status == 1)
                                            <div class="m-1">
                                                <form action="{{ route('business.activate.campaign') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" class="form-control" id="id" name="id"
                                                        value="{{ $list->id }}">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            </div>                                                
                                            @else
                                            <div class="m-1">
                                                <form id="close-campaign{{ $list->id }}"
                                                    action="{{ route('business.close.campaign') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" class="form-control" id="id" name="id"
                                                        value="{{ $list->id }}">
                                                    <button type="button" class="btn btn-warning"
                                                        id="close-campaign-button{{ $list->id }}">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                            <div class="m-1">
                                                <a href="{{ route('business.campaign.view', $list->id) }}" class="btn btn-info" style="padding: 6px;"><i class="fa fa-eye"></i></a>
                                            </div>
                                            <div class="m-1">
                                                <a href="{{ route('business.edit.campaign', $list->id) }}" class="btn btn-primary" style="padding: 6px;"><i class="fa fa-edit"></i></a>
                                            </div>
                                            <div class="m-1">
                                                <form id="delete-campaign{{ $list->id }}"
                                                    action="{{ route('business.delete.campaign') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" class="form-control" id="id" name="id"
                                                        value="{{ $list->id }}">
                                                    <button type="button" class="btn btn-danger"
                                                        id="delete-campaign-button{{ $list->id }}">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <script>
                                        document.getElementById('delete-campaign-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                    // Submit the form
                                                    document.getElementById('delete-campaign{{ $list->id }}').submit();
        
                                                }
                                            });
                                        });
                                    </script>
                                    <script>
                                        document.getElementById('close-campaign-button{{ $list->id }}').addEventListener('click', function(event) {
                                            Swal.fire({
                                                title: "Are you sure?",
                                                text: "You won't be able to revert this!",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Yes, close it!"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Submit the form
                                                    document.getElementById('close-campaign{{ $list->id }}').submit();
        
                                                }
                                            });
                                        });
                                    </script>
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