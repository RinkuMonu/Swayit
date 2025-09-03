@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
<div class="page-header">
    <h3 class="page-title">Blogs</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pages</li>
            <li class="breadcrumb-item active" aria-current="page">Blogs</li>
        </ol>
    </nav>
</div>




<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-info btn-sm smallButtons mb-3"
                    data-bs-toggle="modal" data-bs-target="#addBlog">Add Blog</button>
                <h4 class="card-title">Blog List</h4>
                <div class="container-fluid">
                    <div class="">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sl. No</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($blogList as $list)
                                                <td>{{ $i }}</td>@php $i++; @endphp
                                                <td>{!! \Illuminate\Support\Str::limit($list->title, 40) !!}...</td>
                                                <td><img src="{{ asset('storage/' . $list->image) }}" alt="" style="width: 100px; height: auto;"></td>
                                                <td>{!! \Illuminate\Support\Str::limit($list->description, 20) !!}</td>
                                                <td>{{ date('F d, Y', strtotime($list->date)) }}</td>
                                                <td class="d-flex">
                                                    <button type="button" class="btn btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#viewBlog"><i class="fa fa-eye"></i></button>&nbsp;
                                                    <button type="button" class="btn btn-info"
                                                    data-bs-toggle="modal" data-bs-target="#editBlog"><i class="fa fa-edit"></i></button>&nbsp;
                                                    <form id="delete-blog-form{{ $list->id }}" action="{{ route('admin.deleteBlog') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" class="form-control" id="id" name="id" value="{{ $list->id }}">
                                                        <button type="button" class="btn btn-danger" id="delete-blog-button{{ $list->id }}"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                                </tr>



                                            <!-- Modal Starts -->
                                            <div class="modal fade" id="editBlog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin.updateBlog') }}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Blog</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-4">
                                                                        <img src="{{ asset('storage/' . $list->image) }}" alt="" style="width: 100px; height: auto;"><br><br>
                                                                        <label for="image" class="form-label taxt-bold">Image</label>
                                                                        <input type="file" class="form-control borderPlaceholderInput" id="image"
                                                                            name="image" placeholder="Enter Title">
                                                                    </div>
                                                                    <div class="col-md-12 mb-4">
                                                                        <label for="title" class="form-label taxt-bold">Title</label>
                                                                        <input type="text" class="form-control borderPlaceholderInput" id="title"
                                                                            name="title" placeholder="Enter Title" value="{{ $list->title }}">
                                                                            <input type="hidden" value="{{ $list->id }}" name="id">
                                                                    </div>
                                                                    <div class="col-md-12 mb-4">
                                                                        <label for="description" class="form-label taxt-bold">Description</label>
                                                                        <textarea name="description"  class="form-control borderPlaceholderInput" id="editdescription" cols="30" rows="10" placeholder="Enter Title">{!! $list->description !!}</textarea>
                                                                    </div>
                                                                    <div class="col-md-6 mb-4">
                                                                        <label for="author" class="form-label taxt-bold">Author</label>
                                                                        <input type="text" class="form-control borderPlaceholderInput" id="author"
                                                                            name="author" placeholder="Enter Title" value="{{ $list->author }}">
                                                                    </div>
                                                                    <div class="col-md-6 mb-4">
                                                                        <label for="date" class="form-label taxt-bold">Date</label>
                                                                        <input type="date" class="form-control borderPlaceholderInput" id="date"
                                                                            name="date" placeholder="Enter Title" value="{{ $list->date }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-info">Update</button>
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Ends -->


                                            <!-- Modal Starts -->
                                            <div class="modal fade" id="viewBlog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Blog Details</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('storage/' . $list->image) }}" alt="" style="width: 200px; height: auto;"><br><br>
                                                            <h2>{{ $list->title }}</h2>
                                                            <p><strong>Author : </strong>{{ $list->author }}</p>
                                                            <p><strong>Date : </strong>{{ date('F d, Y', strtotime($list->date)) }}</p>
                                                            <div class="text">{!! $list->description !!}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Ends -->

                                            <script>
                                                document.getElementById('delete-blog-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                            document.getElementById('delete-blog-form{{ $list->id }}').submit();
                                            
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




<!-- Modal Starts -->
<div class="modal fade" id="addBlog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
    <div class="modal-content">
        <form action="{{ route('admin.storeBlog') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Blog</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="image" class="form-label taxt-bold">Image</label>
                        <input type="file" class="form-control borderPlaceholderInput" id="image"
                            name="image" placeholder="Enter Title">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="title" class="form-label taxt-bold">Title</label>
                        <input type="text" class="form-control borderPlaceholderInput" id="title"
                            name="title" placeholder="Enter Title">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="description" class="form-label taxt-bold">Description</label>
                        <textarea name="description"  class="form-control borderPlaceholderInput" id="adddescription" cols="30" rows="10" placeholder="Enter Title"></textarea>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="author" class="form-label taxt-bold">Author</label>
                        <input type="text" class="form-control borderPlaceholderInput" id="author"
                            name="author" placeholder="Enter Title">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="date" class="form-label taxt-bold">Date</label>
                        <input type="date" class="form-control borderPlaceholderInput" id="date"
                            name="date" placeholder="Enter Title">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Add Blog</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
</div>
<!-- Modal Ends -->

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

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace('adddescription', {
versionCheck: false
});
</script>
<script>
CKEDITOR.replace('editdescription', {
versionCheck: false
});
</script>

@endsection
