@extends('pulsar::layouts.index', ['newTrans' => 'new'])

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
                    'iDisplayStart' : {{ $offset }},
                    'aaSorting': [[ 0, "desc" ]],
                    'aoColumnDefs': [
                        { 'visible': false, "bSearchable": false, 'aTargets': [1]}, // hidden column 1 and prevents search on column 1
                        { 'iDataSort': 1, 'aTargets': [2] }, // sort column 2 according hidden column 1 data
                        { 'bSortable': false, 'aTargets': [5]},

                        //{ 'sClass': 'customer-width', 'aTargets': [1,4]},
                        { 'sClass': 'align-center', 'aTargets': [5]}
                    ],
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "{{ route('jsonData' . ucfirst($routeSuffix)) }}"
                }).fnSetFilteringDelay();
            }
        });
    </script>
    <!-- /.projects::invoiced.index -->
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
    <!-- /.projects::invoiced.index -->
@stop