@extends('admin.layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Ticket List</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ticket List</li>
                </ol>
            </nav>
        </div>




        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Category List</h4>
                        <div class="container-fluid">
                            <div class="support-ticket-body">
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sl. No</th>
                                                        <th>Ticket ID</th>
                                                        <th>User Name</th>
                                                        <th>Subject</th>
                                                        <th>Type</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($ticket_list as $list)
                                                        @php
                                                            $user = \App\Models\User::where(
                                                                'id',
                                                                $list->user_id,
                                                            )->first();
                                                        @endphp
                                                        <td>{{ $i }}</td>@php $i++; @endphp
                                                        <td>{{ $list->ticket_id }}</td>
                                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                        <td>{{ $list->title }}</td>
                                                        <td>{{ $list->ticket_type }}</td>
                                                        <td>{{ \Illuminate\Support\Str::limit($list->desc, 20) }}</td>
                                                        <td>
                                                            @if ($list->status == 1)
                                                                <span class="badge text-bg-success">Open</span>
                                                            @else
                                                                <span class="badge text-bg-secondary">Closed</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ date('F d, Y', strtotime($list->created_at)) }}</td>
                                                        <td class="d-flex">
                                                            {{-- @if ($list->status == null)
                                                            @else --}}
                                                            <div>
                                                                <form id="delete-ticket-form{{ $list->id }}"
                                                                    action="{{ route('admin.delete.ticket') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" class="form-control"
                                                                        id="id" name="id"
                                                                        value="{{ $list->id }}">
                                                                    <button type="button" class="btn-no-bg-border"
                                                                        id="delete-ticket-button{{ $list->id }}">
                                                                        <i class="fa fa-trash text-danger"
                                                                            aria-hidden="true"></i></button>
                                                                </form>
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('admin.view.ticket', $list->id) }}">
                                                                    <i class="fa fa-eye text-primary"
                                                                        aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                            <div>
                                                                <form id="status-ticket-form{{ $list->id }}"
                                                                    action="{{ route('admin.status.ticket') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" class="form-control"
                                                                        id="id" name="id"
                                                                        value="{{ $list->id }}">
                                                                    <button type="button" class="btn-no-bg-border"
                                                                        id="status-ticket-button{{ $list->id }}">
                                                                        <i class="fa fa-check px-2 text-success"
                                                                            aria-hidden="true"></i></button>
                                                                </form>
                                                            </div>
                                                            {{-- @endif --}}
                                                        </td>
                                                        </tr>

                                                        <script>
                                                            document.getElementById('status-ticket-button{{ $list->id }}').addEventListener('click', function(event) {
                                                                Swal.fire({
                                                                    title: "Are you sure?",
                                                                    text: "Click on Yes, to change status!",
                                                                    icon: "warning",
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: "#3085d6",
                                                                    cancelButtonColor: "#d33",
                                                                    confirmButtonText: "Yes, Change Status!"
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        // Submit the form
                                                                        document.getElementById('status-ticket-form{{ $list->id }}').submit();

                                                                    }
                                                                });
                                                            });
                                                        </script>

                                                        <script>
                                                            document.getElementById('delete-ticket-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                                        document.getElementById('delete-ticket-form{{ $list->id }}').submit();

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
@endsection
