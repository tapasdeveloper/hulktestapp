@extends('layouts.common')

@section('content')
    <div class="content-wrapper kanban">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-10">
                        <h1>{{ $heading }}</h1>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-block btn-primary btnCreateTask"
                            data-project="{{ $project_id }}" data-task="0" data-toggle="modal"
                            data-target="#task-modal">New Task</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="content pb-3">
            <div class="container-fluid h-100">

                <div class="card card-row card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            To Do
                        </h3>
                    </div>
                    <div class="card-body todo-task-area"></div>
                </div>
                <div class="card card-row card-default">
                    <div class="card-header bg-info">
                        <h3 class="card-title">
                            In Progress
                        </h3>
                    </div>
                    <div class="card-body inprogress-task-area"></div>
                </div>
                <div class="card card-row card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            Done
                        </h3>
                    </div>
                    <div class="card-body done-task-area"></div>
                </div>
            </div>
        </section>
    </div>


    <div class="modal fade" id="task-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Task information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="frmAddEditTask" id="frmAddEditTask" enctype="multipart/form-data" method="POST"
                    action="javascript: void(0);">
                    <input type="hidden" name="task_id" id="task_id" value="0">
                    <input type="hidden" name="mode" id="mode" value="">
                    <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputName">Project</label>
                            <select id="sel_project_id" name="sel_project_id" class="form-control custom-select">
                                <option value="" selected disabled>Select project</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputName">Task title</label>
                            <input type="text" id="sel_title" name="sel_title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Task Description</label>
                            <textarea id="sel_description" name="sel_description" class="form-control"
                                rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">Priority</label>
                            <select id="sel_priority_level" name="sel_priority_level" class="form-control custom-select">
                                <option value="" selected disabled>Select one</option>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">Status</label>
                            <select id="sel_status" name="sel_status" class="form-control custom-select">
                                <option value="" selected disabled>Select status</option>
                                <option value="1">To Do</option>
                                <option value="2">In Progress</option>
                                <option value="3">Done</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" id="sel_dead_line" name="sel_dead_line"
                                    class="form-control datetimepicker-input" data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btnClose" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
@section('customscript')
    <script type="text/javascript">
        function decodeEntity(inputStr) {
            var textarea = document.createElement("textarea");
            textarea.innerHTML = inputStr;
            return textarea.value;
        }
        var taskValidator = jQuery('form#frmAddEditTask').validate({
            debug: true,
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            highlight: function(element) {
                jQuery(element).closest('div').addClass("f_error");
            },
            unhighlight: function(element) {
                jQuery(element).closest('div').removeClass("f_error");
            },
            errorPlacement: function(error, element) {
                jQuery(element).closest('div').append(error);
            },
            rules: {
                sel_project_id: {
                    required: true
                },
                sel_title: {
                    required: true
                },
                sel_priority_level: {
                    required: true
                },
                sel_dead_line: {
                    required: true
                },
                sel_status: {
                    required: true
                }
            },
            messages: {
                sel_project_id: {
                    required: "Project not selected"
                },
                sel_title: {
                    required: "Task title is blank"
                },
                sel_priority_level: {
                    required: "Priority level not selected"
                },
                sel_dead_line: {
                    required: "Deadline not selected"
                },
                sel_status: {
                    required: "Status not selected"
                }
            },
            submitHandler: function(form) {
                let task_id = jQuery("input:hidden#task_id").val();
                let project_id = jQuery("select#sel_project_id").val();
                let title = jQuery("input:text#sel_title").val();
                let description = jQuery("textarea#sel_description").val();
                let priority_level = jQuery("select#sel_priority_level").val();
                let status = jQuery("select#sel_status").val();
                let dead_line = jQuery("input:text#sel_dead_line").val();
                let mode = jQuery("input:hidden#mode").val();
                let user_id = jQuery("input:hidden#user_id").val();
                jQuery.ajax({
                    url: "{{ route('ajx-store-task') }}",
                    type: "POST",
                    data: {
                        mode,
                        user_id,
                        task_id,
                        project_id,
                        title,
                        description,
                        priority_level,
                        status,
                        dead_line,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(resp_json) {
                        if (resp_json.status == 1) {
                            jQuery('button.btnClose').trigger('click');
                            for (let index = 1; index <= 3; index++) {
                                showTasksBystatus(project_id, user_id, index);
                            }
                        }
                    },
                }).responseText;

                // form.submit();
            }
        });
        var showTasksBystatus = function(project_id, user_id, status) {
            jQuery.ajax({
                url: "{{ route('ajx-get-task-list') }}",
                type: "POST",
                data: {
                    project_id,
                    user_id,
                    status,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(resp_data) {
                    if (resp_data.status == 1) {
                        if (status == 1) { // for todo
                            jQuery("div.todo-task-area").html(resp_data.html);
                        } else if (status == 2) {
                            jQuery("div.inprogress-task-area").html(resp_data.html);
                        } else if (status == 3) {
                            jQuery("div.done-task-area").html(resp_data.html);
                        }
                    }
                },
            }).responseText;
        }
        var clearTaskForm = function() {
            taskValidator.resetForm();
            jQuery("select#sel_project_id").empty();
            jQuery("input:text#sel_title").val('');
            jQuery("textarea#sel_description").val('');
            jQuery("select#sel_priority_level").val('');
            jQuery("select#sel_status").val('');
            jQuery("input:text#sel_dead_line").val('');
            let projects = JSON.parse(decodeEntity('{{ $projects_json }}'));
            console.log(projects);
            jQuery("select#sel_project_id").append('<option value="" selected="true" disabled>Select project</option>');
            jQuery.each(projects, function(key, entry) {
                jQuery("select#sel_project_id").append($('<option></option>').attr('value', key).text(entry));
            })
        }
        var prepareTaskForm = function(project_id, task_id) {
            clearTaskForm();
            jQuery("select#sel_project_id").val(project_id);
            jQuery("input:hidden#task_id").val(task_id);
            jQuery.ajax({
                url: "{{ route('ajx-get-task') }}",
                type: "POST",
                data: {
                    task_id,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(resp_data) {
                    if (resp_data.status == 1) {
                        var dead_line_obj = new Date(resp_data.task.dead_line);
                        var dead_line = dead_line_obj.toLocaleDateString("en-US");
                        jQuery("input:text#sel_title").val(resp_data.task.title);
                        jQuery("textarea#sel_description").val(resp_data.task.description);
                        jQuery("select#sel_priority_level").val(resp_data.task.priority_level);
                        jQuery("select#sel_status").val(resp_data.task.status);
                        jQuery("input:text#sel_dead_line").val(dead_line);
                        jQuery("input:hidden#mode").val('edit');
                    }
                },
            }).responseText;
        }

        var deleteTask = function(id, title, project_id) {
            if(confirm("want to delete the task:\n" + title)){
                jQuery.ajax({
                    url: "{{route('ajx-delete-task')}}",
                    type: "POST",
                    data: {
                        id,
                        "_token": "{{csrf_token()}}"
                    },
                    dataType: "json",
                    success: function(resp_data){
                        if(resp_data.status == 1){
                            for (let index = 1; index <= 3; index++) {
                                let user_id = "{{ $user_id }}";
                                showTasksBystatus(project_id, user_id, index);
                            }
                        }
                    },
                }).responseText;
            }
        }

        jQuery(document).ready(function() {
            let user_id = "{{ $user_id }}";
            let project_id = "{{ $project_id }}";
            for (let index = 1; index <= 3; index++) {
                showTasksBystatus(project_id, user_id, index);
            }

            jQuery('button.btnCreateTask').bind({
                click: function() {
                    let project_id = $(this).data("project");
                    let task_id = $(this).data("task");
                    clearTaskForm();
                    jQuery("select#sel_project_id").val(project_id);
                    jQuery("input:hidden#task_id").val(task_id);
                    jQuery("input:hidden#mode").val('add');
                }
            });

            //Date picker
            jQuery('#reservationdate').datetimepicker({
                format: 'L'
            });



        });
    </script>
@endsection
