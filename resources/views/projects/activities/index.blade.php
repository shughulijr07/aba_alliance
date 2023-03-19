@extends('layouts.administrator.admin')


@section('content')

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon text-primary">
                    <i class="fas fa-list-ul"></i>
                </div>
                <div>
                    <div class="text-primary">List Project Activities</div>
                    <div class="page-title-subheading"></div>
                </div>
            </div>

            <!--actions' menu starts here -->
            <div class="page-title-actions">
                <button type="button" data-toggle="tooltip" title="Print" data-placement="bottom" class="btn-shadow mr-3 btn btn-info invisible">
                    <i class="lnr-printer"></i>
                </button>
                <div class="d-inline-block dropdown">
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-primary">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                        </span>
                        Actions
                    </button>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/'.$controller_name.'/create')}}">
                                    <i class="nav-link-icon fas fa-plus"></i>
                                    <span>New {{ucwords( str_ireplace('_', ' ', $model_name) )}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/activities/import_from_excel')}}">
                                    <i class="nav-link-icon fas fa-plus"></i>
                                    <span>Import From Excel</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--actions' menu ends here -->
        </div>
    </div>


    <div>
        <!-- return errors if there are any -->
        @if( Session::has('message'))
            <div class="row ml-1 mr-1 mt-3">
                <div class="col-md-12 pl-3 alert alert-success">{!! Session::get('message') !!}</div>
            </div>
        @endif
        <!-- end of errors -->


        <!-- Data Table -->
        <div class="main-card mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-bold">
                    <i class="header-icon lnr-list mr-3 text-primary opacity-6"> </i>
                    <span class="text-primary">Activities List</span>
                </div>
                <div class="btn-actions-pane-right actions-icon-btn">
                    <button type="button" class="btn mr-2 mb-2 mt-2 btn-primary" data-toggle="modal" data-target="#filtersModal">
                        Show Filters
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table style="width: 100%;" id="activitiesTable" class="table table-hover table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Activity</th>
                        <th>Activity Code</th>
                        <th>Project</th>
                        <th>Project Code</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{ csrf_field() }}

    <div id="report-title-banner" style="display: none;">
        @include('reports.title-banner')
    </div>






@endsection
