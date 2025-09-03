@extends('influencer.layout.main')
@section('content')

@php
    $industry_list = \App\Models\Industry::orderBy('id', 'desc')->get();
    $ctg_list = \App\Models\Category::orderBy('id', 'desc')->get();
    $subctg_list = \App\Models\SubCategory::orderBy('id', 'desc')->get();
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.0/tagify.min.css" />

<style>
    .form-group {
        margin-bottom: 1rem;
    }
    .tagify {
        width: 100%;
        background-color: #f8f9fa;
    }
    .checkbox-group img {
        width: 18px;
        margin-right: 4px;
    }
</style>

<div class="container-fluid">
    <div class="page-title mb-3">
        <h4>Create Gig</h4>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('influencer.store.gigs') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-6 form-group">
                        <label>Gig Title</label>
                        <input type="text" name="gigs_title" class="form-control" placeholder="Title" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Price</label>
                        <input type="number" name="gigs_price" class="form-control" placeholder="₹0" value="0">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Industry</label>
                        <select class="form-select" name="industry" id="industry-select" required>
                            <option value="">Select</option>
                            @foreach($industry_list as $ind)
                                <option value="{{ $ind->id }}">{{ $ind->name }}</option>
                            @endforeach
                            <option value="another">Other</option>
                        </select>
                        <div id="another-industry-input" class="mt-2" style="display: none;">
                            <input type="text" name="otherIndustry" id="otherIndustry" class="form-control" placeholder="Enter Industry Name">
                        </div>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Delivery Time</label>
                        <input type="text" name="delivery_time" class="form-control" placeholder="e.g. 3 days">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Tags</label>
                        <input name="gig_tags" value="tag1,tag2" />
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Image</label>
                        <input type="file" name="images[]" class="form-control" multiple>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Category</label>
                        <select onchange="showDiv(this)" class="form-select" id="category" name="category">
                            <option>Select Category</option>
                            @foreach($ctg_list as $ctg)
                                <option value="{{ $ctg->id }}">{{ $ctg->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group" id="sub_ctc_hidden_div" style="display: none;">
                        <label>Sub Category</label>
                        <select class="form-select" id="sub_category" name="sub_category">
                            <option value="">Select Sub Category</option>
                        </select>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>Description</label>
                        <textarea name="gig_desc" class="form-control" rows="3" placeholder="Short Description..."></textarea>
                    </div>

                    <div class="col-md-12 form-group checkbox-group">
                        <label>Platform</label>
                        <div class="row">
                            @php
                                $platforms = [
                                    'facebook' => 'facebook.png',
                                    'instagram' => 'instagram.png',
                                    'twitter' => 'twitter.png',
                                    'snapchat' => 'snapchetpost.png',
                                    'linkedin' => 'linkedin.png',
                                    'youtube' => 'youtube.png',
                                    'tiktok' => 'Tiktokpost.png',
                                    'be_real' => 'Bereaalpost.png',
                                    'twitch' => 'Twitchpost.png',
                                ];
                            @endphp
                            @foreach ($platforms as $key => $icon)
                                <div class="col-md-3 form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $key }}" name="{{ $key }}" value="1">
                                    <label class="form-check-label" for="{{ $key }}">
                                        <img src="{{ asset('assets/images/socialconnect/' . $icon) }}" alt=""> {{ ucfirst(str_replace('_', ' ', $key)) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-light">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.0/tagify.min.js"></script>
<script>
    new Tagify(document.querySelector("input[name=gig_tags]"));

    // Show/hide "Other" industry input
    document.getElementById('industry-select').addEventListener('change', function () {
        let selected = this.value;
        document.getElementById('another-industry-input').style.display = (selected === 'another') ? 'block' : 'none';
    });

    var subCategories = @json($subctg_list);

    function showDiv(select) {
        var categoryId = select.value;
        var subCtcDiv = document.getElementById('sub_ctc_hidden_div');
        var subCatSelect = document.getElementById('sub_category');

        if (categoryId) {
            var options = `<option value="">Select Sub Category</option>`;
            subCategories.filter(sub => sub.ctg_id == categoryId).forEach(sub => {
                options += `<option value="${sub.id}">${sub.name}</option>`;
            });
            subCatSelect.innerHTML = options;
            subCtcDiv.style.display = 'block';
        } else {
            subCtcDiv.style.display = 'none';
            subCatSelect.innerHTML = '';
        }
    }
</script>

@endsection
