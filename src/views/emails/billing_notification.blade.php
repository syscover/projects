@extends('projects::layouts.mail')

@section('mainContent')
<table cellspacing="0" cellpadding="0" width="100%" style="background:#ffffff;margin:0;padding:0;border:0;text-align:left;border-collapse:collapse;border-spacing:0">
    <tr>
        <td class="header_body brown" valign="middle" width="100%" style='background:#ffffff;text-align:left;font-size:15px;line-height:19px;font-family:"Helvetica Neue",helvetica,arial,sans-serif;border-collapse:collapse;padding:0;border-spacing:0;vertical-align:middle;padding-left:10px;width:auto !important;'>
            {{ trans('projects::pulsar.message_todo_finished') }} <strong>{{ $billing->end_date_text_092 }}</strong>
        </td>
    </tr>
    <tr>
        <td width="100%">&nbsp;</td>
    </tr>
    <tr>
        <td class="header_body brown" valign="middle" width="100%" style='background:#ffffff;text-align:left;font-size:15px;line-height:19px;font-family:"Helvetica Neue",helvetica,arial,sans-serif;border-collapse:collapse;padding:0;border-spacing:0;vertical-align:middle;padding-left:10px;width:auto !important'>
            <strong style="color:brown;">{{ trans('projects::pulsar.billing') }} {{ $billing->id_092 }}</strong>
        </td>
    </tr>
    <tr>
        <td class="content_body" style='background:#ffffff;text-align:left;vertical-align:top;font-size:15px;line-height:19px;border-collapse:collapse;color:#000000;border-spacing:0;font-family:"Helvetica Neue",helvetica,arial,sans-serif;padding:0 0 0 55px'>
            <br>
            <div class="formatted_content" style="padding-bottom:19px;padding:0 !important;border:none !important;margin:0 0 5px !important;max-width:none !important">
                <strong>{{ trans_choice('projects:pulsar.developer', 1) }}:</strong> {{ $billing->developer_name_092 }}
            </div>
            <div class="formatted_content" style="padding-bottom:19px;padding:0 !important;border:none !important;margin:0 0 5px !important;max-width:none !important">
                <strong>{{ trans_choice('pulsar::pulsar.customer', 1) }}:</strong> {{ $billing->customer_name_092 }}
            </div>
            <div class="formatted_content" style="padding-bottom:19px;padding:0 !important;border:none !important;margin:0 0 5px !important;max-width:none !important">
                <strong>{{ trans('pulsar::pulsar.title') }}:</strong> {{ $billing->title_092 }}
            </div>
            <div class="formatted_content" style="padding-bottom:19px;padding:0 !important;border:none !important;margin:0 0 5px !important;max-width:none !important">
                <strong>{{ trans_choice('pulsar::pulsar.description', 1) }}:</strong> {!! $billing->description_092 !!}
            </div>
            <div class="formatted_content" style="padding-bottom:19px;padding:0 !important;border:none !important;margin:0 0 5px !important;max-width:none !important">
                <strong>{{ trans_choice('pulsar::pulsar.hour', 2) }}:</strong> {{ $billing->hours_092 }}
            </div>
            <div class="formatted_content" style="padding-bottom:19px;padding:0 !important;border:none !important;margin:0 0 5px !important;max-width:none !important">
                <strong>{{ trans_choice('pulsar::pulsar.price', 1) }}:</strong> {{ isset($billing->price_092)? $billing->price_092 . '€' : null }}
            </div>
        </td>
    </tr>
    <tr>
        <td width="100%">&nbsp;</td>
    </tr>
</table>
@stop
