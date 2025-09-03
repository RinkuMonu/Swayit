@extends('admin.layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Business List</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Business List</li>
                </ol>
            </nav>
        </div>




        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Business List</h4>
                        <div class="container-fluid">
                            <div class="support-ticket-body">
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sl. No</th>
                                                        <th>User Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Joined On</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($business_list as $list)
                                                        <td>{{ $i }}</td>@php $i++; @endphp
                                                        <td>{{ $list->first_name }} {{ $list->last_name }}</td>
                                                        <td>{{ $list->email }}</td>
                                                        <td>{{ $list->phone }}</td>
                                                        <td>{{ date('F d, Y', strtotime($list->created_at)) }}</td>
                                                        <td></td>
                                                        </tr>
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
