<li{!! Miscellaneous::setCurrentOpenPage(['projects-project', 'projects-todo', 'projects-developer-todo', 'projects-billing', 'projects-historical', 'projects-developer-historical']) !!}>
    <a href="javascript:void(0)"><i class="fa fa-code-fork"></i>{{ trans('projects::pulsar.package_name') }}</a>
    <ul class="sub-menu">
        @if(session('userAcl')->allows('projects-project', 'access'))
            <li{!! Miscellaneous::setCurrentPage('projects-project') !!}><a href="{{ route('projectsProject') }}"><i class="fa fa-rocket"></i>{{ trans_choice('projects::pulsar.project', 2) }}</a></li>
        @endif
        @if(session('userAcl')->allows('projects-todo', 'access'))
            <li{!! Miscellaneous::setCurrentPage('projects-todo') !!}><a href="{{ route('projectsTodo') }}"><i class="fa fa-hourglass-start"></i>{{ trans_choice('projects::pulsar.todo', 2) }}</a></li>
        @endif
        @if(session('userAcl')->allows('projects-developer-todo', 'access'))
            <li{!! Miscellaneous::setCurrentPage('projects-developer-todo') !!}><a href="{{ route('projectsDeveloperTodo') }}"><i class="fa fa-hourglass-start"></i>{{ trans_choice('projects::pulsar.developer_todo', 2) }}</a></li>
        @endif
        @if(session('userAcl')->allows('projects-billing', 'access'))
            <li{!! Miscellaneous::setCurrentPage('projects-billing') !!}><a href="{{ route('projectsBilling') }}"><i class="fa fa-credit-card"></i>{{ trans_choice('projects::pulsar.billing', 2) }}</a></li>
        @endif
        @if(session('userAcl')->allows('projects-historical', 'access'))
            <li{!! Miscellaneous::setCurrentPage('projects-historical') !!}><a href="{{ route('projectsHistorical') }}"><i class="fa fa-history"></i>{{ trans('projects::pulsar.historical') }}</a></li>
        @endif
        @if(session('userAcl')->allows('projects-developer-historical', 'access'))
            <li{!! Miscellaneous::setCurrentPage('projects-developer-historical') !!}><a href="{{ route('projectsDeveloperHistorical') }}"><i class="fa fa-history"></i>{{ trans('projects::pulsar.developer_historical') }}</a></li>
        @endif
    </ul>
</li>