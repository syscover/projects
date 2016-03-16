@extends('pulsar::layouts.form')

@section('head')
    @parent
    <link rel="stylesheet" href="{{ asset('packages/syscover/pulsar/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">

    <script src="{{ asset('packages/syscover/pulsar/vendor/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('packages/syscover/pulsar/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

    @include('pulsar::includes.html.froala_references')

    <script>
        $(document).on('ready', function() {
            $('.wysiwyg').froalaEditor({
                language: '{{ config('app.locale') }}',
                placeholderText: '{{ trans('pulsar::pulsar.type_something') }}',
                toolbarInline: false,
                toolbarSticky: true,
                tabSpaces: true,
                shortcutsEnabled: ['show', 'bold', 'italic', 'underline', 'strikeThrough', 'indent', 'outdent', 'undo', 'redo', 'insertImage', 'createLink'],
                toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],
                heightMin: 250,
                enter: $.FroalaEditor.ENTER_BR,
                key: '{{ config('pulsar.froalaEditorKey') }}',
                imageUploadURL: '{{ route('froalaUploadImage') }}',
                imageUploadParams: {
                    package: 'cms',
                    _token: '{{ csrf_token() }}'
                },
                imageManagerLoadURL: '{{ route('froalaLoadImages', ['package' => 'cms']) }}',
                imageManagerDeleteURL: '{{ route('froalaDeleteImage') }}',
                imageManagerDeleteParams: {
                    package: 'cms',
                    _token: '{{ csrf_token() }}'
                },
                fileUploadURL: '{{ route('froalaUploadFile') }}',
                fileUploadParams: {
                    package: 'cms',
                    _token: '{{ csrf_token() }}'
                }
            }).on('froalaEditor.image.removed', function (e, editor, $img) {

                $.ajax({
                    method: "POST",
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    url: '{{ route('froalaDeleteImage') }}',
                    data: {
                        package: 'cms',
                        src: $img.attr('src')
                    }
                })
                .done (function (data) {
                    console.log ('image was deleted')
                })
                .fail (function () {
                    console.log ('image delete problem')
                })
            })

            // start select2 ajax function
            // need declare firs, cuntion templates before, select2 function
            $.formatCustomer = function(customer) {
                if(customer.name == undefined)
                    var markup = '{{ trans('pulsar::pulsar.searching') }}...';
                else
                    var markup = customer.companyCode + ' ' + customer.name;

                return markup;
            }

            $.formatCustomerSelection = function (customer) {
                if(customer.name == undefined)
                {
                    @if(isset($customers))
                        return '{{ $customers->first()->companyCode . ' ' . $customers->first()->name  }}'
                    @else
                        return customer
                    @endif
                }
                else
                {
                    $('[name=customerName]').val(customer.name)
                    return customer.companyCode + ' ' + customer.name
                }
            }

            var itemsPerPage = 25; // intems per page
            $('#customerId').select2({
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: 'POST',
                    url: '{{ route('apiFacturadirectaCustomers') }}',
                    data: function (params) {
                        return {
                            term:  params.term, // search term
                            start: params.page * itemsPerPage,
                            limit: itemsPerPage
                        };
                    },
                    dataType: 'json',
                    delay: 300,
                    processResults: function (data, params) {

                        params.page = params.page || 0;

                        return {
                            results: data.client,
                            pagination: {
                                more: (params.page * itemsPerPage) < data.attributes.total
                            }
                        }
                    },
                    cache: true
                },
                minimumInputLength: 1,
                templateResult: $.formatCustomer,
                templateSelection: $.formatCustomerSelection
            })
            // end select2 ajax function
        })
    </script>
@stop

@section('rows')
    <!-- projects::projects.form -->
    @include('pulsar::includes.html.form_text_group', [
        'fieldSize' => 2,
        'label' => 'ID',
        'name' => 'id',
        'value' => old('id', isset($object)? $object->id_090 : null),
        'readOnly' => true,
    ])
    @include('pulsar::includes.html.form_select_group', [
        'fieldSize' => 5,
        'label' => trans_choice('pulsar::pulsar.customer', 1),
        'id' => 'customerId',
        'name' => 'customerId',
        'value' => old('customerId', isset($object->customer_id_090)? $object->customer_id_090 : null),
        'objects' => isset($customers)? $customers : null,
        'idSelect' => 'id',
        'nameSelect' => 'name',
        'required' => true,
        'data' => [
            'language' => config('app.locale'),
            'width' => '100%',
            'error-placement' => 'select2-customerId-outer-container'
        ]
    ])
    @include('pulsar::includes.html.form_hidden', [
        'name' => 'customerName',
        'value' => old('customerName', isset($object->customer_name_090)? $object->customer_name_090 : null)
    ])
    @include('pulsar::includes.html.form_text_group', [
        'label' => trans('pulsar::pulsar.name'),
        'name' => 'name',
        'value' => old('name', isset($object)? $object->name_090 : null),
        'maxLength' => '255',
        'rangeLength' => '2,255',
        'required' => true]
    )
    @include('pulsar::includes.html.form_wysiwyg_group', [
        'label' => trans_choice('pulsar::pulsar.description', 1),
        'name' => 'description',
        'value' => old('name', isset($object)? $object->description_090 : null),
        'labelSize' => 2,
        'fieldSize' => 10
    ])
    @include('pulsar::includes.html.form_section_header', [
        'label' => trans_choice('pulsar::pulsar.hour', 2),
        'icon' => 'fa fa-clock-o',
        'containerId' => 'headerContent'
    ])
    <div class="row">
        <div class="col-md-6">
            @include('pulsar::includes.html.form_text_group', [
                 'labelSize' => 4,
                 'fieldSize' => 5,
                 'type' => 'number',
                 'label' => trans('projects::pulsar.consumed_hours'),
                 'name' => 'consumedHours',
                 'value' => old('consumedHours', isset($object)? $object->consumed_hours_090 : null),
                 'readOnly' => true
            ])
        </div>
        <div class="col-md-6">
            @include('pulsar::includes.html.form_text_group', [
                 'labelSize' => 4,
                 'fieldSize' => 5,
                 'type' => 'number',
                 'label' => trans('projects::pulsar.estimated_hours'),
                 'name' => 'estimatedHours',
                 'value' => old('estimatedHours', isset($object)? $object->estimated_hours_090 : null)
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @include('pulsar::includes.html.form_text_group', [
                 'labelSize' => 4,
                 'fieldSize' => 5,
                 'type' => 'number',
                 'label' => trans('projects::pulsar.total_hours'),
                 'name' => 'totalHours',
                 'value' => old('totalHours', isset($object)? $object->total_hours_090 : null),
                 'readOnly' => true
            ])
        </div>
        <div class="col-md-6">
        </div>
    </div>

    @include('pulsar::includes.html.form_section_header', [
        'label' => trans_choice('pulsar::pulsar.date', 2),
        'icon' => 'fa fa-hourglass-half',
        'containerId' => 'headerContent'
    ])
    @include('pulsar::includes.html.form_datetimepicker_group', [
        'fieldSize' => 4,
        'label' => trans('projects::pulsar.init_date'),
        'name' => 'initDate',
        'value' => old('initDate', isset($object->init_date_090)? date(config('pulsar.datePattern'), $object->init_date_090) : null),
        'data' => [
            'format' => Miscellaneous::convertFormatDate(config('pulsar.datePattern')),
            'locale' => config('app.locale')
        ]
    ])
    @include('pulsar::includes.html.form_datetimepicker_group', [
        'fieldSize' => 4,
        'label' => trans('projects::pulsar.estimated_end_date'),
        'name' => 'estimatedEndDate',
        'value' => old('estimatedEndDate', isset($object->estimated_end_date_090)? date(config('pulsar.datePattern'), $object->estimated_end_date_090) : null),
        'data' => [
            'format' => Miscellaneous::convertFormatDate(config('pulsar.datePattern')),
            'locale' => config('app.locale')
        ]
    ])
    @if($action == 'create')
        @include('pulsar::includes.html.form_datetimepicker_group', [
            'fieldSize' => 4,
            'label' => trans('projects::pulsar.end_date'),
            'name' => 'endDate',
            'value' => old('endDate', isset($object->end_date_090)? date(config('pulsar.datePattern'), $object->end_date_090) : null),
            'data' => [
                'format' => Miscellaneous::convertFormatDate(config('pulsar.datePattern')),
                'locale' => config('app.locale')
            ]
        ])
    @endif
    <!-- ./projects::projects.form -->
@stop