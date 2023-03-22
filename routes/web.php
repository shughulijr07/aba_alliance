<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Route;
use App\Events\TimeSheetSubmittedEvent;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\GlAccountsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\SystemUsersController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\LeaveEntitlementsController;
use App\Http\Controllers\LeaveReportsController;
use App\Http\Controllers\LeaveTypesController;
use App\Http\Controllers\LeavePlansController;
use App\Http\Controllers\TimeSheetsController;
use App\Http\Controllers\TimeSheetLateSubmissionsController;
use App\Http\Controllers\TimeSheetReportsController;
use App\Http\Controllers\TravelRequestsController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\ActiveProjectsController;
use App\Http\Controllers\RequisitionRequestsController;
use App\Http\Controllers\AdvancePaymentRequestsController;
use App\Http\Controllers\SupervisorsController;
use App\Http\Controllers\PerformanceObjectivesController;
use App\Http\Controllers\StaffPerformancesController;
use App\Http\Controllers\RetirementRequestsController;
use App\Http\Controllers\CompanyInformationController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\StaffDependentsController;
use App\Http\Controllers\StaffBiographicalDataSheetsController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\DistrictsController;
use App\Http\Controllers\RegionsController;
use App\Http\Controllers\SystemRolePermissionsController;
use App\Http\Controllers\SystemRolesController;
use App\Http\Controllers\StaffsJobTitlesController;
use App\Http\Controllers\WardsController;
use App\Http\Controllers\NumberedItemsController;
use App\Http\Controllers\NumberSeriesController;
use App\Http\Controllers\UserActivitiesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\DeveloperProcessesController;
use App\Http\Controllers\StaffEmergencyContactsController;
use App\Mail\PasswordReset;
use App\Models\LeaveEntitlement;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

Auth::routes();

Route::get('/home', function(){ return redirect('employee');});
Route::view('/','auth.login');

Route::get('/send_time_sheet',function(){
    return event( new \App\Events\SendTimeSheetToBC130());
});

Route::get('/send_travel_request',function(){
    return event( new \App\Events\SendTravelRequestToBC130());
});


Route::get('/email', function(){
    $staff = \App\Models\Staff::find(14);

    //send email to employee
    $employee_official_email = $staff->official_email;

    $recipient_type = 'staff';
    $recipient = $staff;
    Mail::to('susumashoma@gmail.com')->send(new PasswordReset($recipient_type,$recipient));

});


/******************************** BASIC ROUTES *********************************/
Route::get('super-administrator',[DashboardsController::class,"showSuperAdminDashboard"]);
Route::get('system-administrator',[DashboardsController::class,"showSystemAdministratorDashboard"])->middleware('system-admin');
Route::get('finance-director',[DashboardsController::class, 'showFDDashboard'])->middleware('fd');
Route::get('managing-director',[DashboardsController::class, 'showMDDashboard'])->middleware('md');
Route::get('human-resource-manager',[DashboardsController::class, 'showHRMDashboard'])->middleware('hrm');
Route::get('accountant',[DashboardsController::class, 'showAccountantDashboard'])->middleware('accountant');
Route::get('supervisor',[DashboardsController::class, 'showSupervisorDashboard'])->middleware('supervisor');
Route::get('employee',[DashboardsController::class, 'showEmployeeDashboard'])->middleware('employee');




/************ LEAVE MANAGEMENT ROUTES *************************/

    Route::get('/request_leave',[LeavesController::class, 'create']);
    Route::post('/request_leave',[LeavesController::class,'store']);
    Route::get('/leaves/{status}',[LeavesController::class,'index']);
    Route::get('/admin_leaves/{status}',[LeavesController::class,'adminIndex']);
    Route::get('/leave/{id}',[LeavesController::class,'show']);
    Route::get('/leave_admin/{id}',[LeavesController::class,'showAdmin']);
    Route::get('/time_sheet_admin/leave_admin/{id}',[LeavesController::class,'showAdmin']);
    Route::post('/approve_leave',[LeavesController::class,'approveLeave']);
    Route::post('/confirm_leave_payment',[LeavesController::class,'confirmPayment']);
    Route::post('/modify_leave',[LeavesController::class,'modifyApproveLeave']);
    Route::post('/modify_leave',[LeavesController::class,'modifyApproveLeave']);
    Route::post('/change_supervisor',[LeavesController::class,'changeSupervisor']);
    Route::post('/reject_leave',[LeavesController::class,'rejectLeave']);
    Route::get('/leave_statement/{id}',[LeavesController::class,'showLeaveStatement']);
    Route::get('/my_leaves',[LeavesController::class,'myLeavesIndex']);
    Route::post('/my_leaves',[LeavesController::class,'myLeavesList']);
    Route::get('/overlapping_leaves/{id}',[LeavesController::class,'overlappingLeaves']);



Route::controller(LeaveEntitlementsController::class)
->group(function(){
Route::get('/leave_entitlements/create','create');
Route::post('/leave_entitlements','store');
Route::get('/leave_entitlements','index');
Route::get('/leave_entitlements/{id}','show');
Route::get('/leave_entitlements/{id}/edit','edit');
Route::patch('/leave_entitlements/{id}','update');
Route::get('/perform_carry_over/{staff_id}','performCarryOver');
});

Route::get('/leave_reports',[LeaveReportsController::class, 'index']);
Route::post('/generate_leave_report',[LeaveReportsController::class, 'generateReport']);


Route::resource('leave_types', LeaveTypesController::class);


Route::controller(LeavePlansController::class)
->group(function(){

Route::get('/leave_plan_remove_line/{line_id}','removeLine');
Route::get('/leave_plan_submit/{leave_plan_id}','submitLeavePlan');
Route::get('/leave_plan_admin/{id}','showAdmin');
Route::get('/leave/leave_plans/{id}','showById');
Route::get('/leave_admin/leave_plans/{id}','showAdmin');
Route::get('/admin_leave_plans/{status}','adminIndex');
Route::get('/leave_plan_summary/{mode}','leavePlansSummary');

Route::post('/approve_leave_plan','approveLeavePlan');
Route::post('/return_leave_plan','returnLeavePlan');
Route::post('/change_leave_plan_spv','changeSupervisor');
Route::post('/reject_leave_plan','rejectLeavePlan');
});
Route::resource('leave_plans', LeavePlansController::class );


/************ TIME SHEETS MANAGEMENT ROUTES *************************/
Route::controller(TimeSheetsController::class)
->group(function(){
Route::get('/new_time_sheet','create');
Route::post('/new_time_sheet','store');
Route::get('/create_timesheet_for_another_staff','createForAnotherStaff');
Route::post('/create_timesheet_for_another_staff','storeForAnotherStaff');

Route::get('/create_time_sheet_entries/{id}','createTimeSheetLines');
Route::post('/create_time_sheet_entries','storeTimesheetData');
Route::get('/create_time_sheet_entries_admin/{id}','createTimeSheetLinesAdmin');
Route::post('/create_time_sheet_entries_admin','storeTimesheetDataAdmin');

Route::get('/time_sheets/{status}','index');
Route::get('/admin_time_sheets/{status}','adminIndex');

Route::get('/time_sheet/{id}','show');
Route::get('/time_sheet_admin/{id}','showAdmin');
Route::get('/time_sheet_edit/{id}','editTimeSheetData');
Route::get('/time_sheet_edit_admin/{id}','adminEditTimeSheetData');
Route::post('/time_sheet_edit','update');
Route::get('/my_time_sheets','myTimeSheetsIndex');
Route::post('/my_time_sheets','myTimeSheetsList');

Route::post('/approve_timesheet','approveTimeSheet');
Route::post('/return_timesheet','returnTimeSheet');
Route::post('/change_timesheet_spv','changeSupervisor');
Route::post('/reject_timesheet','rejectTimeSheet');
Route::get('/time_sheet_statement/{id}','showTimeSheetStatement');
});



Route::resource('time_sheet_late_submissions',TimeSheetLateSubmissionsController::class);
Route::get('/unlock_time_sheet_submission/{id} ',[TimeSheetLateSubmissionsController::class, 'unlockTimeSheetSubmission']);


Route::controller(TimeSheetReportsController::class)
->group(function(){
    Route::get('/time_sheet_reports','index');
    Route::post('/generate_time_sheet_report','generateReport');
});



Route::get('/holidays_list/{year}',[HolidaysController::class, 'index2']);
Route::get('/supervisors/delete/{supervisor_id}',[SupervisorsController::class, 'delete']);

Route::resource('supervisors',SupervisorsController::class);


/************ PROJECTS ROUTES *************************/
Route::resource('holidays',HolidaysController::class);
Route::get('/projects/ajaxGetList/', [ProjectsController::class, 'ajaxGetList'])->name('projects.ajaxGetList');
Route::post('/projects/ajaxDelete/', [ProjectsController::class, 'ajaxDelete'])->name('projects.ajaxDelete');
Route::get('/activities/getList/', [ActivitiesController::class, 'getList'])->name('activities.getList');
Route::post('/activities/ajaxDelete/', [ActivitiesController::class, 'ajaxDelete'])->name('activities.ajaxDelete');
Route::post('/activities/ajaxGetByProject/', [ActivitiesController::class, 'ajaxGetActivitiesByProject'])->name('activities.ajaxGetByProject');
Route::get('/gl_accounts/ajaxGetList/', [GlAccountsController::class, 'ajaxGetList'])->name('gl_accounts.ajaxGetList');
Route::post('/gl_accounts/ajaxDelete/', [GlAccountsController::class, 'ajaxDelete'])->name('gl_accounts.ajaxDelete');

Route::get('/activities/import_from_excel', [ActivitiesController::class, 'importFromExcel']);
Route::get('/gl_accounts/import_from_excel', [GlAccountsController::class, 'importFromExcel']);


Route::resource('projects',ProjectsController::class);
Route::resource('activities',ActivitiesController::class);
Route::resource('active_projects',ActiveProjectsController::class);
Route::resource('gl_accounts',GlAccountsController::class);




/************ TRAVEL MANAGEMENT ROUTES *************************/

Route::controller(TravelRequestsController::class)
->group(function(){
Route::get('/new_travel_request','create');
Route::post('/travel_request','store');
Route::get('/travel_request/{id}','show');
Route::patch('/travel_request_update/{id}','update');
Route::get('/travel_requests/{status}','index');
Route::get('/admin_travel_requests/{status}','adminIndex');
Route::get('/travel_requests_admin/{id}','showAdmin');
Route::get('/travelFilePreview/{is}','filePreview');
Route::get('/travel_request/activities','activities');

Route::post('/approve_travel_request','approveTravelRequest');
Route::post('/return_travel_request','returnTravelRequest');
Route::post('/change_travel_request_spv','changeSupervisor');
Route::post('/reject_travel_request','rejectTravelRequest');


Route::get('/my_travel_records','myTravelRequestsIndex');
Route::post('/my_travel_records','myTravelRequestsList');
Route::get('/staff_travel_records','staffTravelRequestsIndex');
Route::post('/staff_travel_records','staffTravelRequestsList');
Route::get('/travel_request_statement/{id}','showTravellingStatement');
});

/************ REQUISITION MANAGEMENT ROUTES *************************/
Route::controller(RequisitionRequestsController::class)
->group(function(){
Route::get('/new_requisition_request','create');
Route::post('/requisition_request','store');
Route::get('/requisition_request/{id}','show');
Route::patch('/requisition_request_update/{id}','update');
Route::get('/requisition_requests/{status}','index');
Route::get('/admin_requisition_requests/{status}','adminIndex');
Route::get('/requisition_requests_admin/{id}','showAdmin');
Route::get('/requisitionFilePreview/{is}','filePreview');
Route::get('/requisition_activities','activities');

Route::post('/approve_requisition_request','approveTravelRequest');
Route::post('/return_requisition_request','returnTravelRequest');
Route::post('/change_requisition_request_spv','changeSupervisor');
Route::post('/reject_requisition_request','rejectTravelRequest');


Route::get('/my_requisition_records','myTravelRequestsIndex');
Route::post('/my_requisition_records','myTravelRequestsList');
Route::get('/staff_requisition_records','staffTravelRequestsIndex');
Route::post('/staff_requisition_records','staffTravelRequestsList');
Route::get('/requisition_request_statement/{id}','showTravellingStatement');
});

/************ ADVANCE PAYMENT MANAGEMENT ROUTES *************************/
Route::controller(AdvancePaymentRequestsController::class)
->group(function(){
Route::get('/new_advance_payment_request','create');
Route::post('/advance_payment_request','store');
Route::get('/advance_payment_request/{id}','show');
Route::get('/advance_payment_request/{id}/{responseType}','show');
Route::get('/advance_payment_request_edit/{id}','edit');
Route::get('/advance_payment_request_edit/{id}/{responseType}','edit');
Route::patch('/advance_payment_request_update/{id}','update');
Route::get('/advance_payment_requests/{status}','index');
Route::get('/admin_advance_payment_requests/{status}','adminIndex');
Route::get('/advance_payment_requests_admin/{id}','showAdmin');
Route::get('/advance_payment_requests_admin/{id}/{responseType}','showAdmin');

Route::post('/approve_advance_payment_request','approveRequest');
Route::post('/return_advance_payment_request','returnRequest');
Route::post('/change_advance_payment_request_spv','changeSupervisor');
Route::post('/reject_advance_payment_request','rejectRequest');


Route::get('/my_advance_payment_records','myRequestsIndex');
Route::post('/my_advance_payment_records','myRequestsList');
Route::get('/staff_advance_payment_records','staffRequestsIndex');
Route::post('/staff_advance_payment_records','staffRequestsList');
Route::get('/advance_payment_request_statement/{id}','showStatement');

Route::post('/advance_payment_requests.ajaxDeleteMultiple','deleteMultiple')->name('advance_payment_requests.ajaxDeleteMultiple');
Route::post('/advance_payment_requests.ajaxApproveMultiple','approveMultipleRequests')->name('advance_payment_requests.ajaxApproveMultiple');
Route::post('/advance_payment_requests.ajaxApprove','approveRequest')->name('advance_payment_requests.ajaxApprove');
Route::post('/advance_payment_requests.ajaxReturnForCorrection','returnRequest')->name('advance_payment_requests.ajaxReturnForCorrection');
Route::post('/advance_payment_requests.ajaxChangeSupervisor','changeSupervisor')->name('advance_payment_requests.ajaxChangeSupervisor');
Route::post('/advance_payment_requests.ajaxReject','rejectRequest')->name('advance_payment_requests.ajaxReject');
});


/************ REQUISITION MANAGEMENT ROUTES *************************/
Route::controller(RequisitionRequestsController::class)
->group(function(){
Route::get('/new_requisition_request','create');
Route::post('/requisition_request','store');
Route::get('/requisition_request/{id}','show');
Route::patch('/requisition_request_update/{id}','update');
Route::get('/requisition_requests/{status}','index');
Route::get('/admin_requisition_requests/{status}','adminIndex');
Route::get('/requisition_requests_admin/{id}','showAdmin');
Route::get('/requisitionFilePreview/{is}','filePreview');
Route::get('/requisition_activities','activities');

Route::post('/approve_requisition_request','approveTravelRequest');
Route::post('/return_requisition_request','returnTravelRequest');
Route::post('/change_requisition_request_spv','changeSupervisor');
Route::post('/reject_requisition_request','rejectTravelRequest');


Route::get('/my_requisition_records','myTravelRequestsIndex');
Route::post('/my_requisition_records','myTravelRequestsList');
Route::get('/staff_requisition_records','staffTravelRequestsIndex');
Route::post('/staff_requisition_records','staffTravelRequestsList');
Route::get('/requisition_request_statement/{id}','showTravellingStatement');
});

/************ RETIREMENT MANAGEMENT ROUTES *************************/
Route::controller(RetirementRequestsController::class)
->group(function(){
Route::get('/new_retirement_request/{id}','create');
Route::post('/retirement_request','store');
Route::get('/retirement_request/{id}','show');
Route::patch('/retirement_request_update/{id}','update');
Route::get('/retirement_requests/{status}','index');
Route::get('/admin_retirement_requests/{status}','adminIndex');
Route::get('/retirement_requests_admin/{id}','showAdmin');
Route::get('/retirementFilePreview/{is}','filePreview');
Route::get('/retirement_activities','activities');
Route::get('/admin_retirementadvance_payment_requests/{status}','adminIndexPayment');


Route::post('/approve_retirement_request','approveTravelRequest');
Route::post('/return_retirement_request','returnTravelRequest');
Route::post('/change_retirement_request_spv','changeSupervisor');
Route::post('/reject_retirement_request','rejectTravelRequest');


Route::get('/my_retirement_records','myTravelRequestsIndex');
Route::post('/my_retirement_records','myTravelRequestsList');
Route::get('/staff_retirement_records','staffTravelRequestsIndex');
Route::post('/staff_retirement_records','staffTravelRequestsList');
Route::get('/retirement_request_statement/{id}','showTravellingStatement');
});


/************ PERFORMANCE MANAGEMENT ROUTES *************************/
Route::controller(PerformanceObjectivesController::class)
->group(function(){
Route::get('/set_objectives','create');
Route::post('/submit_objectives','store');
Route::patch('/update_objectives/{id}','update');
Route::get('/performance_objective/{id}','show');
Route::get('/performance_objective_admin/{id}','showAdmin');
Route::get('/performance_objectives/{status}','index');
Route::get('/admin_performance_objectives/{status}','adminIndex');

Route::post('/approve_objectives','approvePerformanceObjectives');
Route::post('/return_objectives','returnPerformanceObjectives');
Route::post('/change_objectives_spv','changeSupervisor');
Route::post('/reject_objectives','rejectPerformanceObjectives');
});


Route::controller(StaffPerformancesController::class)
->group(function(){
Route::get('/staff_performances','index');
Route::get('/staff_performances_admin/{year}','indexAdmin');
Route::get('/staff_performances/{performance_id}','show');
Route::post('/first_quoter_staff_performance_assessment','firstQuoterAssessment');
Route::post('/second_quoter_staff_performance_assessment','secondQuoterAssessment');
Route::post('/third_quoter_staff_performance_assessment','thirdQuoterAssessment');
Route::post('/fourth_quoter_staff_performance_assessment','fourthQuoterAssessment');
});


/***************************** MIXED ROUTES'*****************************/
Route::controller(StaffController::class)
->group(function(){
Route::get('/staff_supervisors','supervisorsIndex');
Route::post('/staff_supervisor_update','supervisorsUpdate');
});


Route::get('/create_staff_biographical_data_sheets/{staff_id}',[StaffBiographicalDataSheetsController::class, 'createForStaff']);
Route::get('/reset_staff_password/{id}',[UserAccountController::class, 'resetPassword']);
Route::get('/company_information',[CompanyInformationController::class, 'show']);
Route::post('/company_information',[CompanyInformationController::class, 'update']);
Route::get('/general_settings',[GeneralSettingsController::class, 'show']);
Route::post('/general_settings',[GeneralSettingsController::class, 'update']);




Route::get('update_dependants_list',[StaffDependentsController::class, 'edit']);
Route::post('update_dependants_list',[StaffDependentsController::class, 'update']);

Route::get('staff_emergency_contacts',[ StaffEmergencyContactsController::class, 'index']);
Route::get('update_emergency_contacts_list',[ StaffEmergencyContactsController::class, 'edit']);
Route::post('update_emergency_contacts_list',[ StaffEmergencyContactsController::class, 'update']);
Route::get('/staff/import_from_excel', [StaffController::class, 'importFromExcel']);



/************************** RESOURCE ROUTES ****************************/
Route::resource('departments',DepartmentsController::class);
Route::resource('countries',CountriesController::class);
Route::resource('districts',DistrictsController::class);
Route::resource('regions',RegionsController::class);
Route::resource('staff',StaffController::class);
Route::resource('staff_dependents',StaffDependentsController::class);
Route::resource('staff_emergency_contacts',StaffEmergencyContactsController::class);
Route::resource('staff_biographical_data_sheets',StaffBiographicalDataSheetsController::class);
Route::resource('staff_job_titles',StaffsJobTitlesController::class);
Route::resource('system_roles',SystemRolesController::class);
Route::resource('permissions',PermissionsController::class);
Route::resource('wards',WardsController::class);
Route::resource('system_users', SystemUsersController::class);
Route::resource('numbered_items', NumberedItemsController::class);
Route::resource('number_series', NumberSeriesController::class);



/***************************** USER ACCOUNTS ROUTES ********************************/
Route::get('/change_password',[UserAccountController::class, 'changePassword']);
Route::post('update_password',[UserAccountController::class, 'updatePassword']);


/********************************* USER ACTIVITIES *********************************/
Route::get('/user_activities',[UserActivitiesController::class, 'index']);


/******************** AJAX REQUESTS ******************/
Route::post('wards/ajax_get', [WardsController::class, 'ajaxGetWards'])->name('wards.ajax_get');
Route::post('districts/ajax_get', [DistrictsController::class, 'ajaxGetDistricts'])->name('districts.ajax_get');
Route::post('regions/ajax_get', [RegionsController::class, 'ajaxGetRegions'])->name('regions.ajax_get');
Route::post('system_role_permissions/ajax_update_multiple', [SystemRolePermissionsController::class, 'ajaxUpdateMultiple'])->name('system_role_permissions.ajax_update_multiple');
Route::post('user_account/ajax_change_password', [UserAccountController::class, 'ajaxChangePassword'])->name('user_account.ajax_change_password');
Route::post('leaves/ajax_check_date', [LeavesController::class, 'ajaxCheckDate'])->name('leaves.ajax_check_date');




/************************ ROUTE FOR FILE PREVIEWING AND DOWNLOADS *************/
Route::get('/leave_supporting_documents/{filename}',[LeavesController::class, 'viewDocument'])
    ->where('filename', '[A-Za-z0-9\-\_\.]+');

Route::get('/staff_dependents_certificates/{filename}',[StaffDependentsController::class, 'viewDocument'])
    ->where('filename', '[A-Za-z0-9\-\_\.]+');

Route::get('/staff_status_attachments/{filename}',[StaffController::class, 'viewDocument'])
    ->where('filename', '[A-Za-z0-9\-\_\.]+');

Route::get('/advance_payment_requests/attachments/{filename}',[AdvancePaymentRequestsController::class, 'viewDocument'])
    ->where('filename', '[A-Za-z0-9\-\_\.]+');

//Route::get('/leave_supporting_documents/{filename}','LeavesController@downloadDocument')
//   ->where('filename', '[A-Za-z0-9\-\_\.]+');




/************************ DEVELOPER ONLY ROUTES *************/
//Route::get('/generate_system_roles_permissions','SystemRolePermissionsController@createAllPermissionsForAllRoles');
Route::get('/clean_application_tables',[DeveloperProcessesController::class, 'cleanApplicationTables']);

Route::get('/relink_storage', function () {
    Artisan::call('storage:link');
});

Route::get('/clear_all', function () {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
});

Route::get('/nav', function () {
    //event( new \App\Events\SendTimeSheetToBC130());

    $recipient_type = 'staff';
    $recipient = \App\Models\Staff::find('14');
    Mail::to('susumashoma@gmail.com')->send(new PasswordReset($recipient_type,$recipient));
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
