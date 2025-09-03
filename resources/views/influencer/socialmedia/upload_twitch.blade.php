@extends('influencer.layout.main')
@section('content')

    <div class="container-fluid">
      <div class="page-title">
        <div class="row">
          <div class="col-6">
            <h3>New Post</h3>
          </div>
          <div class="col-6">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ asset('influencer.dashboard') }}">                                       
                  <svg class="stroke-icon">
                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use>
                  </svg></a></li>
              <li class="breadcrumb-item">Post</li>
              <li class="breadcrumb-item active">Start a Post</li>
            </ol>
          </div>
        </div>
      </div>
    </div>



    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="row">
     
          <div class="card">
         
            <div class="card-body add-post">
              <div class="row">
              <div class="col-sm-8 col-xl-8">
                  <div class="">
                    <div class="">
                      <h4>Start or Schedule a Post</h4>
                     
                    </div>
                    <div class="card-body">
                      <ul class="nav nav-tabs" id="icon-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active " id="icon-home-tab" data-bs-toggle="tab" href="#icon-home" role="tab" aria-controls="icon-home" aria-selected="true"> <i class="icofont icofont-ui-image"></i>Photo</a></li>
                        <li class="nav-item"><a class="nav-link " id="profile-icon-tabs" data-bs-toggle="tab" href="#profile-icon" role="tab" aria-controls="profile-icon" aria-selected="false"><i class="icofont icofont-ui-video"></i>Video</a></li>
                        <li class="nav-item"><a class="nav-link " id="contact-icon-tab" data-bs-toggle="tab" href="#contact-icon" role="tab" aria-controls="contact-icon" aria-selected="false"><i class="icofont icofont-ui-file"></i>Text</a></li>
                      </ul>
                      <br>
                      <div class="tab-content" id="icon-tabContent">
                        <div class="tab-pane fade show active" id="icon-home" role="tabpanel" aria-labelledby="icon-home-tab">
                          <form class="dropzone" id="singleFileUpload" action="/upload.php">
                              <div class="m-0 dz-message needsclick"><i class="icon-cloud-up"></i>
                                <h6 class="mb-0">Drop files here or click to upload.</h6>
                              </div>
                              
                            </form>
                            <div class="col">
                              <div class="mb-3">
                            
                                <input class="form-control" id="exampleInputPassword27" type="text" placeholder="Enter the Caption">
                              </div>
                            </div>
                            <div class="checkbox checkbox-dark m-squar">
                              <input id="inline-sqr-3" type="checkbox" checked="">
                              <label for="inline-sqr-3">Schedule This Post</label>
                            </div>
                            <div class="card-footer text-end">
                              <button class="btn btn-primary">Submit</button>
                              <button class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-icon" role="tabpanel" aria-labelledby="profile-icon-tab">
                         
                          <div class="col">
                              <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Upload a Video</label>
                                <div class="col-sm-9">
                                  <input class="form-control" type="file">
                                </div>
                              </div>
                          </div>
                          <div class="col">
                              <div>
                                <label class="form-label" for="exampleFormControlTextarea4">Enter the Caption</label>
                                <textarea class="form-control" id="exampleFormControlTextarea4" rows="3"></textarea>
                              </div>
                            </div>
                            <div class="checkbox checkbox-dark m-squar">
                              <input id="inline-sqr-3" type="checkbox" checked="">
                              <label for="inline-sqr-3">Schedule This Post</label>
                            </div>
                            <div class="card-footer text-end">
                              <button class="btn btn-primary">Submit</button>
                              <button class="btn btn-secondary">Cancel</button>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="contact-icon" role="tabpanel" aria-labelledby="contact-icon-tab">
                          
                          
                          <div class="row">
                              <div class="col-sm-12">
                                <div class="card">
                               <div class="card-body">
                                                <textarea id="editor1" name="editor1" cols="30" rows="10">
                                                  
                                                </textarea>
                                                </div>
                                                </div>
                                                </div>
                                                </div>

                                                <div class="checkbox checkbox-dark m-squar">
                                                  <input id="inline-sqr-3" type="checkbox" checked="">
                                                  <label for="inline-sqr-3">Schedule This Post</label>
                                                </div>
                                                <div class="card-footer text-end">
                                                  <button class="btn btn-primary">Submit</button>
                                                  <button class="btn btn-secondary">Cancel</button>
                                                </div>                
                        </div>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="col-sm-4 col-xl-4"><div class="main-content-body tab-pane p-4 border-top-0 active" id="fb">
                  <div class="card mg-b-20 border">
                      <div class="card-header p-4">
                          <div class="media">
                              <div class="media-user me-2">
                                  <div class="social-icons"><img src="{{ asset('assets/images/socialconnect/Twitchpost.png') }}" alt="facebook icon" style="width: 43px;"></div><span>Twitch</span>
                              </div>
                              <div class="media-body">
                                  <h6 class="mb-0 mg-t-2 ms-2">Mintrona Pechon Pechon</h6><span class="text-primary ms-2">just now</span> </div>
                              
                          </div>
                      </div>
                      <div class="card-body">
                          <p class="mg-t-0">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                          
                          <div class="media mg-t-15 profile-footer">
                              <div class="ms-auto">
                                  <div class="dropdown show"> <a class="new" href="JavaScript:void(0);">
                                      <i class="fa fa-heart me-3"></i></a> <a class="new" href="JavaScript:void(0);">
                                      <i class="fa fa-comment me-3"></i></a> <a class="new" href="JavaScript:void(0);">
                                      <i class="fa fa-share-square"></i></a> </div>
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
    </div>
    <!-- Container-fluid Ends-->

@endsection