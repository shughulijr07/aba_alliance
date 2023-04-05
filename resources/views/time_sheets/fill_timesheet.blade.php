@extends('layouts.administrator.admin')


@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon text-primary">
                    <i class="fas fa-list-ul"></i>
                </div>
                <div>
                    <div class="text-primary">Time Sheet Tasks</div>
                    <div class="page-title-subheading">
                        <p> <span
                                class="text-muted">{{ date('d F, Y', mktime(0, 0, 0, $time_sheet->month, $day, $time_sheet->year)) }}</span>
                            <strong>{{ $client->name }}</strong>
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    @if (count($tasks) > 0)
                        @php
                            $progress_id = "";
                            $hour = "";
                        @endphp
                        @foreach ($tasks as $item)
                            
                            @foreach (\App\Models\TaskProgress::get_filled_task()->where('task_id', $item->id)->where('task_status', 'complete')->where('task_day', $day)->get() as $task)
                                @php
                                    $task_id = $task->task_id;
                                    $progress_id = $task->id;
                                    $hour = $task->hour;
                                    $status = $task->task_status;
                                @endphp
                                @include('time_sheets.filltaskform')
                            @endforeach
                            @foreach (\App\Models\TaskProgress::get_filled_task()->where('task_id', $item->id)->where('task_status', '!=', 'complete')->where('task_day', $day)->get() as $task)
                                @php
                                    $task_id = $task->task_id;
                                    $progress_id = $task->id;
                                    $hour = $task->hour;
                                    $status = $task->task_status;
                                @endphp
                                @include('time_sheets.filltaskform')
                            @endforeach
                        @endforeach

                        @foreach ($not_in_progress as $task)
                            @php
                                $task_id = $task->id;
                                $status = $task->status;
                            @endphp
                            @include('time_sheets.filltaskform')
                        @endforeach

                        {{-- 
                        @php
                            $completeTask = $task_progress->where('task_status', 'complete')->where('task_id', $task->id)->where('task_day', $day);
                        @endphp
                        @foreach ($completeTask as $task)
                            @include('time_sheets.filltaskform')
                        @endforeach
                        @php
                            $uncompleteTasks = $tasks->where('task_status', '!=', 'complete');
                        @endphp
                        @if (count($uncompleteTasks) > 0)
                            @foreach ($uncompleteTasks as $task)
                                @include('time_sheets.filltaskform')
                            @endforeach
                        @else
                            @if (count($completeTask) == 0)
                                <div class="alert alert-info text-center"><strong>Sorry No pending or on progress Task to
                                        fill
                                        out</strong>
                                </div>
                            @endif
                        @endif --}}
                    @else
                        <div class="alert alert-info text-center"><strong>Sorry No pending or on progress Task to fill
                                out</strong>
                        </div>
                    @endif
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
@endsection
