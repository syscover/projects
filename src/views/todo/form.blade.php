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
                heightMin: 125,
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

            // start change developer
            $('#developerId').on('change', function() {
                $('[name=developerName]').val($('#developerId option:selected').text())
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
                    $("#hoursFields").hide()
                    $("#descriptionTodo").hide()
                    $("#priceRequestTodo").hide()
                    $("#projectFields").fadeIn()
                }
                // 2 - hours
                else if($(this).val() == 2)
                {
                    $("#projectFields").hide()
                    $("#hoursFields").fadeIn()
                    $("#priceRequestTodo").fadeIn()
                    $("#descriptionTodo").fadeIn()
                }
                else
                {
                    $("#projectFields").hide()
                    $("#hoursFields").hide()
                    $("#descriptionTodo").hide()
                    $("#priceRequestTodo").hide()
                }
            })

            // hide every fields
            $("#projectFields").hide()
            $("#hoursFields").hide()
            $("#descriptionTodo").hide()
            $("#priceRequestTodo").hide()

            @if(isset($object))
                @if($object->type_091 == 1)
                    // 1 - project
                    $("#projectFields").show()
                @else
                    $("#hoursFields").show()
                    $("#priceRequestTodo").show()
                    $("#descriptionTodo").show()
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
    @if($resource == 'projects-developer-todo')
        @include('pulsar::includes.html.form_text_group', [
            'fieldSize' =>  5,
            'label' => trans_choice('projects::pulsar.developer', 1),
            'name' => 'developerName',
            'value' => old('developerName', isset($object)? $object->developer_name_091 : auth('pulsar')->user()->name_010 . ' ' . auth('pulsar')->user()->surname_010),
            'maxLength' => '255',
            'rangeLength' => '2,255',
            'readOnly' => true
        ])
        @include('pulsar::includes.html.form_hidden', [
            'name' => 'developerId',
            'value' => old('developerId', isset($object)? $object->developer_id_091 : auth('pulsar')->user()->id_010)
        ])
    @else
        @include('pulsar::includes.html.form_select_group', [
            'fieldSize' => 5,
            'label' => trans_choice('projects::pulsar.developer', 1),
            'id' => 'developerId',
            'name' => 'developerId',
            'value' => old('developerId', isset($object)? $object->developer_id_091 : null),
            'objects' => $developers,
            'class' => 'select2',
            'idSelect' => 'id',
            'nameSelect' => 'name',
            'required' => true,
            'data' => [
                'language' => config('app.locale'),
                'width' => '100%',
                'error-placement' => 'select2-developerId-outer-container'
            ]
        ])
        @include('pulsar::includes.html.form_hidden', [
            'name' => 'developerName',
            'value' => old('developerName', isset($object)? $object->developer_name_091 : null)
        ])
    @endif
    @include('pulsar::includes.html.form_select_group', [
        'fieldSize' => 5,
        'label' => trans_choice('pulsar::pulsar.type', 1),
        'name' => 'type',
        'value' => old('type', isset($object)? $object->type_091 : null),
        'objects' => $types,
        'idSelect' => 'id',
        'nameSelect' => 'name',
        'required' => true
    ])
    <div id="hoursFields">
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
    <div id="projectFields">
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
    <div id="descriptionTodo">
        @include('pulsar::includes.html.form_wysiwyg_group', [
            'label' => trans_choice('pulsar::pulsar.description', 1),
            'name' => 'description',
            'value' => old('description', isset($object)? $object->description_091 : null),
            'labelSize' => 2,
            'fieldSize' => 10
        ])
    </div>
    <div id="priceRequestTodo">
        @include('pulsar::includes.html.form_section_header', [
            'label' => trans_choice('pulsar::pulsar.date', 2),
            'icon' => 'fa fa-hourglass-half',
            'containerId' => 'headerContent'
        ])
        <div class="row">
            <div class="col-md-6">
                @include('pulsar::includes.html.form_text_group', [
                     'labelSize' => 4,
                     'fieldSize' => 5,
                     'type' => 'number',
                     'label' => trans_choice('pulsar::pulsar.price', 1),
                     'name' => 'price',
                     'value' => old('price', isset($object)? $object->price_091 : null)
                ])
            </div>
            <div class="col-md-6">
                @include('pulsar::includes.html.form_datetimepicker_group', [
                    'labelSize' => 4,
                    'fieldSize' => 5,
                    'label' => trans('projects::pulsar.request_date'),
                    'name' => 'requestDate',
                    'value' => old('requestDate', isset($object)? date(config('pulsar.datePattern'), $object->request_date_091) : null),
                    'data' => [
                        'format' => Miscellaneous::convertFormatDate(config('pulsar.datePattern')),
                        'locale' => config('app.locale'),
                        'max-date' => date('U')
                    ]
                ])
            </div>
        </div>
    </div>
    @include('pulsar::includes.html.form_section_header', [
        'label' => trans_choice('pulsar::pulsar.work', 2),
        'icon' => 'fa fa-keyboard-o',
        'containerId' => 'headerContent'
    ])
    @include('pulsar::includes.html.form_datetimepicker_group', [
        'fieldSize' => 4,
        'label' => trans('projects::pulsar.end_date'),
        'name' => 'endDate',
        'value' => old('endDate', isset($object)? date(config('pulsar.datePattern'), $object->end_date_091) : null),
        'data' => [
            'format' => Miscellaneous::convertFormatDate(config('pulsar.datePattern')),
            'locale' => config('app.locale'),
            'min-date' => date('U')
        ]
    ])
    @include('pulsar::includes.html.form_text_group', [
        'fieldSize' => 4,
        'type' => 'number',
        'label' => trans_choice('pulsar::pulsar.hour', 2),
        'name' => 'hours',
        'value' => old('hours', isset($object)? $object->hours_091 : null)
    ])
    <!-- ./projects::todo_.form -->
@stop