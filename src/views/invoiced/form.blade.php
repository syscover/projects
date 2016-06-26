@extends('pulsar::layouts.form')

@section('head')
    @parent
    <!-- projects::invoiced.form -->
    <link rel="stylesheet" href="{{ asset('packages/syscover/pulsar/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">

    <script src="{{ asset('packages/syscover/pulsar/vendor/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('packages/syscover/pulsar/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- /.projects::invoiced.form -->
@stop

@section('rows')
    <!-- projects::invoiced.form -->
    @include('pulsar::includes.html.form_text_group', [
        'label' => 'ID',
        'name' => 'id',
        'value' => $object->id_094,
        'readOnly' => true,
        'fieldSize' => 2
    ])
    @include('pulsar::includes.html.form_datetimepicker_group', [
        'fieldSize' => 4,
        'label' => trans('projects::pulsar.request_date'),
        'name' => 'requestDate',
        'readOnly' => true,
        'data' => [
            'format' => Miscellaneous::convertFormatDate(config('pulsar.datePattern')),
            'locale' => config('app.locale'),
            'default-date' => date('Y-m-d', $object->date_094)
        ]
    ])
    @include('pulsar::includes.html.form_text_group', [
        'fieldSize' => 10,
        'label' => trans_choice('pulsar::pulsar.customer', 1),
        'name' => 'customer',
        'value' => $object->customer_name_094,
        'readOnly' => true
    ])
    @include('pulsar::includes.html.form_select_group', [
        'fieldSize' => 5,
        'label' => trans_choice('pulsar::pulsar.type', 1),
        'name' => 'type',
        'value' => old('type', $object->type_id_094),
        'objects' => $types,
        'idSelect' => 'id',
        'nameSelect' => 'name',
        'disabled' => true
    ])
    @if(! empty($object->history_id_094))
        @include('pulsar::includes.html.form_text_group', [
            'label' => trans('pulsar::pulsar.title'),
            'name' => 'title',
            'value' => $object->title_093,
            'readOnly' => true
        ])
    @endif
    @if(! empty($object->project_id_094))
        @include('pulsar::includes.html.form_select_group', [
            'fieldSize' => 5,
            'label' => trans_choice('projects::pulsar.project', 1),
            'id' => 'projectId',
            'name' => 'projectId',
            'value' => $object->project_id_094,
            'objects' => $projects,
            'class' => 'select2',
            'idSelect' => 'id',
            'nameSelect' => 'name',
            'disabled' => true,
            'data' => [
                'language' => config('app.locale'),
                'width' => '100%',
                'error-placement' => 'select2-projectId-outer-container'
            ]
        ])
    @endif

    @include('pulsar::includes.html.form_text_group', [
        'fieldSize' => 4,
        'type' => 'number',
        'label' => trans_choice('pulsar::pulsar.price', 1),
        'name' => 'price',
        'value' => $object->price_094,
        'readOnly' => true
    ])
    <!-- /.projects::invoiced.form -->
@stop