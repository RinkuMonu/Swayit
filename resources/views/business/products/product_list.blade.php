@extends('business.layout.main')
@section('content')
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

    <style>
        .product-img {
            width: 70px;
            height: 70px;
        }
        .product-view {
            display: flex;
            justify-content: space-evenly;
        }
        .product-view .img-section img {
            width: 100%;
            height: auto;
        }
        .product-view .img-section .content p {
            margin-bottom: 10px;
        }
    </style>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Product list</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Product list</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <!-- Individual column searching (text inputs) Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addProduct">Add Product</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive product-table">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product_list as $list)
                                        <tr>
                                            <td>
                                                @if ($list->image)
                                                    <img src="{{ asset('storage/' . $list->image) }}" alt="..."
                                                        class="product-img">
                                                @else
                                                    <img src="{{ asset('assets/images/ecommerce/product-table-3.png') }}"
                                                        alt="" class="product-img">
                                                @endif
                                            </td>
                                            <td>{{ $list->name }}</td>
                                            <td>{{ $list->type }}</td>
                                            <td>{{ $list->category }}</td>
                                            <td>${{ $list->price }}</td>
                                            <td>{!! \Illuminate\Support\Str::limit($list->description, 100) !!}</td>
                                            <td class="d-flex">
                                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                                data-bs-target="#viewProduct{{ $list->id }}"><i
                                                        class="fa fa-eye"></i></button>&nbsp;
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#editProduct{{ $list->id }}"><i class="fa fa-edit"></i></button>&nbsp;
                                                <form id="delete-product-form{{ $list->id }}"
                                                    action="{{ route('business.delete.product') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" class="form-control" id="id" name="id"
                                                        value="{{ $list->id }}">
                                                    <button type="button" id="delete-product-button{{ $list->id }}"
                                                        class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>


                                        
                                        {{-- View Product --}}
                                        <div class="modal fade" id="viewProduct{{ $list->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Product Details</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="row product-view">
                                                            <div class="col-md-6 img-section">
                                                                @if ($list->image)
                                                                    <img src="{{ asset('storage/' . $list->image) }}" alt="...">
                                                                @else
                                                                    <img src="{{ asset('assets/images/ecommerce/product-table-3.png') }}">
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6 content">
                                                                <h3>{{ $list->name }}</h3><br>
                                                                <p>Type: &nbsp;<strong> {{ $list->type }}</strong></p>
                                                                <p>Price: &nbsp;<strong> ${{ $list->price }}</strong></p>
                                                                <p>Category: &nbsp;<strong> {{ $list->category }}</strong></p>
                                                            </div>
                                                        </div><br>
                                                        <div class="mb-2">
                                                            {!! $list->description !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- View Product --}}


                                        {{-- Edit Product --}}
                                        <div class="modal fade" id="editProduct{{ $list->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <form action="{{ route('business.update.product') }}" method="post"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-group mb-2">
                                                                <label for="type">Select Type</label>
                                                                <select name="type" id="type" class="form-select">
                                                                    <option value="Product" @if($list->type == 'Product') selected @endif>Product</option>
                                                                    <option value="Service" @if($list->type == 'Service') selected @endif>Service</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="productname">Product Name</label>
                                                                <input type="text" class="form-control" id="productname"
                                                                    name="productname" placeholder="Product name" value="{{ $list->name }}">
                                                                <input type="hidden" name="product_id" value="{{ $list->id }}">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="category">Category</label>
                                                                <input type="text" class="form-control" id="category"
                                                                    name="category" placeholder="Electronics, Apparel, Home Decor"  value="{{ $list->category }}">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="price">Price</label>
                                                                <input type="text" class="form-control" id="price"
                                                                    name="price" placeholder="$149" value="{{ $list->price }}">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                @if ($list->image)
                                                                    <img src="{{ asset('storage/' . $list->image) }}" alt="..."
                                                                        class="product-img">
                                                                @else
                                                                    <img src="{{ asset('assets/images/ecommerce/product-table-3.png') }}"
                                                                        alt="" class="product-img">
                                                                @endif
                                                                <br>
                                                                <label for="image">Image</label>
                                                                <input type="file" class="form-control" id="image"
                                                                    name="image">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="description">Description</label>
                                                                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{ $list->description }}</textarea>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Edit Product --}}




                                        <script>
                                            document.getElementById('delete-product-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                        document.getElementById('delete-product-form{{ $list->id }}').submit();

                                                    }
                                                });
                                            });
                                        </script>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    {{-- Add Product --}}
                    <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('business.add.product') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <label for="type">Select Type</label>
                                            <select name="type" id="type" class="form-select">
                                                <option value="Product">Product</option>
                                                <option value="Service">Service</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="productname">Product Name</label>
                                            <input type="text" class="form-control" id="productname"
                                                name="productname" placeholder="Product name">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="category">Category</label>
                                            <input type="text" class="form-control" id="category" name="category"
                                                placeholder="Electronics, Apparel, Home Decor">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="price">Price</label>
                                            <input type="text" class="form-control" id="price" name="price"
                                                placeholder="$149">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Add Product --}}

                </div>
            </div>
            <!-- Individual column searching (text inputs) Ends-->
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
