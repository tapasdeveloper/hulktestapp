@extends('layouts.common')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h4>{{ \Illuminate\Support\Str::limit($task->project->title, 50, ' ...') }}</h4>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $task->title }}</h3>
                </div>
                <div class="card-body">
                    {{ $task->description }}
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    Add Media
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
            @foreach ($comment_arr as $comment)
                @php
                    $maxCol = 12;
                    $suffixCol = $comment['col'];
                    $prefixCol = $maxCol - $suffixCol;
                @endphp
                <div class="row">
                    @if ($prefixCol > 0)
                        <div class="col-md-{{ $prefixCol }}">&nbsp;</div>
                    @endif
                    <div class="col-md-{{ $suffixCol }}">
                        <div class="card">
                            <div class="card-body">{{ $comment['description'] }}</div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <span >Add Media</span>
                                <span style="margin-left: 20px;">Reply</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('customscript')
@endsection
