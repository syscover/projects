@extends('pulsar::layouts.form')

@section('head')
    @parent
    <link rel="stylesheet" href="{{ asset('packages/syscover/pulsar/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">

    <script src="{{ asset('packages/syscover/pulsar/vendor/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('packages/syscover/pulsar/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

    @include('pulsar::includes.html.froala_references')

    <script>
        $(document).ready(function() {
            $('.wysiwyg').froalaEditor({
                language: '{{ config('app.locale') }}',
                placeholderText: '{{ trans('pulsar::pulsar.type_something') }}',
                toolbarInline: false,
                toolbarSticky: true,
                tabSpaces: true,
                shortcutsEnabled: ['show', 'bold', 'italic', 'underline', 'strikeThrough', 'indent', 'outdent', 'undo', 'redo', 'insertImage', 'createLink'],
                toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],
                toolbarButtonsMD: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],
                heightMin: 125,
                enter: $.FroalaEditor.ENTER_BR,
                key: '{{ config('pulsar.froalaEditorKey') }}',
                imageUploadURL: '{{ route('froalaUploadImage') }}',
                imageUploadParams: {
                    package: 'projects',
                    _token: '{{ csrf_token() }}'
                },
                imageManagerLoadURL: '{{ route('froalaLoadImages', ['package' => 'projects']) }}',
                imageManagerDeleteURL: '{{ route('froalaDeleteImage') }}',
                imageManagerDeleteParams: {
                    package: 'projects',
                    _token: '{{ csrf_token() }}'
                },
                fileUploadURL: '{{ route('froalaUploadFile') }}',
                fileUploadParams: {
                    package: 'projects',
                    _token: '{{ csrf_token() }}'
                }
            }).on('froalaEditor.image.removed', function (e, editor, $img) {

                $.ajax({
                    method: "POST",
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    url: '{{ route('froalaDeleteImage') }}',
                    data: {
                        package: 'projects',
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

            // start change user
            $('#userId').on('change', function() {
                $('[name=userName]').val($('#userId option:selected').text())
            })

            // start select2 ajax function
            // need declare firs, custom templates before, select2 function
            $.formatCustomer = function(customer) {
                if(customer.name == undefined)
                {
                    return '{{ trans('pulsar::pulsar.searching') }}...'
                }
                else
                {
                    if(Array.isArray(customer.tradeName))
                    {
                        return customer.companyCode + ' ' + customer.name
                    }
                    else
                    {
                        return customer.companyCode + ' ' + customer.name + ' (' + customer.tradeName + ')'
                    }
                }
            }

            $.formatCustomerSelection = function (customer) {
                if(customer.name == undefined)
                {
                    @if(isset($customers))
                        return '{{ $customers->first()->companyCode . ' ' . $customers->first()->name . (empty($customers->first()->tradeName)? null : ' ('. $customers->first()->tradeName .')') }}'
                    @else
                        return customer
                    @endif
                }
                else
                {
                    if(Array.isArray(customer.tradeName))
                    {
                        $('[name=customerName]').val(customer.companyCode + ' ' + customer.name)
                        return customer.companyCode + ' ' + customer.name
                    }
                    else
                    {
                        $('[name=customerName]').val(customer.companyCode + ' ' + customer.name + ' (' + customer.tradeName + ')')
                        return customer.companyCode + ' ' + customer.name + ' (' + customer.tradeName + ')'
                    }
                }
            }

            // intems per page
            var itemsPerPage = 25;
            $('#customerId').select2({
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: 'POST',
                    url: '{{ route('apiFacturaDirectaCustomers') }}',
                    data: function (params) {
                        return {
                            // search term
                            term:  params.term,
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

            // start change type todo_
            $('[name=type]').on('change', function() {
                // 1 - project
                if($(this).val() == 1)
                {
                    $("#todoCustomer").hide()
                    $("#todoDescription").hide()
                    $("#todoPrice").hide()
                    $("#todoRequestDate").hide()
                    $("#todoProject").fadeIn()
                }
                // 2 - hours
                else if($(this).val() == 2)
                {
                    $("#todoProject").hide()
                    $("#todoRequestDate").fadeIn()
                    $("#todoCustomer").fadeIn()
                    $("#todoPrice").fadeIn()
                    $("#todoDescription").fadeIn()

                }
                else
                {
                    $("#todoProject").hide()
                    $("#todoCustomer").hide()
                    $("#todoDescription").hide()
                    $("#todoPrice").hide()
                    $("#todoRequestDate").hide()
                }
            })

            // hide every fields
            $("#todoProject").hide()
            $("#todoCustomer").hide()
            $("#todoDescription").hide()
            $("#todoPrice").hide()
            $("#todoRequestDate").hide()

            @if(isset($object))
                @if($object->type_id_091 == 1)
                    // 1 - project
                    $("#todoProject").show()
                @else
                    // 2 - hour
                    $("#todoCustomer").show()
                    $("#todoPrice").show()
                    $("#todoDescription").show()
                    $("#todoRequestDate").show()
                @endif
            @endif
            // end change type todo_
        })
    </script>
@stop

@section('rows')
    <!-- projects::todo_.form -->
    @include('pulsar::includes.html.form_text_group', [
        'label' => 'ID',
        'name' => 'id',
        'value' => old('id', isset($object)? $object->id_091 : null),
        'readOnly' => true,
        'fieldSize' => 2
    ])
    @if($resource == 'projects-user-todo')
        @include('pulsar::includes.html.form_text_group', [
            'fieldSize' =>  5,
            'label' => trans_choice('pulsar::pulsar.user', 1),
            'name' => 'userName',
            'value' => old('userName', isset($object)? $object->user_name_091 : auth()->guard('pulsar')->user()->name_010 . ' ' . auth()->guard('pulsar')->user()->surname_010),
            'maxLength' => '255',
            'rangeLength' => '2,255',
            'readOnly' => true
        ])
        @include('pulsar::includes.html.form_hidden', [
            'name' => 'userId',
            'value' => old('userId', isset($object)? $object->user_id_091 : auth()->guard('pulsar')->user()->id_010)
        ])
    @else
        @include('pulsar::includes.html.form_select_group', [
            'fieldSize' => 5,
            'label' => trans_choice('pulsar::pulsar.user', 1),
            'id' => 'userId',
            'name' => 'userId',
            'value' => old('userId', isset($object)? $object->user_id_091 : null),
            'objects' => $users,
            'class' => 'select2',
            'idSelect' => 'id',
            'nameSelect' => 'name',
            'required' => true,
            'data' => [
                'language' => config('app.locale'),
                'width' => '100%',
                'error-placement' => 'select2-userId-outer-container'
            ]
        ])
        @include('pulsar::includes.html.form_hidden', [
            'name' => 'userName',
            'value' => old('userName', isset($object)? $object->user_name_091 : null)
        ])
    @endif
    @include('pulsar::includes.html.form_select_group', [
        'fieldSize' => 5,
        'label' => trans_choice('pulsar::pulsar.type', 1),
        'name' => 'type',
        'value' => old('type', isset($object)? $object->type_id_091 : null),
        'objects' => $types,
        'idSelect' => 'id',
        'nameSelect' => 'name',
        'required' => true
    ])
    <div id="todoCustomer">
        @include('pulsar::includes.html.form_select_group', [
            'fieldSize' => 5,
            'label' => trans_choice('pulsar::pulsar.customer', 1),
            'id' => 'customerId',
            'name' => 'customerId',
            'value' => old('customerId', isset($object)? $object->customer_id_091 : null),
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
            'value' => old('customerName', isset($object)? $object->customer_name_091 : null)
        ])
    </div>
    <div id="todoProject">
        @include('pulsar::includes.html.form_select_group', [
            'fieldSize' => 5,
            'label' => trans_choice('projects::pulsar.project', 1),
            'id' => 'projectId',
            'name' => 'projectId',
            'value' => old('projectId', isset($object)? $object->project_id_091 : null),
            'objects' => $projects,
            'class' => 'select2',
            'idSelect' => 'id',
            'nameSelect' => 'name',
            'required' => true,
            'data' => [
                'language' => config('app.locale'),
                'width' => '100%',
                'error-placement' => 'select2-projectId-outer-container'
            ]
        ])
    </div>
    @include('pulsar::includes.html.form_text_group', [
        'label' => trans('pulsar::pulsar.title'),
        'name' => 'title',
        'value' => old('title', isset($object)? $object->title_091 : null),
        'maxLength' => '255',
        'rangeLength' => '2,255',
        'required' => true
    ])
    <div id="todoDescription">
        @include('pulsar::includes.html.form_wysiwyg_group', [
            'label' => trans_choice('pulsar::pulsar.description', 1),
            'name' => 'description',
            'value' => old('description', isset($object)? $object->description_091 : null),
            'labelSize' => 2,
            'fieldSize' => 10
        ])
    </div>
    <div id="todoRequestDate">
        @include('pulsar::includes.html.form_datetimepicker_group', [
            'fieldSize' => 4,
            'label' => trans('projects::pulsar.request_date'),
            'name' => 'requestDate',
            'data' => [
                'format' => Miscellaneous::convertFormatDate(config('pulsar.datePattern')),
                'locale' => config('app.locale'),
                'max-date' => date('Y-m-d'),
                'default-date' => old('requestDate', isset($object->request_date_091)? date('Y-m-d', $object->request_date_091) : null)
            ]
        ])
    </div>
    @include('pulsar::includes.html.form_datetimepicker_group', [
        'fieldSize' => 4,
        'label' => trans('projects::pulsar.end_date'),
        'name' => 'endDate',
        'data' => [
            'format' => Miscellaneous::convertFormatDate(config('pulsar.datePattern')),
            'locale' => config('app.locale'),
            'default-date' => old('endDate', isset($object->end_date_091)? date('Y-m-d', $object->end_date_091) : null)
        ]
    ])
    <div id="todoPrice">
        @include('pulsar::includes.html.form_text_group', [
            'fieldSize' => 4,
            'type' => 'number',
            'label' => trans_choice('pulsar::pulsar.price', 1),
            'name' => 'price',
            'value' => old('price', isset($object)? $object->price_091 : null)
        ])
    </div>
    @include('pulsar::includes.html.form_text_group', [
        'fieldSize' => 4,
        'type' => 'number',
        'label' => trans_choice('pulsar::pulsar.hour', 2),
        'name' => 'hours',
        'value' => old('hours', isset($object)? $object->hours_091 : null)
    ])
    <!-- /projects::todo_.form -->
@stop