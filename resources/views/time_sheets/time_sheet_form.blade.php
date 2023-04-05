
<!-- Timesheet  -->
<div class="main-card mb-3 card">
    <div class="card-body">
        <h5 class="card-title text-danger" style="display: none;">Time Sheet Form</h5>

        <!-- Header -->
        <div class="row mb-3">
            <div class="col-md-12">
                <fieldset>
                    <legend class="text-danger"></legend>
                    <div class="form-row"  style="display: none;">
                        <div class="col-md-3">
                            <div class="position-relative form-group">
                                <label for="time_sheet_id" class="">
                                    <span>Time Sheet ID</span>
                                </label>
                                <input name="time_sheet_id" id="time_sheet_id" type="text" class="form-control" value="{{$time_sheet->id}}" readonly>
                                <input name="action" id="action" type="text" class="form-control" value="save-to-draft" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="position-relative form-group">
                                <label for="employee_name" class="">
                                    <span>Employee Name</span>
                                </label>
                                <input name="employee_name" id="employee_name" type="text" class="form-control" value="{{$employee_name}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative form-group">
                                <label for="responsible_spv" class="">
                                    <span>Supervisor</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="responsible_spv" id="responsible_spv" class="form-control @error('country') is-invalid @enderror" @if($supervisors_mode == '1') readonly @endif>
                                    <option value="{{$responsible_spv}}">{{$spv_name}}</option>
                                    {{-- @if($supervisors_mode == '2')<option value="">Select Supervisor</option>@endif
                                    @foreach($timeSheetSupervisors as $timeSheetSupervisor)
                                        <option value="{{$timeSheetSupervisor->id}}" @if(($timeSheetSupervisor->id == old('responsible_spv')) || ($timeSheetSupervisor->id == $responsible_spv)) selected @endif>
                                            {{ucwords($timeSheetSupervisor->first_name.' '.$timeSheetSupervisor->last_name)}}
                                        </option>
                                    @endforeach --}}
                                </select>

                                @error('responsible_spv')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative form-group">
                                <label for="year" class="">
                                    <span>Year</span>
                                </label>
                                <input name="year" id="year" type="text" class="form-control" value="{{$time_sheet->year}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative form-group">
                                <label for="month" class="">
                                    <span>Month</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="month" id="month" class="form-control @error('month') is-invalid @enderror" readonly>
                                    @foreach(\App\Models\TimeSheet::$months as $value => $month_name)
                                        @if($value == $time_sheet->month) <option value="{{$value}}" selected>{{$month_name}}</option> @endif
                                    @endforeach
                                </select>

                                @error('month')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <!-- Header Ends Here-->

        <!-- Lines -->
        <div class="row">

            <!-- Left Part -->
            <div class="col-sm-4 mr-0 pr-0">
                <div class="table-responsive">
                    <table style="width: 100%; !important;" id="timesheet_lines" class="table table-hover table-striped table-bordered ">
                        <thead>
                        <tr >
                            <th class="no-wrap ctitle" colspan="2" style="border-color: #ffffff !important;"></th>
                        </tr>
                        <tr class="bg-primary text-white">
                            <th class="no-wrap ctitle">Client Name</th>
                            <th class="no-wrap">Total Hrs</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client_data2)
                            <tr>
                                <td class="no-wrap ctitle">{{$client_data2->name}}</td>
                                <td class="no-wrap total-one-project" id="total--project--{{$client_data2->number}}">0</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="bg-danger text-white">
                            <th class="no-wrap ctitle">Total Project Hours</td>
                            <th class="no-wrap" id="total_project_hrs">0</th>
                        </tr>


                        <tr style="border: none;">
                            <td  style="border: none;"></td>
                            <th  style="border: none;"></th>
                        </tr>


                        {{-- <tr class="bg-light-dark">
                            <td class="no-wrap ctitle">Vacation</td>
                            <td class="no-wrap total-one-vacation" id="total--vacation--1">0</td>
                        </tr>
                        <tr>
                            <td class="no-wrap ctitle">Sick</td>
                            <td class="no-wrap total-one-sick" id="total--sick--1">0</td>
                        </tr>
                        <tr class="bg-light-dark">
                            <td class="no-wrap ctitle">Holiday</td>
                            <td class="no-wrap total-one-holiday" id="total--holiday--1">0</td>
                        </tr>
                        <tr>
                            <td class="no-wrap ctitle">Other</td>
                            <td class="no-wrap total-one-other" id="total--other--1">0</td>
                        </tr>
                        <tr class=" bg-danger text-white">
                            <th class="no-wrap ctitle">Grand Total Hours</th>
                            <th class="no-wrap" id="grand_total_hrs">0</th>
                        </tr> --}}
                        </tfoot>

                    </table>
                </div>
            </div>
            <!-- Left Part Ends Here -->

            <!-- Right Part -->
            <div class="col-sm-8">
                <div class="table-responsive">
                    <table style="width: 100%; !important;" id="timesheet_lines" class="table table-hover table-striped table-bordered ">

                        <!-- Table Head Starts Here -->
                        <thead>
                        <tr  class="bg-danger text-white">
                            @for( $d=1 ; $d<=$days_in_month; $d++)
                                <?php
                                $day_name = date('D',strtotime($d.'-'.$time_sheet->month.'-'.$time_sheet->year));
                                $full_date = date('d-m-Y',strtotime($d.'-'.$time_sheet->month.'-'.$time_sheet->year));
                                ?>
                                <th class="timesheet-date @if($day_name == 'Sat' || $day_name == 'Sun') bg-weekend  @endif   @if( in_array($full_date,array_keys($holidays))) bg-holiday @endif" >{{$day_name}}</th>
                            @endfor
                        </tr>
                        <tr  class="bg-primary text-white">
                            @for( $d=1 ; $d<=$days_in_month; $d++)
                                <?php
                                $day_name = date('D',strtotime($d.'-'.$time_sheet->month.'-'.$time_sheet->year));
                                $full_date = date('d-m-Y',strtotime($d.'-'.$time_sheet->month.'-'.$time_sheet->year));
                                ?>
                                <th class="timesheet-date @if($day_name == 'Sat' || $day_name == 'Sun') bg-weekend @endif   @if( in_array($full_date,array_keys($holidays))) bg-holiday @endif">{{$d}}</th>
                            @endfor
                        </tr>
                        </thead>
                        <!-- Table Head Ends Here -->


                        <!-- Table Body Starts Here, All Projects Entries Are Found Here -->
                        <tbody>
                        @foreach($clients as $client_data)
                            <tr class="project-row" id="project--{{$client_data->number}}">
                                @for( $d=1 ; $d<=$days_in_month; $d++)
                                   @php
                                        $day_name = date('D',strtotime($d.'-'.$time_sheet->month.'-'.$time_sheet->year));
                                        $full_date = date('d-m-Y',strtotime($d.'-'.$time_sheet->month.'-'.$time_sheet->year));
                                        $hour = \App\Models\Task::where('timesheet_client_id', $client_data->id)->where('task_day', $d)->sum('hour');
                                        $hour = ($hour > 0) ? $hour : '' ;
                                   @endphp
                                    <td class="project-column project--{{$client_data->number}} date--{{$d}}  @if($day_name == 'Sat' || $day_name == 'Sun') bg-weekend @endif   @if( in_array($full_date,array_keys($holidays))) bg-holiday @endif">
                                        {{-- <input type="" class="column-input"  > --}}
                                        <a href="{{ route('fill-timesheet', ['timesheet_client'=>$client_data->id,'time_sheet'=>$time_sheet->id,'d' => $d]) }}" class="btn w-100 h-100">{{$hour}}</a>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                        </tbody>
                        <!-- Table Body Ends Here -->


                        <!-- Table Foot Starts Here -->
                        <tfoot>

                        <!-- Daily Total For All Projects (Each column contains total for all hours worked for each project in a day)-->
                        <tr class="total-project-hrs-row bg-danger text-white">
                            @for( $d=1 ; $d<=$days_in_month; $d++)
                                <?php
                                $day_name = date('D',strtotime($d.'-'.$time_sheet->month.'-'.$time_sheet->year));
                                $full_date = date('d-m-Y',strtotime($d.'-'.$time_sheet->month.'-'.$time_sheet->year));
                                ?>
                                <th class="timesheet-date  @if($day_name == 'Sat' || $day_name == 'Sun') bg-weekend @endif   @if( in_array($full_date,array_keys($holidays))) bg-holiday @endif" id="projects--day--total--{{$d}}">0</th>
                            @endfor
                        </tr>
                        <!-- Daily Total For All Projects Ends Here -->



                        <!-- Gape Starts Here -->
                        <tr class="gape" style="border: none;">
                            @for( $d=1 ; $d<=$days_in_month; $d++)
                                <td  style="border: none;"></td>
                            @endfor
                        </tr>
                        <!-- Gape Ends Here -->






                        <!-- Grand Total Starts Here -->
                        <tr class="grand-total-row bg-danger text-white">
                            @for( $d=1 ; $d<=$days_in_month; $d++)
                                <?php
                                $day_name = date('D',strtotime($d.'-'.$time_sheet->month.'-'.$time_sheet->year));
                                $full_date = date('d-m-Y',strtotime($d.'-'.$time_sheet->month.'-'.$time_sheet->year));
                                ?>
                                <th class="timesheet-date  @if($day_name == 'Sat' || $day_name == 'Sun') bg-weekend @endif   @if( in_array($full_date,array_keys($holidays))) bg-holiday @endif" id="grand-total-day-{{$d}}">0</th>
                            @endfor
                        </tr>
                        <!-- Grand Total Ends Here -->



                        </tfoot>
                        <!-- Table Foot Ends Here -->




                    </table>
                </div>

                @if( auth()->user()->staff->id == $time_sheet->staff_id)
                    @if( $time_sheet->status == '0' )
                        <div class="text-right mt-2">
                            <input class="mt-2 btn btn-primary" type="submit" id="submit_time_sheet_btn1" name="action" value="Submit Time Sheet">
                        </div>
                    @endif

                    @if( $time_sheet->status == '10' )
                        <div class="text-right mt-2">
                            <input class="mt-2 btn btn-secondary" type="submit"  id="save_to_draft_btn1" name="action" value="Save To Drafts">
                            <input class="mt-2 btn btn-primary" type="submit" id="submit_time_sheet_btn1" name="action" value="Submit Time Sheet">
                        </div>
                    @endif
                @endif

                @if( ($time_sheet->status > 10 && $time_sheet->status <= 40)  && in_array(auth()->user()->role_id, [1,3]) && $view_type != 'edit_admin')
                    <div class="text-right mt-2">
                        <a class="btn btn-primary mt-2" href="{{url('/time_sheet_edit_admin/'.$time_sheet->id)}}" role="button">Edit Time Sheet</a>
                    </div>
                @endif

                @if( ($time_sheet->status > 10 && $time_sheet->status <= 40)  && in_array(auth()->user()->role_id, [1,3]) && $view_type == 'edit_admin')
                    <div class="text-right mt-2">
                        <input class="mt-2 btn btn-primary" type="submit" id="save_edited_timesheet" name="action" value="Save Time Sheet">
                    </div>
                @endif

            </div>
            <!-- Right Part Ends Here-->

        </div>
        <!-- Lines Ends Here-->

    </div>
</div>
<!-- Timesheet Ends Here -->



<!--scripts -->
<script type="text/javascript">

    $(function () {
        $('#notifications-div').delay(7000).fadeOut('slow');

        $(".column-input").each(function(){
            //get details of this column
            var selected_column = $(this);
            update_totals(selected_column);
        });

        //update total hours for each project in percentage
        //calculate_project_hrs_percentage();
    });


    $(".column-input").on('change',function(){

        //get details of this column
        var selected_column = $(this);
        update_totals(selected_column);

    });


    function update_totals(selected_column){

        var column_id = selected_column.attr('id');
        var id_parts = column_id.split('--');
        var row_type = id_parts[0];
        var row_type_no = id_parts[1];
        var column_date = id_parts[2];


        //get parent row of this column and its details
        var row = selected_column.parent().parent();
        var row_id = row.attr('id');

        //calculate total number of hrs  for this row
        var row_columns = row.children("td").children(".column-input");
        var row_total_hrs = 0;

        row_columns.each(function(index){
            var work_hrs = $(this).val();
            if(work_hrs == ''){ work_hrs = 0; }
            work_hrs = Number(work_hrs);
            if( work_hrs >= 0){
                row_total_hrs = row_total_hrs + work_hrs;
            }else{
                $(this).val('');
            }

        });

        //record total for this row
        var row_total_id = "#total--"+row_type+'--'+row_type_no;
        $(row_total_id).text(row_total_hrs);


        //calculate total number of hours for all projects in this day (the day in which this column is)
        var total_day_hrs_for_all_projects = 0;
        $(".project--"+column_date).each(function () {
            var day_hrs_for_one_projects = $(this).val();

            if(day_hrs_for_one_projects == ''){ day_hrs_for_one_projects = 0 }

            day_hrs_for_one_projects = Number(day_hrs_for_one_projects);
            if( day_hrs_for_one_projects >=0 ){
                total_day_hrs_for_all_projects += day_hrs_for_one_projects;
            }else{
                $(this).val('');
            }

        });
        $("#projects--day--total--"+column_date).text(total_day_hrs_for_all_projects);


        //calculate grand total hours for this day (the day in which this column is)
        var grand_total_hrs_in_one_day = 0;
        $(".column-day-"+column_date).each(function () {
            var day_hrs_for_one_cell = $(this).val();

            if( day_hrs_for_one_cell == '' ){ day_hrs_for_one_cell = 0; }

            day_hrs_for_one_cell = Number(day_hrs_for_one_cell);
            if(day_hrs_for_one_cell >= 0){
                grand_total_hrs_in_one_day += day_hrs_for_one_cell;
            }else{
                $(this).val('');
            }

        });
        $("#grand-total-day-"+column_date).text(grand_total_hrs_in_one_day);



        //calculate total project hrs for all projects for all days
        var total_hrs_for_all_projects = 0;
        $(".total-one-project").each(function () {
            var total_for_one_project = Number($(this).text());
            total_hrs_for_all_projects += total_for_one_project;
        });
        $("#total_project_hrs").text(total_hrs_for_all_projects);


        //calculate grand total hrs for everything for all days
        var grand_total_hrs = 0;

        var total_project_hrs = $("#total_project_hrs").text();
        var total_vacation_hrs = $("#total--vacation--1").text();
        var total_sick_hrs = $("#total--sick--1").text();
        var total_holiday_hrs = $("#total--holiday--1").text();
        var total_other_hrs = $("#total--other--1").text();

        grand_total_hrs = Number(total_project_hrs) + Number(total_vacation_hrs) + Number(total_sick_hrs);
        grand_total_hrs = grand_total_hrs + Number(total_holiday_hrs) + Number(total_other_hrs);

        $("#grand_total_hrs").text(grand_total_hrs);

        calculate_project_hrs_percentage1();

    }



    /******************** Level Of Effort (LOE) calculations for projects *******************/


    function calculate_project_hrs_percentage1(){

        var total_hrs_for_each_project = $(".total-one-project");
        var total_hrs_for_all_projects = $("#total_project_hrs").text();

        total_hrs_for_each_project.each(function(){
            var total_hrs_for_one_project = $(this).text();
            var project_id = $(this).attr('id');
            var total_hrs_for_one_project_in_percentage;

            var project_id_parts = project_id.split('--');
            var project_no = project_id_parts[2];

            if( total_hrs_for_all_projects == 0){
                total_hrs_for_one_project_in_percentage = 0;
            }else{
                total_hrs_for_one_project_in_percentage = (total_hrs_for_one_project/total_hrs_for_all_projects)*100;
            }


            //update LOE on summary section
            $("#hrs--project--"+project_no).text(total_hrs_for_one_project);
            $("#percentage--project--"+project_no).text(total_hrs_for_one_project_in_percentage.toFixed(0));

            //alert(project_no);

            //$(this).text(project_total_hrs_text);
        })

    }

    /******************** Level Of Effort (LOE) calculations for projects *******************/


    function sweet_alert_success(success_message){
        Swal.fire({
            type: "success",
            text: success_message,
            confirmButtonColor: '#213368',
        })
    }


    function sweet_alert_error(error_message){
        Swal.fire({
            type: "error",
            text: error_message,
            confirmButtonColor: '#213368',
        })
    }

    function sweet_alert_warning(warning_message){
        Swal.fire({
            type: "warning",
            text: warning_message,
            confirmButtonColor: '#213368',
        })
    }


</script>