<form action="{{ route('fill_day_task') }}" method="post">
    @csrf
    <input type="hidden" name="progress_id" value="{{ $progress_id }}">
    <input type="hidden" name="task_id" value="{{ $task_id }}">
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
                <option value="{{ $status }}">{{ $status }}</option>
                <option value="complete">complete</option>
                <option value="progress">progress</option>
            </select>
        </div>
        <div class="col-md-2"><input type="number" name="hour" min="0"
                max="24" value="{{ $hour }}" class="form-control" required>
        </div>
        <div class="col-md-2"><button type="submit"
                class="btn btn-primary btn-sm">update</button></div>
    </div>
</form>