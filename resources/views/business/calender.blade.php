@extends('business.layout.main')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Dashboard</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Calendar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid calendar-basic">
        <div class="card">
            <div class="card-body">
                <div class="row" id="wrap">
                    <div class="col-xxl-3 box-col-12">
                        <div class="md-sidebar mb-3">
                            <a class="btn btn-primary md-sidebar-toggle" href="javascript:void(0)">calendar filter</a>
                            <div class="md-sidebar-aside job-left-aside custom-scrollbar">
                                <div id="external-events">
                                    <h4>Events</h4>
                                    <div id="external-events-list">
                                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-warning">
                                            <div class="fc-event-main"> <i class="fa fa-birthday-cake me-2"></i>My Pending Task</div>
                                        </div>
                                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-danger">
                                            <div class="fc-event-main"> <i class="fa fa-user me-2"></i>Cancelled Task</div>
                                        </div>
                                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-success">
                                            <div class="fc-event-main"> <i class="fa fa-plane me-2"></i>Completed Task</div>
                                        </div>
                                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event">
                                            <div class="fc-event-main"> <i class="fa fa-file-text me-2"></i>Scheduled</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12 box-col-12">
                        <div class="calendar-default" id="calendar-container">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $currentDate = now()->format('Y-m-d');
        $colors = ['#f94144', '#f3722c', '#f9c74f', '#90be6d', '#43aa8b', '#577590', '#ff6b6b', '#6a4c93', '#ffa600'];
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var containerEl = document.getElementById('external-events-list');
            new FullCalendar.Draggable(containerEl, {
                itemSelector: '.fc-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText.trim()
                    }
                }
            });

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                initialView: 'dayGridMonth',
                initialDate: '{{ $currentDate }}',
                navLinks: true,
                editable: true,
                selectable: true,
                nowIndicator: true,
                events: [
                    @foreach($campaign_list as $index => $campaign)
                        {
                            title: '{{ $campaign->name }}',
                            start: '{{ $campaign->start_date }}',
                            @if($campaign->end_date)
                                end: '{{ \Carbon\Carbon::parse($campaign->end_date)->addDay()->format('Y-m-d') }}',
                            @endif
                            color: '{{ $colors[$index % count($colors)] }}'
                        },
                    @endforeach
                ],
                eventClick: function(info) {
                    window.location.href = '{{ route('business.campaign.list') }}';
                },
                droppable: true,
                drop: function(arg) {
                    if (document.getElementById('drop-remove')?.checked) {
                        arg.draggedEl.parentNode.removeChild(arg.draggedEl);
                    }
                }
            });

            calendar.render();
        });
    </script>
@endsection
