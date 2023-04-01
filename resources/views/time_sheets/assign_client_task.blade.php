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
                    <div class="text-primary">{{ date("F", mktime(0, 0, 0, $time_sheet->month, 1)) }}</div>
                    
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
                <button class="btn btn-primary">Add Client</button>
            </div>
        </div>
    </div>

@endsection