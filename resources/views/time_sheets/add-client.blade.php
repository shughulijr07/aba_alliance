@extends('layouts.administrator.admin')


@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon text-primary">
                    <i class="fas fa-file"></i>
                </div>
                <div class="p-3">
                    <div class="page-title-subheading">
                        Employee
                    </div>
                    <div class="text-primary">{{ $employee_name }}</div>

                </div>

                <div class="p-3">
                    <div class="page-title-subheading">
                        Supervisor
                    </div>
                    <div class="text-primary">{{ $spv_name }}</div>

                </div>

                <div class="p-3">
                    <div class="page-title-subheading">
                        Year
                    </div>
                    <div class="text-primary">{{ $time_sheet->year }}</div>

                </div>

                <div class="p-3">
                    <div class="page-title-subheading">
                        Month
                    </div>
                    <div class="text-primary">{{ date('F', mktime(0, 0, 0, $time_sheet->month, 1)) }}</div>

                </div>


                <div class="p-3">
                    <div class="page-title-subheading">
                        Status
                    </div>
                    <div class="text-primary">{{ $time_sheet->status }}</div>

                </div>

            </div>

            <!--actions' menu starts here -->
            <!--actions' menu ends here -->

        </div>
    </div>
   
    <div class="card">
        <div class="card-body">
            <div class="col-auto float-right ml-auto">
                {{-- <a href="{{ route('timesheet-add-client', ['time_sheet'=>$time_sheet->id]) }}" class="btn btn-primary">Add Client</a> --}}
                <button data-toggle="modal" data-target="#add_client" class="btn btn-primary">Add Client</button>
                <div>
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="time_sheet_id" value="{{ $time_sheet->id }}">
                        <div class="form-group">
                            <label for="">Client</label>
                            <select name="project_id" id="" class="form-control">
                                <option value="">select client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->number }} {{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="0" role="dialog" aria-labelledby="modal" aria-hidden="true" id="modal">
        <div class="modal-dialog modal-lg" id="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #00838F; color: #ffffff;">
                    <h5 class="modal-title" id="modalTitle">Modal Title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
    
                <div class="modal-body" id="modalBody">Modal Body Goes Here</div>
    
                <div class="modal-footer" id="modalFooter">Modal Footer Goes Here</div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_client" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add client to Timesheet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="time_sheet_id" value="{{ $time_sheet->id }}">
                        <div class="form-group">
                            <label for="">Client</label>
                            <select name="project_id" id="" class="form-control">
                                <option value="">select client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->number }} {{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
