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
                            <strong>{{ $client->name }}</strong></p>
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
                        @foreach ($tasks as $task)
                            <form action="{{ route('fill_day_task') }}" method="post">
                                @csrf
                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                <input type="hidden" name="day_date"
                                    value="{{ date('Y-m-d', mktime(0, 0, 0, $time_sheet->month, $day, $time_sheet->year)) }}">
                                <input type="hidden" name="timesheet_client_id" value="{{ $client->id }}">
                                <input type="hidden" name="task_day" value="{{ $day }}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <p><strong>{{ $task->task_name }}</strong></p>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="status" id="" class="form-control" required>
                                            <option value="{{ $task->status }}">{{ $task->status }}</option>
                                            <option value="complete">complete</option>
                                            <option value="progress">progress</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2"><input type="number" name="hour" min="0" max="24"
                                            value="{{ $task->hour }}" class="form-control" required></div>
                                    <div class="col-md-2"><button type="submit"
                                            class="btn btn-primary btn-sm">update</button></div>
                                </div>
                            </form>
                        @endforeach
                    @else
                        <div class="alert alert-info text-center"><strong>Sorry No pending or on progress Task to fill out</strong>
                        </div>
                    @endif
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
@endsection
