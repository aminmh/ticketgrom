<link href="{{ asset('css/default.css') }}" rel="stylesheet">
@component('vendor.mail.html.layout')
<x-slot name="header">
    @component('vendor.mail.html.header')
    <h2 @class(['rtl'])>{{$message['from']['username']}}</h2>
    @endcomponent
</x-slot>
@component('vendor.mail.html.panel')


<h5 @class(['rtl'])>
    <p>{{$message['message']}}</p>
</h5>
@endcomponent
@endcomponent
