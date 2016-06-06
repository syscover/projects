@extends('pulsar::layouts.index', ['newTrans' => 'new'])

@section('head')
    @parent
    <!-- projects::project.index -->
    <script>
        $(document).ready(function() {
            if ($.fn.dataTable)
            {
                $('.datatable-pulsar').dataTable({
                    'displayStart' : {{ $offset }},
                    'columnDefs': [
                        { 'visible': false, 'searchable': false, 'targets': [4]}, // hidden column 1 and prevents search on column 1
                        { 'dataSort': 4, 'targets': [5] }, // sort column 2 according hidden column 1 data
                        { 'sortable': false, 'targets': [7,8]},
                        { 'class': 'checkbox-column', 'targets': [7]},
                        { 'class': 'align-center', 'targets': [6,8]}
                    ],
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('jsonData' . ucfirst($routeSuffix)) }}"
                }).fnSetFilteringDelay();
            }
        });
    </script>
    <!-- /.projects::project.index -->
@stop

@section('tHead')
    <!-- projects::project.index -->
    <tr>
        <th data-hide="phone,tablet">ID.</th>
        <th data-class="expand">{{ trans_choice('pulsar::pulsar.customer', 1) }}</th>
        <th data-hide="phone">{{ trans('pulsar::pulsar.name') }}</th>
        <th data-hide="phone">{{ trans('projects::pulsar.total_hours') }}</th>
        <th>{{ trans('projects::pulsar.estimated_end_date') }}</th>
        <th data-hide="phone">{{ trans('projects::pulsar.estimated_end_date') }}</th>
        <th>{{ trans('projects::pulsar.invoiced') }}</th>
        <th class="checkbox-column"><input type="checkbox" class="uniform"></th>
        <th>{{ trans_choice('pulsar::pulsar.action', 2) }}</th>
    </tr>
    <!-- /.projects::project.index -->
@stop