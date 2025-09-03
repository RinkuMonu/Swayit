<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="{{ route('influencer.dashboard') }}"><img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo/logo.png') }}" alt=""><img
                    class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_dark.png') }}"
                    alt=""></a>

        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('influencer.dashboard') }}"><img class="img-fluid"
                    src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{ route('influencer.dashboard') }}"><img class="img-fluid"
                                src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i
                                class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>

                    <li class="sidebar-main-title">

                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('influencer.dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg><span class="">Dashboard </span></a>

                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                        class="sidebar-link sidebar-title link-nav" href="{{ route('influencer.learn.swayit') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-task') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-task') }}"></use>
                        </svg><span>Learn SwayIt</span></a>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                            class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-others') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-others') }}"></use>
                            </svg><span>Campaigns</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('influencer.campaign.list') }}">My Campaigns</a></li>
                            <li><a href="{{ route('influencer.campaign.analytics') }}">Campaign Analytics</a></li>
                        </ul>
                    </li>
                   

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                            class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-table') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-table') }}"></use>
                            </svg><span>Payment</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('influencer.wallet') }}">My Wallet</a></li>
                            <li><a href="{{ route('influencer.transactionList') }}">Transactions</a></li>
                            {{-- <li><a href="{{ route('influencer.escrow.payment') }}">Escrow Payment</a></li> --}}
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('influencer.contract.list') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-editors') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-editors') }}"></use>
                            </svg><span class="">My Contracts </span></a>
                    </li>
                    {{-- <li class="sidebar-main-title">
                        <div>
                            <h6 class="">Social Connection</h6>
                        </div>
                    </li> --}}
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
                        {{-- <label class="badge badge-light-secondary">New</label> --}}
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('influencer.connect.social.media') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-social') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-social') }}"></use>
                            </svg><span>Social Connect </span></a>
                        {{-- <ul class="sidebar-submenu">
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">Instagram</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Linkdin</a></li>
                            <li><a href="#">TikTok</a></li>
                            <li><a href="p#">Snapchat</a></li>
                        </ul> --}}
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                            class="sidebar-link sidebar-title link-nav" href="{{ route('influencer.calender') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-calendar') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-calendar') }}"></use>
                            </svg><span>My Calendar</span></a>
                        </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                            class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-task') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-task') }}"></use>
                            </svg><span>My Gigs</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('influencer.add.gigs') }}">Add Gigs</a></li>
                            <li><a href="{{ route('influencer.gigs.list') }}">Gigs List</a></li>
                            <li><a href="{{ route('influencer.gigs.order') }}">Orders</a></li>
                        </ul>
                    </li>
                    {{-- <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                            class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-ecommerce') }}"></use>
                            </svg><span>Projects</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="#">Project Report</a></li>
                            <li><a href="#">Project History</a></li>
                        </ul>
                    </li> --}}
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-ecommerce') }}"></use>
                            </svg><span class="">Start a Bid </span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('influencer.matching.bids') }}">Matching Bids</a></li>
                                <li><a href="{{ route('influencer.bid.list') }}">Bid List</a></li>
                                <li><a href="{{ route('influencer.bid.proposals') }}">Bid Proposals</a></li>
                            </ul>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                            class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-chat') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-chat') }}"></use>
                            </svg><span> Chat and Video Call</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('influencer.chat') }}">Chat</a></li>
                            <li><a href="{{ route('influencer.video.call') }}">Video Meet</a></li>

                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('influencer.todo.list') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>
                            </svg><span class="">To-Do List </span></a>

                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                            class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-support-tickets') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-support-tickets') }}"></use>
                            </svg><span>Support</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('influencer.ticket.list') }}">View Tickets</a></li>
                            <li><a href="{{ route('influencer.create.ticket') }}">Create a Ticket</a></li>

                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <i class="fa fa-list"></i>
                        <a class="sidebar-link sidebar-title" href="{{ route('influencer.social.post') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file-text') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file-text') }}"></use>
                            </svg>
                            <span>Post List</span>
                        </a>
                    </li>


                    <li style="height: 40px;"></li>
                    {{-- <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg><span class="">Chat </span></a>

                    </li> --}}
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>