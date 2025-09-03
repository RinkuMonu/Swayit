@extends('admin.layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Sub-Category List</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sub-Category List</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Sub-Category List</h4>
                        <div class="container-fluid">
                            <div class="support-ticket-body">
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <button type="button" class="btn btn-info mb-3" style="float: right;"
                                            data-bs-toggle="modal" data-bs-target="#addSubcategory">Add
                                            Sub-category</button>
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sl. No</th>
                                                        <th>Title</th>
                                                        <th>Category Name</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($subctg_list as $list)
                                                        @php
                                                            $category = \App\Models\Category::where(
                                                                'id',
                                                                $list->ctg_id,
                                                            )->first();
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $i }}</td>@php $i++; @endphp
                                                            <td>{{ $list->name }}</td>
                                                            @if ($category)
                                                                <td>{{ $category->name }}</td>
                                                            @else
                                                                <td>No Category Found</td>
                                                            @endif
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
                                                                    data-bs-target="#editsubCategory{{ $list->id }}"><i
                                                                        class="fa fa-pencil-square-o text-info"
                                                                        aria-hidden="true"></i></button>

                                                                <button type="button" class="btn-no-bg-border"><i
                                                                        class="fa fa-check px-2 text-success"
                                                                        aria-hidden="true"></i></button>

                                                                <form action="{{ route('admin.delete.subcategory') }}"
                                                                    method="post" enctype="multipart/form-data"
                                                                    id="delete-sub-ctg-form{{ $list->id }}">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $list->id }}">
                                                                    <button type="button" class="btn-no-bg-border"
                                                                        id="delete-sub-ctg{{ $list->id }}"><i class="fa fa-trash text-danger"
                                                                            aria-hidden="true"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>

    
                                                        <script>
                                                            document.getElementById('delete-sub-ctg{{ $list->id }}').addEventListener('click', function(event) {
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
                                                                        document.getElementById('delete-sub-ctg-form{{ $list->id }}').submit();
                                                                    }
                                                                });
                                                            });
                                                        </script>

                                                        <!-- Modal Starts -->
                                                        <div class="modal fade" id="editsubCategory{{ $list->id }}"
                                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form action="{{ route('admin.update.subcategory') }}"
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
                                                                                    <label for="sub_category_name"
                                                                                        class="form-label taxt-bold">Enter
                                                                                        Sub-category</label>
                                                                                    <input type="text"
                                                                                        class="form-control borderPlaceholderInput"
                                                                                        id="sub_category_name"
                                                                                        name="sub_category_name"
                                                                                        placeholder="Enter Category"
                                                                                        value="{{ $list->name }}">
                                                                                        <input type="hidden" name="id"
                                                                                            value="{{ $list->id }}">
                                                                                </div>
                                                                                <div class="mb-4">
                                                                                    <label for="category" class="form-label taxt-bold">Select Category</label>
                                                                                    <select name="category" id="category" class="form-select">
                                                                                        @foreach ($ctg_list as $ctg)
                                                                                            <option value="{{ $ctg->id }}" @if($ctg->id == $list->ctg_id) selected @endif>{{ $ctg->name }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit"
                                                                                class="btn btn-info">Update
                                                                                Sub-category</button>
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
    <div class="modal fade" id="addSubcategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.add.subcategory') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Enter Sub-category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-4">
                                <label for="sub_category_name" class="form-label taxt-bold">Enter Sub-category</label>
                                <input type="text" class="form-control borderPlaceholderInput" id="sub_category_name"
                                    name="sub_category_name" placeholder="Enter Sub-category">
                            </div>
                            <div class="mb-4">
                                <label for="category" class="form-label taxt-bold">Select Category</label>
                                <select name="category" id="category" class="form-select">
                                    @foreach ($ctg_list as $list)
                                        <option value="{{ $list->id }}">{{ $list->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Add Sub-category</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Ends -->

@endsection
