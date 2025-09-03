
<div class="campaign-influencer-list">
    <p><strong>Campaign Influencers</strong></p><br>
    <div class="influencer-list">
        <div class="row">
            @foreach ($influencers_list as $list)
                @php
                    $influencer = \App\Models\User::where('id', $list->influencer_id)->first();
                @endphp
                <div class="col-md-6 mb-2">
                    <div class="single-influencer">
                        <a href="{{ route('business.view.profile', $influencer->id) }}" target="_blank">
                            @if ($influencer->profile_img)
                                <img src="{{ asset('storage/' . $influencer->profile_img) }}" alt="">
                            @else
                                <img src="{{ asset('assets/images/dashboard/profile.png') }}" alt="">
                            @endif
                        </a>
                        <div class="text-body">
                            <h6><a href="{{ route('business.view.profile', $influencer->id) }}"
                                    target="_blank">{{ $influencer->first_name }} {{ $influencer->last_name }}</a></h6>
                            <p style="margin: 3px;">{!! \Illuminate\Support\Str::limit($influencer->bio, 30) !!}</p>
                        </div>
                        <div class="inf-comment-btn">
                            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#campaignComment{{ $influencer->id }}"><i
                                    class="fa fa-comments"></i></button> --}}
                            {{-- <span>1</span> --}}
                            <a href="{{ route('business.campaign.workstatus', ['campaign_id' => $campaignDetails->id, 'influencer_id' => $list->influencer_id]) }}" class="btn btn-primary">View Status</a>
                        </div>
                    </div>


                </div>
            @endforeach
        </div>
    </div>
</div>
