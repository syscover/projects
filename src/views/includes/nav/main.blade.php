<li{!! Miscellaneous::setCurrentOpenPage(['projects-project', 'projects-todo', 'projects-billing', 'projects-history']) !!}>
    <a href="javascript:void(0)"><i class="fa fa-code-fork"></i>{{ trans('projects::pulsar.package_name') }}</a>
    <ul class="sub-menu">
        @if(session('userAcl')->allows('projects-project', 'access'))
            <li{!! Miscellaneous::setCurrentPage('projects-project') !!}><a href="{{ route('projectsProject') }}"><i class="fa fa-rocket"></i>{{ trans_choice('projects::pulsar.project', 2) }}</a></li>
        @endif
        @if(session('userAcl')->allows('projects-todo', 'access'))
            <li{!! Miscellaneous::setCurrentPage('projects-todo') !!}><a href="{{ route('crmGroup') }}"><i class="fa fa-hourglass-start"></i>{{ trans_choice('projects::pulsar.todo', 2) }}</a></li>
        @endif
    </ul>
</li>