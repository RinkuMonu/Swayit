@extends('admin.layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Category List</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Category List</li>
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
                                        <button type="button" class="btn btn-info btn-sm smallButtons mb-3"
                                            data-bs-toggle="modal" data-bs-target="#addCategory">Add Category</button>
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sl. No</th>
                                                        <th>Title</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($ctg_list as $list)
                                                        <tr>
                                                            <td>{{ $i }}</td>@php $i++; @endphp
                                                            <td>{{ $list->name }}</td>
                                                            <td>
                                                                @if ($list->status == 1)
                                                                    <span
                                                                        class="badge rounded-pill text-bg-success text-white">Active</span>
                                                                @else
                                                                    <span
                                                                        class="badge rounded-pill text-bg-danger text-white">Deactive</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ date('F d, Y', strtotime($list->created_at)) }}</td>
                                                            <td class="d-flex">
                                                                <button type="button" class="btn-no-bg-border"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editCategory{{ $list->id }}"><i
                                                                        class="fa fa-pencil-square-o text-info"
                                                                        aria-hidden="true"></i></button>

                                                                <button type="button" class="btn-no-bg-border"><i
                                                                        class="fa fa-check px-2 text-success"
                                                                        aria-hidden="true"></i></button>

                                                                <form action="{{ route('admin.delete.category') }}"
                                                                    method="post" enctype="multipart/form-data"
                                                                    id="delete-ctg-form{{ $list->id }}">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $list->id }}">
                                                                    <button type="button" class="btn-no-bg-border"
                                                                        id="delete-ctg{{ $list->id }}"><i class="fa fa-trash text-danger"
                                                                            aria-hidden="true"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>


                                                        <script>
                                                            document.getElementById('delete-ctg{{ $list->id }}').addEventListener('click', function(event) {
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
                                                                        document.getElementById('delete-ctg-form{{ $list->id }}').submit();
                                                                    }
                                                                });
                                                            });
                                                        </script>

                                                        <!-- Modal Starts -->
                                                        <div class="modal fade" id="editCategory{{ $list->id }}"
                                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form action="{{ route('admin.update.category') }}"
                                                                        method="post" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5"
                                                                                id="exampleModalLabel">Update Category</h1>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <div class="mb-4">
                                                                                    <label for="category_name"
                                                                                        class="form-label taxt-bold">Enter
                                                                                        Category</label>
                                                                                    <input type="text"
                                                                                        class="form-control borderPlaceholderInput"
                                                                                        id="category_name"
                                                                                        name="category_name"
                                                                                        placeholder="Enter Category"
                                                                                        value="{{ $list->name }}">
                                                                                        <input type="hidden" name="id"
                                                                                            value="{{ $list->id }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit"
                                                                                class="btn btn-info">Update
                                                                                Category</button>
                                                                            <button type="button" class="btn btn-danger"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal Ends -->
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

    <!-- Modal Starts -->
    <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.add.category') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Enter Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-4">
                                <label for="category_name" class="form-label taxt-bold">Enter Category</label>
                                <input type="text" class="form-control borderPlaceholderInput" id="category_name"
                                    name="category_name" placeholder="Enter Category">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Add Category</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Ends -->

@endsection
