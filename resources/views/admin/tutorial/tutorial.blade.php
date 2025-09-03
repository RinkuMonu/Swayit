@extends('admin.layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Tutorials</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tutorials</li>
                </ol>
            </nav>
        </div>



        <div class="col-lg-12">
            <div class="card">
                <div class="row p-4">
                    <div class="col-md-12 mt-3">
                        <button type="button" class="btn btn-info btn-sm smallButtons mb-3" data-bs-toggle="modal"
                            data-bs-target="#addTutorial">Add Tutorial</button>
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($tutorial_list as $list)
                                        @php
                                            $category = \App\Models\LearnSwayitCategory::where(
                                                'id',
                                                $list->category_id,
                                            )->first();
                                        @endphp
                                        <td>{{ $i }}</td>@php $i++; @endphp
                                        <td>{{ $list->title }}</td>
                                        <td>{{ $category->title }}</td>
                                        <td>{{ date('F d, Y', strtotime($list->updated_at)) }}</td>
                                        <td class="d-flex">
                                            <button type="button" class="btn-no-bg-border" data-bs-toggle="modal"
                                                data-bs-target="#viewTutorial{{ $list->id }}"><i
                                                    class="fa fa-eye text-primary"
                                                    aria-hidden="true"></i></button>&nbsp;

                                            <button type="button" class="btn-no-bg-border" data-bs-toggle="modal"
                                                data-bs-target="#editTutorial{{ $list->id }}"><i
                                                    class="fa fa-pencil-square-o text-info"
                                                    aria-hidden="true"></i></button>&nbsp;

                                            {{-- <form action="{{ route('admin.deleteTutorialCategory') }}" method="post"
                                                enctype="multipart/form-data" id="delete-category-form{{ $list->id }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $list->id }}">
                                                <button type="button" class="btn-no-bg-border"
                                                    id="delete-category{{ $list->id }}"><i
                                                        class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                            </form> --}}

                                        </td>
                                        </tr>


                                        {{-- <script>
                                            document.getElementById('delete-category{{ $list->id }}').addEventListener('click', function(event) {
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
                                                        document.getElementById('delete-category-form{{ $list->id }}').submit();
                                                    }
                                                });
                                            });
                                        </script> --}}

                                        
    <!-- Modal Starts -->
    <div class="modal fade" id="viewTutorial{{ $list->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Title: {{ $list->title }}</h4>
                        <p>Category: {{ $category->title }}</p>
                        <p>Author: {{ $list->author }}</p>

                        @if($list->image)
                            <p>Image</p>
                            <img src="{{ asset('storage/' . $list->image) }}" alt="" style="width: 150px; height: auto;"><br><br>
                        @endif

                        @if($list->video)
                            <p>Video</p>
                            <video controls style="width: 150px; height: auto;">
                                <source src="{{ asset('storage/' . $list->video) }}" type="video/mp4" />
                            </video><br><br>
                        @endif

                        <div class="text">
                            <strong>Description</strong><br>
                            {!! $list->description !!}
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- Modal Ends -->

    

    <!-- Modal Starts -->
    <div class="modal fade" id="editTutorial{{ $list->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('admin.updateTutorial') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Tutorial</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <label class="form-label taxt-bold">Title</label>
                                <input type="text" class="form-control borderPlaceholderInput" name="title"
                                    placeholder="Enter Title" value="{{ $list->title }}">
                                    <input type="hidden" name="tutorial_id" id="" value="{{ $list->id }}">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label taxt-bold">Select Category</label>
                                <select class="form-select" name="category">
                                    @foreach ($category_list as $clist)
                                        <option value="{{ $clist->id }}" @if($clist->id == $category->id) selected @endif>{{ $list->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                @if($list->image)
                                    <img src="{{ asset('storage/' . $list->image) }}" alt="" style="width: 150px; height: auto;"><br><br>
                                @endif
                                <label class="form-label taxt-bold">Image</label>
                                <input type="file" class="form-control" name="image" id="" accept="image/*">
                            </div>
                            <div class="col-md-6 mb-4">
                                @if($list->video)
                                    <video controls style="width: 150px; height: auto;">
                                        <source src="{{ asset('storage/' . $list->video) }}" type="video/mp4" />
                                    </video><br><br>
                                @endif
                                <label class="form-label taxt-bold">Video</label>
                                <input type="file" class="form-control" name="video" id="" accept="video/*">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label taxt-bold">Author</label>
                                <input type="text" class="form-control" name="author" id="" required
                                    placeholder="Author Name" value="{{ $list->author }}">
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="form-label taxt-bold">Description</label>
                                <textarea name="description" class="form-control" id="" cols="30" rows="20"
                                    placeholder="Description">{!! $list->description !!}</textarea>
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

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Starts -->
    <div class="modal fade" id="addTutorial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('admin.storeTutorial') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Tutorial</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <label for="category_name" class="form-label taxt-bold">Title</label>
                                <input type="text" class="form-control borderPlaceholderInput" name="title"
                                    placeholder="Enter Title">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="category_name" class="form-label taxt-bold">Select Category</label>
                                <select class="form-select" name="category">
                                    @foreach ($category_list as $list)
                                        <option value="{{ $list->id }}">{{ $list->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label taxt-bold">Image</label>
                                <input type="file" class="form-control" name="image" id="" accept="image/*"
                                    required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label taxt-bold">Video</label>
                                <input type="file" class="form-control" name="video" id="" accept="video/*">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label taxt-bold">Author</label>
                                <input type="text" class="form-control" name="author" id="" required
                                    placeholder="Author Name">
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="form-label taxt-bold">Description</label>
                                <textarea name="description" class="form-control" id="" cols="30" rows="20"
                                    placeholder="Description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Add Tutorial</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Ends -->

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
