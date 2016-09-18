@extends('pulsar::layouts.index')

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
                    "displayStart": {{ $offset }},
                    "columnDefs": [
                        { "visible": false, "searchable": false, "targets": [7,9]}, // hidden column 1 and prevents search on column 1
                        { "dataSort": 7, "targets": [8] }, // sort column 2 according hidden column 1 data
                        { "dataSort": 9, "targets": [10] }, // sort column 2 according hidden column 1 data
                        { "sortable": false, "targets": [11]},
                        { "class": 'customer-width', "targets": [1, 2]},
                        { "class": "align-center", "targets": [11]}
                    ],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('jsonData' . ucfirst($routeSuffix)) }}",
                        "type": "POST",
                        "headers": {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    }
                }).fnSetFilteringDelay();
            }
        });
    </script>
    <!-- /projects::todo_.index -->
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
    <!-- /projects::todo_.index -->
@stop