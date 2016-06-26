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
                @if($resource == 'projects-user-history')
                    shortcutsEnabled: [],
                    toolbarButtons: [],
                    toolbarButtonsMD: [],
                @elseif($resource == 'projects-history')
                    shortcutsEnabled: ['show', 'bold', 'italic', 'underline', 'strikeThrough', 'indent', 'outdent', 'undo', 'redo', 'insertImage', 'createLink'],
                    toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],
                    toolbarButtonsMD: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],
                @endif
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

            @if($resource == 'projects-user-history')
                $('.wysiwyg').froalaEditor().froalaEditor('edit.off');
            @endif

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
                    url: '{{ route('apiFacturadirectaCustomers') }}',
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
                @if($object->type_id_093 == 1)
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
        })
    </script>
@stop

@section('rows')
    <!-- projects::history.form -->
    @include('pulsar::includes.html.form_text_group', [
        'label' => 'ID',
        'name' => 'id',
        'value' => $object->id_093,
        'readOnly' => true,
        'fieldSize' => 2
    ])
    @include('pulsar::includes.html.form_select_group', [
        'fieldSize' => 5,
        'label' => trans_choice('pulsar::pulsar.user', 1),
        'id' => 'userId',
        'name' => 'userId',
        'value' => $object->user_id_093,
        'objects' => $users,
        'idSelect' => 'id',
        'nameSelect' => 'name',
        'disabled' => $resource == 'projects-user-history'? true : false
    ])
    @include('pulsar::includes.html.form_hidden', [
        'name' => 'userName',
        'value' => old('userName', isset($object)? $object->user_name_093 : null)
    ])
    @include('pulsar::includes.html.form_select_group', [
        'fieldSize' => 5,
        'label' => trans_choice('pulsar::pulsar.type', 1),
        'name' => 'type',
        'value' => old('type', $object->type_id_093),
        'objects' => $types,
        'idSelect' => 'id',
        'nameSelect' => 'name',
        'disabled' => $resource == 'projects-user-history'? true : false
    ])
    <div id="todoCustomer">
        @include('pulsar::includes.html.form_select_group', [
            'fieldSize' => 5,
            'label' => trans_choice('pulsar::pulsar.customer', 1),
            'id' => 'customerId',
            'name' => 'customerId',
            'value' => old('customerId', isset($object)? $object->customer_id_093 : null),
            'objects' => isset($customers)? $customers : null,
            'idSelect' => 'id',
            'nameSelect' => 'name',
            'disabled' => $resource == 'projects-user-history'? true : false,
            'data' => [
                'language' => config('app.locale'),
                'width' => '100%',
                'error-placement' => 'select2-customerId-outer-container'
            ]
        ])
        @include('pulsar::includes.html.form_hidden', [
            'name' => 'customerName',
            'value' => old('customerName', isset($object)? $object->customer_name_093 : null)
        ])
    </div>
    <div id="todoProject">
        @include('pulsar::includes.html.form_select_group', [
            'fieldSize' => 5,
            'label' => trans_choice('projects::pulsar.project', 1),
            'id' => 'projectId',
            'name' => 'projectId',
            'value' => $object->project_id_093,
            'objects' => $projects,
            'class' => 'select2',
            'idSelect' => 'id',
            'nameSelect' => 'name',
            'disabled' => $resource == 'projects-user-history'? true : false,
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
        'value' => $object->title_093,
        'readOnly' => $resource == 'projects-user-history'? true : false
    ])
    <div id="todoDescription">
        @include('pulsar::includes.html.form_wysiwyg_group', [
            'label' => trans_choice('pulsar::pulsar.description', 1),
            'name' => 'description',
            'value' => $object->description_093,
            'labelSize' => 2,
            'fieldSize' => 10,
            'disabled' => $resource == 'projects-user-history'? true : false
        ])
    </div>
    <div id="todoRequestDate">
        @include('pulsar::includes.html.form_datetimepicker_group', [
            'fieldSize' => 4,
            'label' => trans('projects::pulsar.request_date'),
            'name' => 'requestDate',
            'value' => old('requestDate', isset($object->request_date_093)? date(config('pulsar.datePattern'), $object->request_date_093) : null),
            'readOnly' => $resource == 'projects-user-history'? true : false,
            'data' => [
                'format' => Miscellaneous::convertFormatDate(config('pulsar.datePattern')),
                'locale' => config('app.locale')
            ]
        ])
    </div>
    @include('pulsar::includes.html.form_datetimepicker_group', [
        'fieldSize' => 4,
        'label' => trans('projects::pulsar.end_date'),
        'name' => 'endDate',
        'readOnly' => $resource == 'projects-user-history'? true : false,
        'data' => [
            'format' => Miscellaneous::convertFormatDate(config('pulsar.datePattern')),
            'locale' => config('app.locale'),
            'default-date' => date('Y-m-d', $object->end_date_093)
        ]
    ])
    <div id="todoPrice">
        @include('pulsar::includes.html.form_text_group', [
            'fieldSize' => 4,
            'type' => 'number',
            'label' => trans_choice('pulsar::pulsar.price', 1),
            'name' => 'price',
            'value' => $object->price_093,
            'readOnly' => $resource == 'projects-user-history'? true : false
        ])
    </div>
    @include('pulsar::includes.html.form_text_group', [
        'fieldSize' => 4,
        'type' => 'number',
        'label' => trans_choice('pulsar::pulsar.hour', 2),
        'name' => 'hours',
        'value' => $object->hours_093,
        'readOnly' => $resource == 'projects-user-history'? true : false
    ])
    <!-- /.projects::history.form -->
@stop