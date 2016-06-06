@extends('pulsar::layouts.index', ['newTrans' => 'new'])

@section('head')
    @parent
    <!-- projects::history.index -->
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
                    'displayStart' : {{ $offset }},
                    'sorting': [[0, 'desc']],
                    'columnDefs': [
                    @if($resource == 'projects-history')
                        { 'visible': false, 'searchable': false, 'targets': [2,9]}, // hidden column 1 and prevents search on column 1
                        { 'dataSort': 2, 'targets': [3] }, // sort column 2 according hidden column 1 data
                        { 'dataSort': 9, 'targets': [10] }, // sort column 2 according hidden column 1 data
                        { 'sortable': false, 'targets': [11, 12]},
                        { 'class': 'checkbox-column', 'targets': [11]},
                        { 'class': 'customer-width', 'targets': [1,4]},
                        { 'class': 'align-center', 'targets': [11, 12]}
                    @endif
                    @if($resource == 'projects-user-history')
                        { 'visible': false, 'searchable': false, 'targets': [1,2,9]}, // hidden column 1 and prevents search on column 1
                        { 'dataSort': 2, 'targets': [3] }, // sort column 2 according hidden column 1 data
                        { 'dataSort': 9, 'targets': [10] }, // sort column 2 according hidden column 1 data
                        { 'sortable': false, 'targets': [11]},
                        { 'class': 'customer-width', 'targets': [4]},
                        { 'class': 'align-center', 'targets': [11]}
                    @endif
                    ],
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('jsonData' . ucfirst($routeSuffix)) }}"
                }).fnSetFilteringDelay();
            }
        });
    </script>
    <!-- /.projects::history.index -->
@stop

@section('tHead')
    <!-- projects::history.index -->
    <tr>
        <th data-hide="phone,tablet">ID.</th>
        <th data-hide="phone">{{ trans_choice('pulsar::pulsar.user', 1) }}</th>
        <th data-hide="phone">{{ trans('projects::pulsar.end_date') }}</th>
        <th>{{ trans('projects::pulsar.end_date') }}</th>
        <th>{{ trans_choice('pulsar::pulsar.customer', 1) }}</th>
        <th data-hide="phone, tablet">{{ trans_choice('projects::pulsar.project', 1) }}</th>
        <th data-hide="phone">{{ trans('pulsar::pulsar.title') }}</th>
        <th data-hide="phone, tablet">{{ trans_choice('pulsar::pulsar.price', 1) }}</th>
        <th data-hide="phone">{{ trans_choice('pulsar::pulsar.hour', 1) }}</th>
        <th>{{ trans('projects::pulsar.request_date') }}</th>
        <th data-hide="phone">{{ trans('projects::pulsar.request_date') }}</th>
        @if($resource == 'projects-history')
            <th class="checkbox-column"><input type="checkbox" class="uniform"></th>
        @endif
        <th>{{ trans_choice('pulsar::pulsar.action', 2) }}</th>
    </tr>
    <!-- /.projects::history.index -->
@stop