@if ($task_count > 0)
    @foreach ($tasks as $task)
        @php
            $project_id = $task->project_id;
            if ($task->status === 1) {
                $card_class = 'card card-primary card-outline';
            } elseif ($task->status === 2) {
                $card_class = 'card card-info card-outline';
            } else {
                $card_class = 'card card-success card-outline';
            }
        @endphp
        <div class="{{ $card_class }}">
            <div class="card-header">
                <h5 class="card-title">
                    <a href="{{route('view-task', ['id' => $task->id])}}">{{ \Illuminate\Support\Str::limit($task->title, 30, ' ...') }}</a>
                </h5>
                <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-link" style="color: darkred"
                        onclick="javascript: deleteTask('{{ $task->id }}', '{{ $task->title }}', '{{ $project_id }}')">
                        <i class="fas fa-trash"></i>
                    </a>
                    <a href="#" class="btn btn-tool btnEditTask"
                        onclick="javascript: prepareTaskForm('{{ $project_id }}', '{{ $task->id }}')"
                        data-toggle="modal" data-target="#task-modal">
                        <i class="fas fa-pen"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <p>{{ \Illuminate\Support\Str::limit($task->description, 125, ' ...') }}</p>
            </div>
            <div class="card-footer">
                <small>{{ \Carbon\Carbon::createFromTimestamp(strtotime($task->dead_line))->diff(\Carbon\Carbon::now())->days }}
                    days remaining</small>
                @switch($task->priority_level)
                    @case(1)
                        <span class="badge badge-info float-right">Low</span>
                    @break
                    @case(2)
                        <span class="badge badge-warning float-right">Medium</span>
                    @break
                    @case(3)
                        <span class="badge badge-danger float-right">High</span>
                    @break
                @endswitch
            </div>
        </div>
    @endforeach
@else
    <div class="row">
        <div class="col-md-12" style="padding:10px; text-align: center;">
            No Tasks
        </div>
    </div>
@endif
