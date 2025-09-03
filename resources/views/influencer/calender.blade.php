@extends('influencer.layout.main')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Dashboard</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Calender</li>
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
                        <div class="md-sidebar mb-3"><a class="btn btn-primary md-sidebar-toggle"
                                href="javascript:void(0)">calendar filter</a>
                            <div class="md-sidebar-aside job-left-aside custom-scrollbar">
                                <div id="external-events">
                                    <h4> Events</h4>
                                    <div id="external-events-list">
                                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-warning">
                                            <div class="fc-event-main"> <i class="fa fa-birthday-cake me-2"></i>My Pending
                                                Task</div>
                                        </div>
                                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-danger">
                                            <div class="fc-event-main"> <i class="fa fa-user me-2"></i>Cancelled Task</div>
                                        </div>
                                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-success">
                                            <div class="fc-event-main"> <i class="fa fa-plane me-2"></i>Completed Task</div>
                                        </div>
                                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event">
                                            <div class="fc-event-main"> <i class="fa fa-file-text me-2"></i> Scheduled</div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-9 box-col-12">
                        <div class="calendar-default" id="calendar-container">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    @php
        $currentDate = now()->format('Y-m-d');
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* initialize the external events
            -----------------------------------------------------------------*/

            var containerEl = document.getElementById('external-events-list');
            new FullCalendar.Draggable(containerEl, {
                itemSelector: '.fc-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText.trim()
                    }
                }
            });

            /* initialize the calendar
            -----------------------------------------------------------------*/

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                initialView: 'dayGridMonth',
                initialDate: '{{ $currentDate }}',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                selectable: true,
                nowIndicator: true,
                // dayMaxEvents: true, // allow "more" link when too many events
                events: [
                    @foreach($campaign_list as $campaign)
                        {
                            title: '{{ $campaign->name }}',
                            start: '{{ $campaign->start_date }}',
                            @if($campaign->end_date)
                                end: '{{ $campaign->end_date }}',
                            @endif
                        },
                    @endforeach
                    // {
                    //     title: 'All Day Event',
                    //     start: '2024-08-01',
                    // },
                    // {
                    //     title: 'Tour with our Team.',
                    //     start: '2024-08-07',
                    //     end: '2024-08-10'
                    // },
                    // {
                    //     groupId: 999,
                    //     title: 'Meeting with Team',
                    //     start: '2024-08-15T16:00:00'
                    // },
                    // {
                    //     groupId: 999,
                    //     title: 'Upload New Project',
                    //     start: '2024-08-17T16:00:00'
                    // },
                    // {
                    //     title: 'Birthday Party',
                    //     start: '2024-08-24',
                    //     end: '2024-08-26'
                    // },
                    // {
                    //     title: 'Reporting about Theme',
                    //     start: '2024-08-28T10:30:00',
                    //     end: '2024-08-29T12:30:00'
                    // },
                    // {
                    //     title: 'Lunch',
                    //     start: '2024-08-30T12:00:00'
                    // },
                    // {
                    //     title: 'Meeting',
                    //     start: '2024-08-12T14:30:00'
                    // },
                    // {
                    //     title: 'Happy Hour',
                    //     start: '2024-08-30T17:30:00'
                    // },
                ],
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                drop: function(arg) {
                    // is the "remove after drop" checkbox checked?
                    if (document.getElementById('drop-remove').checked) {
                        // if so, remove the element from the "Draggable Events" list
                        arg.draggedEl.parentNode.removeChild(arg.draggedEl);
                    }
                }
            });
            calendar.render();

        });
    </script>
@endsection