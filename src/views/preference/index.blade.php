@extends('pulsar::layouts.form', ['action' => 'update', 'cancelButton' => false])

@section('head')
    @parent
    <!-- projects::preferences.index -->
    @include('pulsar::includes.js.success_message')
    <!-- ./projects::preferences.index -->
@stop

@section('rows')
    <!-- projects::preferences.index -->
    @include('pulsar::includes.html.form_select_group', [
        'label' => trans('projects::pulsar.project_management_user'),
        'name' => 'projectManagementUser',
        'value' => $projectManagementUser->value_018,
        'objects' => $users,
        'idSelect' => 'id',
        'nameSelect' => 'name',
        'fieldSize' => 5,
        'required' => true
    ])
    @include('pulsar::includes.html.form_select_group', [
        'label' => trans('projects::pulsar.billing_user'),
        'name' => 'billingUser',
        'value' => (int)$billingUser->value_018,
        'objects' => $users,
        'idSelect' => 'id',
        'nameSelect' => 'name',
        'fieldSize' => 5,
        'required' => true
    ])
    @include('pulsar::includes.html.form_select_group', [
        'label' => trans('pulsar::pulsar.notifications_account'),
        'name' => 'notificationsAccount',
        'value' => (int)$notificationsAccount->value_018,
        'objects' => $accounts,
        'idSelect' => 'id_013',
        'nameSelect' => 'name_013',
        'fieldSize' => 5,
        'required' => true
    ])
    <!-- ./projects::preferences.index -->
@stop