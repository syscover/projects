<li{!! is_current_resource(['projects-project', 'projects-todo', 'projects-user-todo', 'projects-billing', 'projects-history', 'projects-user-history', 'projects-invoiced', 'projects-preference']) !!}>
    <a href="javascript:void(0)"><i class="fa fa-code-fork"></i>{{ trans('projects::pulsar.package_name') }}</a>
    <ul class="sub-menu">
        @if(is_allowed('projects-project', 'access'))
            <li{!! is_current_resource('projects-project') !!}><a href="{{ route('projectsProject') }}"><i class="fa fa-rocket"></i>{{ trans_choice('projects::pulsar.project', 2) }}</a></li>
        @endif
        @if(is_allowed('projects-todo', 'access'))
            <li{!! is_current_resource('projects-todo') !!}><a href="{{ route('projectsTodo') }}"><i class="fa fa-hourglass-start"></i>{{ trans_choice('projects::pulsar.todo', 2) }}</a></li>
        @endif
        @if(is_allowed('projects-user-todo', 'access'))
            <li{!! is_current_resource('projects-user-todo') !!}><a href="{{ route('projectsUserTodo') }}"><i class="fa fa-hourglass-start"></i>{{ trans_choice('projects::pulsar.user_todo', 2) }}</a></li>
        @endif
        @if(is_allowed('projects-billing', 'access'))
            <li{!! is_current_resource('projects-billing') !!}><a href="{{ route('projectsBilling') }}"><i class="fa fa-credit-card"></i>{{ trans_choice('projects::pulsar.billing', 2) }}</a></li>
        @endif
        @if(is_allowed('projects-history', 'access'))
            <li{!! is_current_resource('projects-history') !!}><a href="{{ route('projectsHistory') }}"><i class="fa fa-history"></i>{{ trans('projects::pulsar.history') }}</a></li>
        @endif
        @if(is_allowed('projects-user-history', 'access'))
            <li{!! is_current_resource('projects-user-history') !!}><a href="{{ route('projectsUserHistory') }}"><i class="fa fa-history"></i>{{ trans('projects::pulsar.user_history') }}</a></li>
        @endif
        @if(is_allowed('projects-invoiced', 'access'))
            <li{!! is_current_resource('projects-invoiced') !!}><a href="{{ route('projectsInvoiced') }}"><i class="fa fa-money"></i>{{ trans('projects::pulsar.invoiced') }}</a></li>
        @endif
        @if(is_allowed('projects-preference', 'access'))
            <li{!! is_current_resource('projects-preference') !!}><a href="{{ route('projectsPreference') }}"><i class="fa fa-cog"></i>{{ trans_choice('pulsar::pulsar.preference', 2) }}</a></li>
        @endif
    </ul>
</li>