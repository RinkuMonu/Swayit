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

    
    <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-6">
              <h3>To Do List</h3>
            </div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">                                       
                    <svg class="stroke-icon">
                      <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use>
                    </svg></a></li>
                <li class="breadcrumb-item"> Dashboard</li>
                <li class="breadcrumb-item active">To Do List</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      
       <!-- Container-fluid starts-->
       <div class="container-fluid email-wrap bookmark-wrap todo-wrap">
        <div class="row">
          <div class="col-xl-3 xl-30 box-col-12">
            <div class="email-sidebar md-sidebar"><a class="btn btn-primary email-aside-toggle md-sidebar-toggle">To Do filter</a>
              <div class="email-left-aside md-sidebar-aside">
                <div class="card"> 
                  <div class="card-body"> 
                    <div class="email-app-sidebar left-bookmark custom-scrollbar">
                      <div class="d-flex align-items-center">
                        <div class="media-size-email">
                            @if ($user->profile_img)
                                <img class="me-3 img-40 rounded-circle" src="{{ asset('storage/' . $user->profile_img) }}" alt="">
                            @else
                                <img class="me-3 img-40 rounded-circle" src="{{ asset('assets/images/user/user.png') }}" alt="">
                            @endif
                        </div>
                        <div class="flex-grow-1"> 
                          <h6 class="f-w-600">{{ $user->first_name }} {{ $user->last_name }}</h6>
                          <p>{{ $user->email }}</p>
                        </div>
                      </div>
                      @php
                          $all_task = $task_list->count();
                          $completed = $task_list->where('status', 1)->count();
                          $pending = $task_list->where('status', 0)->count();
                      @endphp
                      <ul class="nav main-menu">
                        <li class="nav-item">
                          <button class="btn-primary badge-light d-block btn-mail w-100"><i class="me-2" data-feather="check-circle"> </i>To Do List</button>
                        </li>
                        <li class="nav-item"> <a href="javascript:void(0)" onclick="filterTasks('all')"><span class="iconbg badge-light-primary"><i data-feather="file-plus"></i></span><span class="title ms-2">All Task</span><span class="badge badge-primary">{{ $all_task }}</span></a></li>
                        <li class="nav-item"><a href="javascript:void(0)" onclick="filterTasks('completed')"><span class="iconbg badge-light-success"><i data-feather="check-circle"></i></span><span class="title ms-2">Completed</span><span class="badge badge-success">{{ $completed }}</span></a></li>
                        <li class="nav-item"><a href="javascript:void(0)" onclick="filterTasks('pending')"><span class="iconbg badge-light-danger"><i data-feather="cast"></i></span><span class="title ms-2">Pending</span><span class="badge badge-danger">{{ $pending }}</span></a></li>
                        {{-- <li class="nav-item"><a href="javascript:void(0)"><span class="iconbg badge-light-info"><i data-feather="activity"></i></span><span class="title ms-2">In Process</span><span class="badge badge-primary">2</span></a></li>
                        <li class="nav-item"><a href="javascript:void(0)"><span class="iconbg badge-light-danger"><i data-feather="trash"></i></span><span class="title ms-2">Trash</span></a></li> --}}
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-xl-9 xl-70 box-col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="mb-0">To-Do</h3>
              </div>
              <div class="card-body">
                <div class="todo">
                  <div class="todo-list-wrapper">
                    <div class="todo-list-container">
                      <div class="mark-all-tasks">
                        {{-- <div class="mark-all-tasks-container"><span class="mark-all-btn" id="mark-all-finished" role="button"><span class="btn-label">Mark all as finished</span><span class="action-box completed"><i class="icon"><i class="icon-check"></i></i></span></span><span class="mark-all-btn move-down" id="mark-all-incomplete" role="button"><span class="btn-label">Mark all as Incomplete</span><span class="action-box"><i class="icon"><i class="icon-check"></i></i></span></span></div> --}}
                        <div class="todo-list-footer ms-2">
                          <div class="add-task-btn-wrapper"><span class="add-task-btn">
                              <button class="btn btn-primary"><i class="icon-plus"></i> Add new task</button></span></div>
                        </div>
                      </div>
                      <div class="todo-list-body">
                        <div class="todo-list-footer">
                            <form action="{{ route('business.add.task') }}" method="POST" enctype="multipart/form-data">
                                @csrf 
                          <div class="new-task-wrapper mb-4">
                            <textarea id="new-task" name="title" placeholder="Enter new task here. . ."></textarea>
                            <span class="btn btn-danger cancel-btn" id="close-task-panel">Close</span>
                            <button type="submit" class="btn btn-success ms-3">Add Task</button>
                          </div>
                            </form>
                        </div>
                        <ul id="todo-list">

                        @foreach ($task_list as $list)
                          {{-- <li class="task {{ $list->status == 1 ? 'completed' : '' }}"> --}}
                          <li class="task @if($list->status == 1) completed @elseif($list->status == 0) pending @else all @endif">
                            <div class="task-container">
                              <h4 class="task-label">{{ Str::limit($list->title, 30) }}</h4>
                              <div class="d-flex align-items-center gap-4">
                                <h5 class="assign-name m-0">{{ \Carbon\Carbon::parse($list->created_at)->setTimezone('Asia/Kolkata')->format('F d, Y h:i A') }}</h5>

                                <span class="task-action-btn">
                                    @if($list->status == 0)
                                    <form id="update-task-form{{ $list->id }}" action="{{ route('business.update.task') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $list->id }}">
                                        <input type="hidden" name="status" value="1"> <!-- Status for 'Done' -->
                                        <button type="button" class="btn text-success {{ $list->status == 1 ? 'disabled-icon' : '' }}" onclick="updateTaskStatus({{ $list->id }})">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </button>
                                    </form> 
                                    @else 
                                    <i class="fa fa-check" aria-hidden="true"></i>                                      
                                    @endif
                                    <button class="btn text-primary" data-bs-toggle="modal" data-bs-target="#viewTaskModal" onclick="viewTask('{{ addslashes($list->desc) }}', '{{ \Carbon\Carbon::parse($list->created_at)->setTimezone('Asia/Kolkata')->format('F d, Y h:i A') }}')">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <form id="delete-task-form{{ $list->id }}" action="{{ route('business.delete.task') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $list->id }}">
                                        <button type="button" class="btn text-danger" id="delete-task-button{{ $list->id }}">
                                            <i class="fa fa-trash "></i>
                                        </button>
                                    </form>

                                    {{-- <span class="action-box large delete-btn" title="Delete Task"><i class="icon"><i class="icon-trash"></i></i></span>
                                    <span class="action-box large complete-btn" title="Mark Complete"><i class="icon"><i class="icon-check"></i></i></span></span> --}}
                              </div>
                            </div>
                          </li>

                          <script>
                              function updateTaskStatus(taskId) {
                                  Swal.fire({
                                      title: "Are you sure?",
                                      text: "Mark this task as done!",
                                      icon: "warning",
                                      showCancelButton: true,
                                      confirmButtonColor: "#3085d6",
                                      cancelButtonColor: "#d33",
                                      confirmButtonText: "Yes, mark it as done!"
                                  }).then((result) => {
                                      if (result.isConfirmed) {
                                          document.getElementById('update-task-form' + taskId).submit();
                                      }
                                  });
                              }
  
                              document.getElementById('delete-task-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                          document.getElementById('delete-task-form{{ $list->id }}').submit();
                                      }
                                  });
                              });
  
                              function viewTask(desc, createdAt) {
                                  document.getElementById('taskDesc').innerText = desc;
                                  document.getElementById('taskCreatedAt').innerText = createdAt;
                              }
                          </script>
                      @endforeach
  
                      <!-- Pagination links -->
                      <div class="d-flex justify-content-end mt-3">
                          {{ $task_list->links('pagination::bootstrap-4') }}
                      </div>

                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="notification-popup hide">
                    <p><span class="task"></span><span class="notification-text"></span></p>
                  </div>
                </div>
                <!-- HTML Template for tasks-->
                <script id="task-template" type="tect/template">
                  <li class="task">
                    <div class="task-container">
                      <h4 class="task-label"></h4>
                      <div class="d-flex align-items-center gap-4">
                        <span class="badge badge-light-danger">Pending</span>
                        <h5 class="assign-name">16 Jan</h5>
                        <span class="task-action-btn">
                          <span class="action-box large delete-btn" title="Delete Task">
                            <i class="icon"><i class="icon-trash"></i></i>
                          </span>
                          <span class="action-box large complete-btn" title="Mark Complete">
                            <i class="icon"><i class="icon-check"></i></i>
                          </span>
                        </span>
                      </div>
                    </div>
                  </li>
                </script>
              </div>
            </div>
          </div>
        </div>
      </div>


      
      <script>
    function filterTasks(filter) {
        // Get all task elements
        const tasks = document.querySelectorAll('#todo-list .task');
        
        // Loop through tasks and set display based on filter
        tasks.forEach(task => {
            if (filter === 'all') {
                task.style.display = 'block'; // Show all tasks
            } else if (filter === 'completed') {
                task.style.display = task.classList.contains('completed') ? 'block' : 'none';
            } else if (filter === 'pending') {
                task.style.display = task.classList.contains('pending') ? 'block' : 'none';
            }
        });
    }

    // Initial filter to show all tasks on page load
    document.addEventListener('DOMContentLoaded', function() {
        filterTasks('all');
    });
</script>


      
@endsection