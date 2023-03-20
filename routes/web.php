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
use App\Http\Controllers\SystemUsersController;
use App\Mail\PasswordReset;
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
Route::get('super-administrator','DashboardsController@showSuperAdminDashboard')->middleware('super-admin');
Route::get('system-administrator','DashboardsController@showSystemAdministratorDashboard')->middleware('system-admin');
Route::get('finance-director','DashboardsController@showFDDashboard')->middleware('fd');
Route::get('managing-director','DashboardsController@showMDDashboard')->middleware('md');
Route::get('human-resource-manager','DashboardsController@showHRMDashboard')->middleware('hrm');
Route::get('accountant','DashboardsController@showAccountantDashboard')->middleware('accountant');
Route::get('supervisor','DashboardsController@showSupervisorDashboard')->middleware('supervisor');
Route::get('employee','DashboardsController@showEmployeeDashboard')->middleware('employee');




/************ LEAVE MANAGEMENT ROUTES *************************/
Route::get('/request_leave','LeavesController@create');
Route::post('/request_leave','LeavesController@store');
Route::get('/leaves/{status}','LeavesController@index');
Route::get('/admin_leaves/{status}','LeavesController@adminIndex');
Route::get('/leave/{id}','LeavesController@show');
Route::get('/leave_admin/{id}','LeavesController@showAdmin');
Route::get('/time_sheet_admin/leave_admin/{id}','LeavesController@showAdmin');
Route::post('/approve_leave','LeavesController@approveLeave');
Route::post('/confirm_leave_payment','LeavesController@confirmPayment');
Route::post('/modify_leave','LeavesController@modifyApproveLeave');
Route::post('/modify_leave','LeavesController@modifyApproveLeave');
Route::post('/change_supervisor','LeavesController@changeSupervisor');
Route::post('/reject_leave','LeavesController@rejectLeave');
Route::get('/leave_statement/{id}','LeavesController@showLeaveStatement');
Route::get('/my_leaves','LeavesController@myLeavesIndex');
Route::post('/my_leaves','LeavesController@myLeavesList');
Route::get('/overlapping_leaves/{id}','LeavesController@overlappingLeaves');


Route::get('/leave_entitlements/create','LeaveEntitlementsController@create');
Route::post('/leave_entitlements','LeaveEntitlementsController@store');
Route::get('/leave_entitlements','LeaveEntitlementsController@index');
Route::get('/leave_entitlements/{id}','LeaveEntitlementsController@show');
Route::get('/leave_entitlements/{id}/edit','LeaveEntitlementsController@edit');
Route::patch('/leave_entitlements/{id}','LeaveEntitlementsController@update');

Route::get('/perform_carry_over/{staff_id}','LeaveEntitlementsController@performCarryOver');


Route::get('/leave_reports','LeaveReportsController@index');
Route::post('/generate_leave_report','LeaveReportsController@generateReport');


Route::resource('leave_types','LeaveTypesController');
Route::resource('leave_plans','LeavePlansController');

Route::get('/leave_plan_remove_line/{line_id}','LeavePlansController@removeLine');
Route::get('/leave_plan_submit/{leave_plan_id}','LeavePlansController@submitLeavePlan');
Route::get('/leave_plan_admin/{id}','LeavePlansController@showAdmin');
Route::get('/leave/leave_plans/{id}','LeavePlansController@showById');
Route::get('/leave_admin/leave_plans/{id}','LeavePlansController@showAdmin');
Route::get('/admin_leave_plans/{status}','LeavePlansController@adminIndex');
Route::get('/leave_plan_summary/{mode}','LeavePlansController@leavePlansSummary');

Route::post('/approve_leave_plan','LeavePlansController@approveLeavePlan');
Route::post('/return_leave_plan','LeavePlansController@returnLeavePlan');
Route::post('/change_leave_plan_spv','LeavePlansController@changeSupervisor');
Route::post('/reject_leave_plan','LeavePlansController@rejectLeavePlan');



/************ TIME SHEETS MANAGEMENT ROUTES *************************/
Route::get('/new_time_sheet','TimeSheetsController@create');
Route::post('/new_time_sheet','TimeSheetsController@store');
Route::get('/create_timesheet_for_another_staff','TimeSheetsController@createForAnotherStaff');
Route::post('/create_timesheet_for_another_staff','TimeSheetsController@storeForAnotherStaff');

Route::get('/create_time_sheet_entries/{id}','TimeSheetsController@createTimeSheetLines');
Route::post('/create_time_sheet_entries','TimeSheetsController@storeTimesheetData');
Route::get('/create_time_sheet_entries_admin/{id}','TimeSheetsController@createTimeSheetLinesAdmin');
Route::post('/create_time_sheet_entries_admin','TimeSheetsController@storeTimesheetDataAdmin');

Route::get('/time_sheets/{status}','TimeSheetsController@index');
Route::get('/admin_time_sheets/{status}','TimeSheetsController@adminIndex');

Route::get('/time_sheet/{id}','TimeSheetsController@show');
Route::get('/time_sheet_admin/{id}','TimeSheetsController@showAdmin');
Route::get('/time_sheet_edit/{id}','TimeSheetsController@editTimeSheetData');
Route::get('/time_sheet_edit_admin/{id}','TimeSheetsController@adminEditTimeSheetData');
Route::post('/time_sheet_edit','TimeSheetsController@update');
Route::get('/my_time_sheets','TimeSheetsController@myTimeSheetsIndex');
Route::post('/my_time_sheets','TimeSheetsController@myTimeSheetsList');

Route::post('/approve_timesheet','TimeSheetsController@approveTimeSheet');
Route::post('/return_timesheet','TimeSheetsController@returnTimeSheet');
Route::post('/change_timesheet_spv','TimeSheetsController@changeSupervisor');
Route::post('/reject_timesheet','TimeSheetsController@rejectTimeSheet');


Route::resource('time_sheet_late_submissions','TimeSheetLateSubmissionsController');
Route::get('/unlock_time_sheet_submission/{id} ','TimeSheetLateSubmissionsController@unlockTimeSheetSubmission');


Route::get('/time_sheet_statement/{id}','TimeSheetsController@showTimeSheetStatement');
Route::get('/time_sheet_reports','TimeSheetReportsController@index');
Route::post('/generate_time_sheet_report','TimeSheetReportsController@generateReport');


Route::get('/holidays_list/{year}','HolidaysController@index2');
Route::get('/supervisors/delete/{supervisor_id}','SupervisorsController@delete');

Route::resource('supervisors','SupervisorsController');


/************ PROJECTS ROUTES *************************/
Route::resource('holidays','HolidaysController');
Route::get('/projects/ajaxGetList/', [ProjectsController::class, 'ajaxGetList'])->name('projects.ajaxGetList');
Route::post('/projects/ajaxDelete/', [ProjectsController::class, 'ajaxDelete'])->name('projects.ajaxDelete');
Route::get('/activities/getList/', [ActivitiesController::class, 'getList'])->name('activities.getList');
Route::post('/activities/ajaxDelete/', [ActivitiesController::class, 'ajaxDelete'])->name('activities.ajaxDelete');
Route::post('/activities/ajaxGetByProject/', [ActivitiesController::class, 'ajaxGetActivitiesByProject'])->name('activities.ajaxGetByProject');
Route::get('/gl_accounts/ajaxGetList/', [GlAccountsController::class, 'ajaxGetList'])->name('gl_accounts.ajaxGetList');
Route::post('/gl_accounts/ajaxDelete/', [GlAccountsController::class, 'ajaxDelete'])->name('gl_accounts.ajaxDelete');

Route::get('/activities/import_from_excel', [ActivitiesController::class, 'importFromExcel']);
Route::get('/gl_accounts/import_from_excel', [GlAccountsController::class, 'importFromExcel']);


Route::resource('projects','ProjectsController');
Route::resource('activities','ActivitiesController');
Route::resource('active_projects','ActiveProjectsController');
Route::resource('gl_accounts','GlAccountsController');




/************ TRAVEL MANAGEMENT ROUTES *************************/
Route::get('/new_travel_request','TravelRequestsController@create');
Route::post('/travel_request','TravelRequestsController@store');
Route::get('/travel_request/{id}','TravelRequestsController@show');
Route::patch('/travel_request_update/{id}','TravelRequestsController@update');
Route::get('/travel_requests/{status}','TravelRequestsController@index');
Route::get('/admin_travel_requests/{status}','TravelRequestsController@adminIndex');
Route::get('/travel_requests_admin/{id}','TravelRequestsController@showAdmin');
Route::get('/travelFilePreview/{is}','TravelRequestsController@filePreview');
Route::get('/travel_request/activities','TravelRequestsController@activities');

Route::post('/approve_travel_request','TravelRequestsController@approveTravelRequest');
Route::post('/return_travel_request','TravelRequestsController@returnTravelRequest');
Route::post('/change_travel_request_spv','TravelRequestsController@changeSupervisor');
Route::post('/reject_travel_request','TravelRequestsController@rejectTravelRequest');


Route::get('/my_travel_records','TravelRequestsController@myTravelRequestsIndex');
Route::post('/my_travel_records','TravelRequestsController@myTravelRequestsList');
Route::get('/staff_travel_records','TravelRequestsController@staffTravelRequestsIndex');
Route::post('/staff_travel_records','TravelRequestsController@staffTravelRequestsList');
Route::get('/travel_request_statement/{id}','TravelRequestsController@showTravellingStatement');


/************ REQUISITION MANAGEMENT ROUTES *************************/
Route::get('/new_requisition_request','RequisitionRequestsController@create');
Route::post('/requisition_request','RequisitionRequestsController@store');
Route::get('/requisition_request/{id}','RequisitionRequestsController@show');
Route::patch('/requisition_request_update/{id}','RequisitionRequestsController@update');
Route::get('/requisition_requests/{status}','RequisitionRequestsController@index');
Route::get('/admin_requisition_requests/{status}','RequisitionRequestsController@adminIndex');
Route::get('/requisition_requests_admin/{id}','RequisitionRequestsController@showAdmin');
Route::get('/requisitionFilePreview/{is}','RequisitionRequestsController@filePreview');
Route::get('/requisition_activities','RequisitionRequestsController@activities');

Route::post('/approve_requisition_request','RequisitionRequestsController@approveTravelRequest');
Route::post('/return_requisition_request','RequisitionRequestsController@returnTravelRequest');
Route::post('/change_requisition_request_spv','RequisitionRequestsController@changeSupervisor');
Route::post('/reject_requisition_request','RequisitionRequestsController@rejectTravelRequest');


Route::get('/my_requisition_records','RequisitionRequestsController@myTravelRequestsIndex');
Route::post('/my_requisition_records','RequisitionRequestsController@myTravelRequestsList');
Route::get('/staff_requisition_records','RequisitionRequestsController@staffTravelRequestsIndex');
Route::post('/staff_requisition_records','RequisitionRequestsController@staffTravelRequestsList');
Route::get('/requisition_request_statement/{id}','RequisitionRequestsController@showTravellingStatement');

/************ ADVANCE PAYMENT MANAGEMENT ROUTES *************************/
Route::get('/new_advance_payment_request','AdvancePaymentRequestsController@create');
Route::post('/advance_payment_request','AdvancePaymentRequestsController@store');
Route::get('/advance_payment_request/{id}','AdvancePaymentRequestsController@show');
Route::get('/advance_payment_request/{id}/{responseType}','AdvancePaymentRequestsController@show');
Route::get('/advance_payment_request_edit/{id}','AdvancePaymentRequestsController@edit');
Route::get('/advance_payment_request_edit/{id}/{responseType}','AdvancePaymentRequestsController@edit');
Route::patch('/advance_payment_request_update/{id}','AdvancePaymentRequestsController@update');
Route::get('/advance_payment_requests/{status}','AdvancePaymentRequestsController@index');
Route::get('/admin_advance_payment_requests/{status}','AdvancePaymentRequestsController@adminIndex');
Route::get('/advance_payment_requests_admin/{id}','AdvancePaymentRequestsController@showAdmin');
Route::get('/advance_payment_requests_admin/{id}/{responseType}','AdvancePaymentRequestsController@showAdmin');

Route::post('/approve_advance_payment_request','AdvancePaymentRequestsController@approveRequest');
Route::post('/return_advance_payment_request','AdvancePaymentRequestsController@returnRequest');
Route::post('/change_advance_payment_request_spv','AdvancePaymentRequestsController@changeSupervisor');
Route::post('/reject_advance_payment_request','AdvancePaymentRequestsController@rejectRequest');


Route::get('/my_advance_payment_records','AdvancePaymentRequestsController@myRequestsIndex');
Route::post('/my_advance_payment_records','AdvancePaymentRequestsController@myRequestsList');
Route::get('/staff_advance_payment_records','AdvancePaymentRequestsController@staffRequestsIndex');
Route::post('/staff_advance_payment_records','AdvancePaymentRequestsController@staffRequestsList');
Route::get('/advance_payment_request_statement/{id}','AdvancePaymentRequestsController@showStatement');

Route::post('/advance_payment_requests.ajaxDeleteMultiple','AdvancePaymentRequestsController@deleteMultiple')->name('advance_payment_requests.ajaxDeleteMultiple');
Route::post('/advance_payment_requests.ajaxApproveMultiple','AdvancePaymentRequestsController@approveMultipleRequests')->name('advance_payment_requests.ajaxApproveMultiple');
Route::post('/advance_payment_requests.ajaxApprove','AdvancePaymentRequestsController@approveRequest')->name('advance_payment_requests.ajaxApprove');
Route::post('/advance_payment_requests.ajaxReturnForCorrection','AdvancePaymentRequestsController@returnRequest')->name('advance_payment_requests.ajaxReturnForCorrection');
Route::post('/advance_payment_requests.ajaxChangeSupervisor','AdvancePaymentRequestsController@changeSupervisor')->name('advance_payment_requests.ajaxChangeSupervisor');
Route::post('/advance_payment_requests.ajaxReject','AdvancePaymentRequestsController@rejectRequest')->name('advance_payment_requests.ajaxReject');


/************ REQUISITION MANAGEMENT ROUTES *************************/
Route::get('/new_requisition_request','RequisitionRequestsController@create');
Route::post('/requisition_request','RequisitionRequestsController@store');
Route::get('/requisition_request/{id}','RequisitionRequestsController@show');
Route::patch('/requisition_request_update/{id}','RequisitionRequestsController@update');
Route::get('/requisition_requests/{status}','RequisitionRequestsController@index');
Route::get('/admin_requisition_requests/{status}','RequisitionRequestsController@adminIndex');
Route::get('/requisition_requests_admin/{id}','RequisitionRequestsController@showAdmin');
Route::get('/requisitionFilePreview/{is}','RequisitionRequestsController@filePreview');
Route::get('/requisition_activities','RequisitionRequestsController@activities');

Route::post('/approve_requisition_request','RequisitionRequestsController@approveTravelRequest');
Route::post('/return_requisition_request','RequisitionRequestsController@returnTravelRequest');
Route::post('/change_requisition_request_spv','RequisitionRequestsController@changeSupervisor');
Route::post('/reject_requisition_request','RequisitionRequestsController@rejectTravelRequest');


Route::get('/my_requisition_records','RequisitionRequestsController@myTravelRequestsIndex');
Route::post('/my_requisition_records','RequisitionRequestsController@myTravelRequestsList');
Route::get('/staff_requisition_records','RequisitionRequestsController@staffTravelRequestsIndex');
Route::post('/staff_requisition_records','RequisitionRequestsController@staffTravelRequestsList');
Route::get('/requisition_request_statement/{id}','RequisitionRequestsController@showTravellingStatement');

/************ RETIREMENT MANAGEMENT ROUTES *************************/
Route::get('/new_retirement_request/{id}','RetirementRequestsController@create');
Route::post('/retirement_request','RetirementRequestsController@store');
Route::get('/retirement_request/{id}','RetirementRequestsController@show');
Route::patch('/retirement_request_update/{id}','RetirementRequestsController@update');
Route::get('/retirement_requests/{status}','RetirementRequestsController@index');
Route::get('/admin_retirement_requests/{status}','RetirementRequestsController@adminIndex');
Route::get('/retirement_requests_admin/{id}','RetirementRequestsController@showAdmin');
Route::get('/retirementFilePreview/{is}','RetirementRequestsController@filePreview');
Route::get('/retirement_activities','RetirementRequestsController@activities');
Route::get('/admin_retirementadvance_payment_requests/{status}','RetirementRequestsController@adminIndexPayment');


Route::post('/approve_retirement_request','RetirementRequestsController@approveTravelRequest');
Route::post('/return_retirement_request','RetirementRequestsController@returnTravelRequest');
Route::post('/change_retirement_request_spv','RetirementRequestsController@changeSupervisor');
Route::post('/reject_retirement_request','RetirementRequestsController@rejectTravelRequest');


Route::get('/my_retirement_records','RetirementRequestsController@myTravelRequestsIndex');
Route::post('/my_retirement_records','RetirementRequestsController@myTravelRequestsList');
Route::get('/staff_retirement_records','RetirementRequestsController@staffTravelRequestsIndex');
Route::post('/staff_retirement_records','RetirementRequestsController@staffTravelRequestsList');
Route::get('/retirement_request_statement/{id}','RetirementRequestsController@showTravellingStatement');









/************ PERFORMANCE MANAGEMENT ROUTES *************************/
Route::get('/set_objectives','PerformanceObjectivesController@create');
Route::post('/submit_objectives','PerformanceObjectivesController@store');
Route::patch('/update_objectives/{id}','PerformanceObjectivesController@update');
Route::get('/performance_objective/{id}','PerformanceObjectivesController@show');
Route::get('/performance_objective_admin/{id}','PerformanceObjectivesController@showAdmin');
Route::get('/performance_objectives/{status}','PerformanceObjectivesController@index');
Route::get('/admin_performance_objectives/{status}','PerformanceObjectivesController@adminIndex');

Route::post('/approve_objectives','PerformanceObjectivesController@approvePerformanceObjectives');
Route::post('/return_objectives','PerformanceObjectivesController@returnPerformanceObjectives');
Route::post('/change_objectives_spv','PerformanceObjectivesController@changeSupervisor');
Route::post('/reject_objectives','PerformanceObjectivesController@rejectPerformanceObjectives');

Route::get('/staff_performances','StaffPerformancesController@index');
Route::get('/staff_performances_admin/{year}','StaffPerformancesController@indexAdmin');
Route::get('/staff_performances/{performance_id}','StaffPerformancesController@show');
Route::post('/first_quoter_staff_performance_assessment','StaffPerformancesController@firstQuoterAssessment');
Route::post('/second_quoter_staff_performance_assessment','StaffPerformancesController@secondQuoterAssessment');
Route::post('/third_quoter_staff_performance_assessment','StaffPerformancesController@thirdQuoterAssessment');
Route::post('/fourth_quoter_staff_performance_assessment','StaffPerformancesController@fourthQuoterAssessment');




/***************************** MIXED ROUTES'*****************************/
Route::get('/staff_supervisors','StaffController@supervisorsIndex');
Route::post('/staff_supervisor_update','StaffController@supervisorsUpdate');
Route::get('/create_staff_biographical_data_sheets/{staff_id}','StaffBiographicalDataSheetsController@createForStaff');
Route::get('/reset_staff_password/{id}','UserAccountController@resetPassword');
Route::get('/company_information','CompanyInformationController@show');
Route::post('/company_information','CompanyInformationController@update');
Route::get('/general_settings','GeneralSettingsController@show');
Route::post('/general_settings','GeneralSettingsController@update');




Route::get('update_dependants_list','StaffDependentsController@edit');
Route::post('update_dependants_list','StaffDependentsController@update');

Route::get('staff_emergency_contacts','StaffEmergencyContactsController@index');
Route::get('update_emergency_contacts_list','StaffEmergencyContactsController@edit');
Route::post('update_emergency_contacts_list','StaffEmergencyContactsController@update');
Route::get('/staff/import_from_excel', [StaffController::class, 'importFromExcel']);



/************************** RESOURCE ROUTES ****************************/
Route::resource('departments','DepartmentsController');
Route::resource('countries','CountriesController');
Route::resource('districts','DistrictsController');
Route::resource('regions','RegionsController');
Route::resource('staff','StaffController');
Route::resource('staff_dependents','StaffDependentsController');
Route::resource('staff_emergency_contacts','StaffEmergencyContactsController');
Route::resource('staff_biographical_data_sheets','StaffBiographicalDataSheetsController');
Route::resource('staff_job_titles','StaffsJobTitlesController');
Route::resource('system_roles','SystemRolesController');
Route::resource('permissions','PermissionsController');
Route::resource('wards','WardsController');
Route::resource('system_users', 'SystemUsersController');
Route::resource('numbered_items', "NumberedItemsController");
Route::resource('number_series', "NumberSeriesController");



/***************************** USER ACCOUNTS ROUTES ********************************/
Route::get('/change_password','UserAccountController@changePassword');
Route::post('update_password','UserAccountController@updatePassword');


/********************************* USER ACTIVITIES *********************************/
Route::get('/user_activities','UserActivitiesController@index');


/******************** AJAX REQUESTS ******************/
Route::post('wards/ajax_get', 'WardsController@ajaxGetWards')->name('wards.ajax_get');
Route::post('districts/ajax_get', 'DistrictsController@ajaxGetDistricts')->name('districts.ajax_get');
Route::post('regions/ajax_get', 'RegionsController@ajaxGetRegions')->name('regions.ajax_get');
Route::post('system_role_permissions/ajax_update_multiple', 'SystemRolePermissionsController@ajaxUpdateMultiple')->name('system_role_permissions.ajax_update_multiple');
Route::post('user_account/ajax_change_password', 'UserAccountController@ajaxChangePassword')->name('user_account.ajax_change_password');
Route::post('leaves/ajax_check_date', 'LeavesController@ajaxCheckDate')->name('leaves.ajax_check_date');




/************************ ROUTE FOR FILE PREVIEWING AND DOWNLOADS *************/
Route::get('/leave_supporting_documents/{filename}','LeavesController@viewDocument')
    ->where('filename', '[A-Za-z0-9\-\_\.]+');

Route::get('/staff_dependents_certificates/{filename}','StaffDependentsController@viewDocument')
    ->where('filename', '[A-Za-z0-9\-\_\.]+');

Route::get('/staff_status_attachments/{filename}','StaffController@viewDocument')
    ->where('filename', '[A-Za-z0-9\-\_\.]+');

Route::get('/advance_payment_requests/attachments/{filename}','AdvancePaymentRequestsController@viewDocument')
    ->where('filename', '[A-Za-z0-9\-\_\.]+');

//Route::get('/leave_supporting_documents/{filename}','LeavesController@downloadDocument')
//   ->where('filename', '[A-Za-z0-9\-\_\.]+');




/************************ DEVELOPER ONLY ROUTES *************/
//Route::get('/generate_system_roles_permissions','SystemRolePermissionsController@createAllPermissionsForAllRoles');
Route::get('/clean_application_tables','DeveloperProcessesController@cleanApplicationTables');

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
