@extends('layouts.administrator.admin')


@section('content')

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon text-primary">
                    <i class="fas fa-plus"></i>
                </div>
                <div>
                    <div class="text-primary">Set Active Projects</div>
                    <div class="page-title-subheading">
                        Set active projects by ticking on the checkboxes for project you want to activate
                    </div>
                </div>
            </div>

            <!--actions' menu starts here -->
            @include('layouts.administrator.page-title-actions')
            <!--actions' menu ends here -->
    
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <form action="/active_projects" method="POST">
                @include('projects.active_projects.form')
            </form>
        </div>
    </div>

@endsection