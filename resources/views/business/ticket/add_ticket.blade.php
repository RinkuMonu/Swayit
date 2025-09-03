@extends('business.layout.main')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Create a Ticket</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Support Ticket</li>
                        <li class="breadcrumb-item active">Create Ticket</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">


            <div class="row">
                <div class="col-sm-12 col-xl-12">



                    <div class="card-body">

                        <form action="{{ route('business.add.ticket') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label" for="exampleFormControlSelect9">Subject</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="exampleFormControlSelect9">Select a Type</label>
                                            <select class="form-select digits" name="ticket_type" id="ticket_type" required>
                                                <option value="">Select Ticket Type</option>
                                                <option value="Technical Support">Technical Support</option>
                                                <option value="Customer Support">Customer Support</option>
                                            </select>
                                        </div>
                                        <textarea id="editor1" name="description" cols="30" rows="10" style="border: 1px;">
                                                
                                              </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Create Ticket</button>
                            <input class="btn btn-light" type="reset" value="Cancel">
                        </div>

                        </form>
                    </div>

                </div>




            </div>

        </div>
    </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
