<?php

namespace App\Http\Controllers;

use App\ActiveProject;
use App\Activity;
use App\AdvancePaymentRequest;
use App\RequestApproval;
use App\RequestSupervisorChange;
use App\RequestRejection;
use App\RequestReturn;
use App\GlAccount;
use App\JsonTimeSheetLine;
use App\Leave;
use App\LeaveApproval;
use App\LeaveChangedSupervisor;
use App\LeaveEntitlement;
use App\LeaveEntitlementCarry;
use App\LeaveEntitlementExtension;
use App\LeaveEntitlementLine;
use App\LeaveModification;
use App\LeavePayment;
use App\LeavePlan;
use App\LeavePlanApproval;
use App\LeavePlanChangedSupervisor;
use App\LeavePlanLine;
use App\LeavePlanReject;
use App\LeavePlanReturn;
use App\LeaveReject;
use App\PerformanceObjective;
use App\PerformanceObjectiveApproval;
use App\PerformanceObjectiveChangedSupervisor;
use App\PerformanceObjectiveLine;
use App\PerformanceObjectiveMark;
use App\PerformanceObjectiveReject;
use App\PerformanceObjectiveReturn;
use App\Project;
use App\StaffBiographicalDataSheet;
use App\StaffDependent;
use App\StaffEmergencyContact;
use App\StaffPerformance;
use App\TimeSheet;
use App\TimeSheetApproval;
use App\TimeSheetChangedSupervisor;
use App\TimeSheetClosing;
use App\TimeSheetLateSubmission;
use App\TimeSheetLine;
use App\TimeSheetReject;
use App\TimeSheetReturn;
use App\TravelRequest;
use App\TravelRequestApproval;
use App\TravelRequestChangedSupervisor;
use App\TravelRequestLine;
use App\TravelRequestReject;
use App\TravelRequestReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gate;

class DeveloperProcessesController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cleanApplicationTables()
    {
        if (Gate::denies('access',['clean_application_tables','edit'])){
            abort(403, 'Access Denied');
        }

        ini_set('max_execution_time', '6000');


        //clean all application tables
        DB::statement("SET foreign_key_checks=0");
/**/
        //leave & leave plans tables
        LeaveEntitlementCarry::truncate();
        LeaveEntitlementExtension::truncate();
        LeaveEntitlementLine::truncate();
        LeaveEntitlement::truncate();

        LeaveApproval::truncate();
        LeaveChangedSupervisor::truncate();
        LeaveModification::truncate();
        LeavePayment::truncate();
        LeaveReject::truncate();
        Leave::truncate();

        LeavePlanApproval::truncate();
        LeavePlanChangedSupervisor::truncate();
        LeavePlanLine::truncate();
        LeavePlanReject::truncate();
        LeavePlanReturn::truncate();
        LeavePlan::truncate();

        //time sheets
        JsonTimeSheetLine::truncate();
        TimeSheetApproval::truncate();
        TimeSheetChangedSupervisor::truncate();
        TimeSheetLine::truncate();
        TimeSheetReject::truncate();
        TimeSheetReturn::truncate();
        TimeSheet::truncate();
        TimeSheetLateSubmission::truncate();
        TimeSheetClosing::truncate();

        //performance objectives
        PerformanceObjectiveApproval::truncate();
        //PerformanceObjectiveChangedSupervisor::truncate();
        PerformanceObjectiveLine::truncate();
        PerformanceObjectiveReject::truncate();
        PerformanceObjectiveReturn::truncate();
        PerformanceObjective::truncate();


        //travel requests
        TravelRequestApproval::truncate();
        //TravelRequestChangedSupervisor::truncate();
        TravelRequestReject::truncate();
        TravelRequestReturn::truncate();
        TravelRequest::truncate();


        //travel requests
        RequestApproval::truncate();
        RequestSupervisorChange::truncate();
        RequestRejection::truncate();
        RequestReturn::truncate();
        AdvancePaymentRequest::truncate();


        //staff related data
        StaffPerformance::truncate();
        StaffBiographicalDataSheet::truncate();
        StaffDependent::truncate();
        StaffEmergencyContact::truncate();

        GlAccount::truncate();
        Activity::truncate();
        ActiveProject::truncate();
        Project::truncate();

/**/

        DB::statement("SET foreign_key_checks=1");

        dd("finished");

        return redirect()->back();
    }


}
