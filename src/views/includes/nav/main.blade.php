<li{!! Miscellaneous::setCurrentOpenPage(['projects-project', 'projects-todo', 'projects-developer-todo', 'projects-billing', 'projects-history', 'projects-developer-history', 'projects-preference']) !!}>
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
        @if(session('userAcl')->allows('projects-history', 'access'))
            <li{!! Miscellaneous::setCurrentPage('projects-history') !!}><a href="{{ route('projectsHistory') }}"><i class="fa fa-history"></i>{{ trans('projects::pulsar.history') }}</a></li>
        @endif
        @if(session('userAcl')->allows('projects-developer-history', 'access'))
            <li{!! Miscellaneous::setCurrentPage('projects-developer-history') !!}><a href="{{ route('projectsDeveloperHistory') }}"><i class="fa fa-history"></i>{{ trans('projects::pulsar.developer_history') }}</a></li>
        @endif
        @if(session('userAcl')->allows('projects-preference', 'access'))
            <li{!! Miscellaneous::setCurrentPage('projects-preference') !!}><a href="{{ route('projectsPreference') }}"><i class="fa fa-cog"></i>{{ trans_choice('pulsar::pulsar.preference', 2) }}</a></li>
        @endif
    </ul>
</li>