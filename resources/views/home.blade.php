@extends('layouts.common')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h1>Projects</h1>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-block btn-primary" id="btnNewProject" data-toggle="modal"
                        data-target="#add-project">Add new project</button>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Projects</h3>
            </div>
            <div id="list-projects"></div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
</div>
    <!-- /.content -->
    <!-- /.modal Add project -->
    <div class="modal fade" id="add-project">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Project</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="frmAddProject" id="frmAddProject" enctype="multipart/form-data" method="POST"
                    action="javascript:void(0)">
                    <div class="modal-body">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Project Name</label>
                                    <input type="text" id="title" name="title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="description">Project Description</label>
                                    <textarea id="description" name="description" class="form-control"
                                        rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputStatus">Status</label>
                                    <select id="status" name="status" class="form-control custom-select">
                                        <option selected disabled>Select one</option>
                                        <option value="1">To Do</option>
                                        <option value="2">In Progress</option>
                                        <option value="3">On Hold</option>
                                        <option value="4">Cancelled</option>
                                        <option value="5">Success</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btnAddProjectClose" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnFrmSubmit">Save changes</button>
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
        var showProjects = function() {
            jQuery.ajax({
                url: "{{ route('ajx-get-project-list') }}",
                type: "POST",
                data: {
                    "user_id": {{ $user_id }},
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(resp_data) {
                    if (resp_data.status == 1) {
                        jQuery("div#list-projects").html(resp_data.html)
                    }
                },
            }).responseText;
        }
        jQuery(document).ready(function() {
            showProjects();
            var clearAddForm = function() {
                jQuery("input:text#title").val('');
                jQuery("textarea#description").val('');
                jQuery("select#status").val('');
            }
            jQuery('form#frmAddProject').validate({
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
                    title: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "Project Name is blank"
                    },
                    status: {
                        required: "Status not selected"
                    }
                },
                submitHandler: function(form) {
                    let user_id = "{{ $user_id }}";
                    let title = jQuery("#title").val();
                    let description = jQuery("#description").val();
                    let status = jQuery("#status").val();
                    clearAddForm();
                    jQuery.ajax({
                        url: "{{ route('ajx-save-project')}}",
                        type: "POST",
                        data: {
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
                                jQuery('button.btnAddProjectClose').trigger('click');
                            }
                        },
                    }).responseText;
                    //form.submit();
                }
            });

        });
    </script>
@endsection
