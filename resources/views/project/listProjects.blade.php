<div class="card-body p-0">
    <table class="table table-striped projects">
        <thead>
            <tr>
                <th style="width: 1%">
                    #
                </th>
                <th style="width: 60%">
                    Project Name
                </th>
                <th style="width: 8%" class="text-center">
                    Status
                </th>
                <th style="width: 30%">
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($total_projects > 0)

                @foreach ($projects as $project)
                    <tr>
                        <td>
                            #
                        </td>
                        <td>
                            <a href="{{ route('tasks-by-project',['id' => $project->id]) }}">
                                {{ $project->title }}
                            </a>
                            <br />
                            <small>
                                Created {{ Carbon\Carbon::parse($project->created_at)->format('m.d.Y') }}
                            </small>
                        </td>

                        <td class="project-state">
                            @switch($project->status)
                                @case(1)
                                    <span class="badge badge-warning">To-Do</span>
                                @break
                                @case(2)
                                    <span class="badge badge-info">In Progress</span>
                                @break
                                @case(3)
                                    <span class="badge badge-secondary">On Hold</span>
                                @break
                                @case(4)
                                    <span class="badge badge-danger">Cancel</span>
                                @break
                                @case(5)
                                    <span class="badge badge-success">Success</span>
                                @break
                            @endswitch
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm btnViewProject" href="#" data-user="{{ $user_id }}"
                                data-project="{{ $project->id }}" data-toggle="modal" data-target="#view-project">
                                <i class="fas fa-folder">
                                </i>
                                View
                            </a>
                            <a class="btn btn-info btn-sm btnEditProject" href="#" data-user="{{ $user_id }}"
                                data-project="{{ $project->id }}" data-toggle="modal" data-target="#edit-project">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Edit
                            </a>
                            <a class="btn btn-danger btn-sm btnDeleteProject" href="#" data-user="{{ $user_id }}"
                                data-project="{{ $project->id }}" data-title="{{ $project->title }}">
                                <i class="fas fa-trash">
                                </i>
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" align="center">No projects found</td>
                </tr>
            @endif

        </tbody>
    </table>
</div>

<!-- /.modal view project -->
<div class="modal fade" id="view-project">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Project Name</label>
                        <div id="viewProjectTitle"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Project Description</label>
                        <div id="viewProjectDescription"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Status</label>
                        <div id="viewProjectStatus"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- /.modal edit project -->
<div class="modal fade" id="edit-project">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="frmEditProject" id="frmEditProject" enctype="multipart/form-data" method="POST"
                    action="javascript:void(0)">
                <input type="hidden" name="project_id" id="project_id">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Project Name</label>
                            <input type="text" id="view_title" name="view_title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Project Description</label>
                            <textarea id="view_description" name="view_description" class="form-control"
                                rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">Status</label>
                            <select id="view_status" name="view_status" class="form-control custom-select">
                                <option selected disabled>Select one</option>
                                <option value="1">To Do</option>
                                <option value="2">In Progress</option>
                                <option value="3">On Hold</option>
                                <option value="4">Cancelled</option>
                                <option value="5">Success</option>
                            </select>
                        </div>
                    </div>
                </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btnUpdateProjectClose" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">
    jQuery(document).ready(function() {
        var clearViewForm = function() {
            jQuery("div#viewProjectTitle").html('');
            jQuery("div#viewProjectDescription").html('');
            jQuery("div#viewProjectStatus").html('');
        }
        var clearEditForm = function() {
            jQuery("input:text#view_title").val('');
            jQuery("textarea#view_description").val('');
            jQuery("select#view_status").val('');
        }
        jQuery('a.btnEditProject').bind({
            click: function() {
                clearEditForm();
                let user_id = $(this).data("user");
                let project_id = $(this).data("project");
                jQuery.ajax({
                    url: "{{ route('ajx-view-project') }}",
                    type: "POST",
                    data: {
                        user_id,
                        project_id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(resp_data) {
                        if (resp_data.status == 1) {
                            jQuery("input:text#view_title").val(resp_data.data.project.title);
                            jQuery("textarea#view_description").val(resp_data.data.project.description);
                            jQuery("select#view_status").val(resp_data.data.project.status);
                            jQuery("input:hidden#project_id").val(project_id);
                        }
                    },
                }).responseText;
            }
        });
        jQuery('a.btnViewProject').bind({
            click: function() {
                clearViewForm();
                let user_id = $(this).data("user");
                let project_id = $(this).data("project");
                jQuery.ajax({
                    url: "{{ route('ajx-view-project') }}",
                    type: "POST",
                    data: {
                        user_id,
                        project_id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(resp_data) {
                        if (resp_data.status == 1) {
                            jQuery("div#viewProjectTitle").html(resp_data.data.project
                                .title);
                            jQuery("div#viewProjectDescription").html(resp_data.data
                                .project.description);
                            switch (resp_data.data.project.status) {
                                case 1:
                                    jQuery("div#viewProjectStatus").html("To Do");
                                    break;
                                case 2:
                                    jQuery("div#viewProjectStatus").html("In Progress");
                                    break;
                                case 3:
                                    jQuery("div#viewProjectStatus").html("On Hold");
                                    break;
                                case 4:
                                    jQuery("div#viewProjectStatus").html("cancelled");
                                    break;
                                case 5:
                                    jQuery("div#viewProjectStatus").html("Success");
                                    break;
                            }
                        }
                    },
                }).responseText;

            }
        });
        jQuery('a.btnDeleteProject').bind({
            click: function() {
                let user_id = $(this).data("user");
                let project_id = $(this).data("project");
                let project_title = $(this).data("title");
                if (confirm("Want to delete the project \n" + project_title)) {
                    jQuery.ajax({
                        url: "{{route('ajx-delete-project')}}",
                        type: "POST",
                        data: {
                            project_id,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(resp_data){
                            if(resp_data.status == 1) {
                                showProjects();
                            }
                        },
                    }).responseText;
                }
            }
        });
        jQuery('form#frmEditProject').validate({
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
                view_title: {
                    required: true
                },
                view_status: {
                    required: true
                }
            },
            messages: {
                view_title: {
                    required: "Project Name is blank"
                },
                view_status: {
                    required: "Status not selected"
                }
            },
            submitHandler: function(form) {
                let user_id = "{{ $user_id }}";
                let title = jQuery("#view_title").val();
                let description = jQuery("#view_description").val();
                let status = jQuery("#view_status").val();
                let project_id = jQuery("input:hidden#project_id").val()
                clearEditForm();
                jQuery.ajax({
                    url: "{{ route('ajx-update-project')}}",
                    type: "POST",
                    data: {
                        project_id,
                        user_id,
                        title,
                        description,
                        status,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(resp_data){
                        if(resp_data.status == 1) {
                            showProjects();
                            jQuery('button.btnUpdateProjectClose').trigger('click');
                        }
                    },
                }).responseText;
                //form.submit();
            }
        });
    });
</script>
