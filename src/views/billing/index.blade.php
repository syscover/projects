@extends('pulsar::layouts.index', ['newTrans' => 'new', 'newButton' => false])

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
        $(document).on('ready', function() {
            if ($.fn.dataTable)
            {
                $('.datatable-pulsar').dataTable({
                    'iDisplayStart' : {{ $offset }},
                    'aoColumnDefs': [
                        { 'visible': false, "bSearchable": false, 'aTargets': [5,7]}, // hidden column 1 and prevents search on column 1
                        { 'iDataSort': 5, 'aTargets': [6] }, // sort column 2 according hidden column 1 data
                        { 'iDataSort': 7, 'aTargets': [8] }, // sort column 2 according hidden column 1 data
                        { 'bSortable': false, 'aTargets': [9,10]},
                        { 'sClass': 'customer-width', 'aTargets': [1]},
//                        { 'sClass': 'checkbox-column', 'aTargets': [9]},
                        { 'sClass': 'align-center', 'aTargets': [10]}
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
        <th>{{ trans_choice('pulsar::pulsar.customer', 1) }}</th>
        <th data-hide="phone">{{ trans('pulsar::pulsar.title') }}</th>
        <th data-hide="phone">{{ trans_choice('pulsar::pulsar.price', 1) }}</th>
        <th data-hide="phone">{{ trans_choice('pulsar::pulsar.hour', 1) }}</th>
        <th>{{ trans('projects::pulsar.request_date') }}</th>
        <th data-hide="phone">{{ trans('projects::pulsar.request_date') }}</th>
        <th>{{ trans('projects::pulsar.end_date') }}</th>
        <th data-hide="phone">{{ trans('projects::pulsar.end_date') }}</th>
        <th class="checkbox-column"><input type="checkbox" class="uniform"></th>
        <th>{{ trans_choice('pulsar::pulsar.action', 2) }}</th>
    </tr>
    <!-- ./projects::todo_.index -->
@stop