@extends('pulsar::layouts.form')

@section('head')
    @parent

    @include('pulsar::includes.html.froala_references')

    <script>
        $(document).ready(function() {
            $('.wysiwyg').froalaEditor({
                language: '{{ config('app.locale') }}',
                placeholderText: '{{ trans('pulsar::pulsar.type_something') }}',
                toolbarInline: false,
                toolbarSticky: true,
                tabSpaces: true,
                shortcutsEnabled: [],
                toolbarButtons: [],
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
            }).froalaEditor('edit.off')

            // invoiced action
            $('#invoiceButton').on('click', function(e){
                // stop event
                e.preventDefault()

                var that = this
                $.msgbox('{{ trans('projects::pulsar.message_invoice_todo') }}',
                    {
                        type:'confirm',
                        buttons: [
                            {type: 'submit', value: '{{ trans('pulsar::pulsar.accept') }}'},
                            {type: 'cancel', value: '{{ trans('pulsar::pulsar.cancel') }}'}
                        ]
                    },
                    function(buttonPressed) {
                        if(buttonPressed == '{{ trans('pulsar::pulsar.accept') }}')
                            $(location).attr('href', $(that).attr('href'));
                    }
                )
            })


            // hide every fields
            $("#todoProject").hide()
            $("#todoCustomer").hide()
            $("#todoDescription").hide()
            $("#todoPrice").hide()
            $("#todoRequestDate").hide()

            @if(isset($object))
                @if($object->type_093 == 1)
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
    <!-- projects::billing.form -->
    @include('pulsar::includes.html.form_text_group', [
        'label' => 'ID',
        'name' => 'id',
        'value' => $object->id_093,
        'readOnly' => true,
        'fieldSize' => 2
    ])
    @include('pulsar::includes.html.form_select_group', [
        'fieldSize' => 5,
        'label' => trans_choice('projects::pulsar.developer', 1),
        'id' => 'developerId',
        'name' => 'developerId',
        'value' => $object->developer_id_093,
        'objects' => $developers,
        'idSelect' => 'id',
        'nameSelect' => 'name',
        'disabled' => true
    ])
    @include('pulsar::includes.html.form_select_group', [
        'fieldSize' => 5,
        'label' => trans_choice('pulsar::pulsar.type', 1),
        'name' => 'type',
        'value' => old('type', $object->type_093),
        'objects' => $types,
        'idSelect' => 'id',
        'nameSelect' => 'name',
        'disabled' => true
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
            'disabled' => true,
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
            'disabled' => true,
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
        'readOnly' => true
    ])
    <div id="todoDescription">
        @include('pulsar::includes.html.form_wysiwyg_group', [
            'label' => trans_choice('pulsar::pulsar.description', 1),
            'name' => 'description',
            'value' => $object->description_093,
            'labelSize' => 2,
            'fieldSize' => 10,
            'disabled' => true
        ])
    </div>
    <div id="todoRequestDate">
        @include('pulsar::includes.html.form_text_group', [
            'fieldSize' => 4,
            'label' => trans('projects::pulsar.request_date'),
            'name' => 'endDate',
            'value' => $object->request_date_text_093,
            'readOnly' => true
        ])
    </div>
    @include('pulsar::includes.html.form_text_group', [
       'fieldSize' => 4,
       'label' => trans('projects::pulsar.end_date'),
       'name' => 'endDate',
       'value' => $object->end_date_text_093,
       'readOnly' => true
    ])
    <div id="todoPrice">
        @include('pulsar::includes.html.form_text_group', [
            'fieldSize' => 4,
            'type' => 'number',
            'label' => trans_choice('pulsar::pulsar.price', 1),
            'name' => 'price',
            'value' => $object->price_093,
            'readOnly' => true
        ])
    </div>
    @include('pulsar::includes.html.form_text_group', [
        'fieldSize' => 4,
        'type' => 'number',
        'label' => trans_choice('pulsar::pulsar.hour', 2),
        'name' => 'hours',
        'value' => $object->hours_093,
        'readOnly' => true
    ])
    <!-- ./projects::billing.form -->
@stop