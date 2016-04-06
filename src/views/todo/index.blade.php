@extends('pulsar::layouts.index', ['newTrans' => 'new'])

@section('head')
    @parent
    <!-- projects::todo_.index -->
    <style>
        .customer-width {
            max-width: 100px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <script>
        $(document).ready(function() {
            if ($.fn.dataTable)
            {
                $('.datatable-pulsar').dataTable({
                    'iDisplayStart' : {{ $offset }},
                    'aoColumnDefs': [
                        { 'visible': false, "bSearchable": false, 'aTargets': [7,9]}, // hidden column 1 and prevents search on column 1
                        { 'iDataSort': 7, 'aTargets': [8] }, // sort column 2 according hidden column 1 data
                        { 'iDataSort': 9, 'aTargets': [10] }, // sort column 2 according hidden column 1 data
                        { 'bSortable': false, 'aTargets': [11]},
                        { 'sClass': 'customer-width', 'aTargets': [1, 2]},
                        { 'sClass': 'align-center', 'aTargets': [11]}
                    ],
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "{{ route('jsonData' . ucfirst($routeSuffix)) }}"
                }).fnSetFilteringDelay();
            }
        });
    </script>
    <!-- ./projects::todo_.index -->
@stop

@section('tHead')
    <!-- projects::todo_.index -->
    <tr>
        <th data-hide="phone,tablet">ID.</th>
        <th>{{ trans_choice('pulsar::pulsar.user', 1) }}</th>
        <th>{{ trans_choice('pulsar::pulsar.customer', 1) }}</th>
        <th data-hide="phone">{{ trans_choice('projects::pulsar.project', 1) }}</th>
        <th data-hide="phone">{{ trans('pulsar::pulsar.title') }}</th>
        <th data-hide="phone">{{ trans_choice('pulsar::pulsar.price', 1) }}</th>
        <th data-hide="phone">{{ trans_choice('pulsar::pulsar.hour', 1) }}</th>
        <th>{{ trans('projects::pulsar.request_date') }}</th>
        <th data-hide="phone">{{ trans('projects::pulsar.request_date') }}</th>
        <th>{{ trans('projects::pulsar.end_date') }}</th>
        <th data-hide="phone">{{ trans('projects::pulsar.end_date') }}</th>
        <th>{{ trans_choice('pulsar::pulsar.action', 2) }}</th>
    </tr>
    <!-- ./projects::todo_.index -->
@stop