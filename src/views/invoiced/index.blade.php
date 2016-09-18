@extends('pulsar::layouts.index')

@section('head')
    @parent
    <!-- projects::invoiced.index -->
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
                    "sorting": [[0, "desc"]],
                    "columnDefs": [
                        { "visible": false, "searchable": false, "targets": [1]}, // hidden column 1 and prevents search on column 1
                        { "dataSort": 1, "targets": [2] }, // sort column 2 according hidden column 1 data
                        { "sortable": false, "targets": [5]},

                        //{ "class": 'customer-width', "targets": [1,4]},
                        { "class": "align-center", "targets": [5]}
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
    <!-- /projects::invoiced.index -->
@stop

@section('tHead')
    <!-- projects::invoiced.index -->
    <tr>
        <th data-hide="phone,tablet">ID.</th>
        <th data-hide="phone">{{ trans_choice('pulsar::pulsar.date', 1) }}</th>
        <th data-hide="phone">{{ trans_choice('pulsar::pulsar.date', 1) }}</th>
        <th>{{ trans_choice('pulsar::pulsar.customer', 1) }}</th>
        <th>{{ trans_choice('pulsar::pulsar.price', 1) }}</th>
        <th>{{ trans_choice('pulsar::pulsar.action', 2) }}</th>
    </tr>
    <!-- /projects::invoiced.index -->
@stop