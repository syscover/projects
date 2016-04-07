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
        })
    </script>
@stop

@section('rows')
    <!-- projects::billing.form -->
    @include('pulsar::includes.html.form_text_group', [
        'label' => 'ID',
        'name' => 'id',
        'value' => $object->id_092,
        'readOnly' => true,
        'fieldSize' => 2
    ])
    @include('pulsar::includes.html.form_select_group', [
        'fieldSize' => 5,
        'label' => trans_choice('pulsar::pulsar.user', 1),
        'id' => 'userId',
        'name' => 'userId',
        'value' => $object->user_id_092,
        'objects' => $users,
        'idSelect' => 'id',
        'nameSelect' => 'name',
        'disabled' => true
    ])
    @include('pulsar::includes.html.form_text_group', [
        'label' => trans_choice('pulsar::pulsar.customer', 1),
        'name' => 'customer',
        'value' => $object->customer_id_092 . ' ' .  $object->customer_name_092,
        'readOnly' => true
    ])
    @include('pulsar::includes.html.form_text_group', [
        'label' => trans('pulsar::pulsar.title'),
        'name' => 'title',
        'value' => $object->title_092,
        'readOnly' => true
    ])
    @include('pulsar::includes.html.form_wysiwyg_group', [
        'label' => trans_choice('pulsar::pulsar.description', 1),
        'name' => 'description',
        'value' => $object->description_092,
        'labelSize' => 2,
        'fieldSize' => 10,
        'disabled' => true
    ])
    @include('pulsar::includes.html.form_text_group', [
        'fieldSize' => 4,
        'label' => trans('projects::pulsar.request_date'),
        'name' => 'endDate',
        'value' => $object->request_date_text_092,
        'readOnly' => true
    ])
    @include('pulsar::includes.html.form_text_group', [
       'fieldSize' => 4,
       'label' => trans('projects::pulsar.end_date'),
       'name' => 'endDate',
       'value' => $object->end_date_text_092,
       'readOnly' => true
    ])
    @include('pulsar::includes.html.form_text_group', [
        'fieldSize' => 4,
        'type' => 'number',
        'label' => trans_choice('pulsar::pulsar.price', 1),
        'name' => 'price',
        'value' => $object->price_092,
        'readOnly' => true
    ])
    @include('pulsar::includes.html.form_text_group', [
        'fieldSize' => 4,
        'type' => 'number',
        'label' => trans_choice('pulsar::pulsar.hour', 2),
        'name' => 'hours',
        'value' => $object->hours_092,
        'readOnly' => true
    ])
    <!-- /.projects::billing.form -->
@stop