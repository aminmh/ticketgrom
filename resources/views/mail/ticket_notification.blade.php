<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@component('vendor.mail.html.layout')
<x-slot name="header">
    @component('vendor.mail.html.header')
    <h2 @class(['rtl'])>{{$ticket->subject}}</h2>
    @endcomponent
</x-slot>
@component('vendor.mail.html.panel')
@if ($ticket->cc)
<ul style="text-align: left;">
    @foreach ($ticket->cc as $cc)
    <li> cc: {{$cc}} </li>
    @endforeach
</ul>
@endif

<ul style="text-align: left;">
    @foreach ($ticket->bcc as $bcc)
    <li> bcc: {{$bcc}} </li>
    @endforeach
</ul>
<h5 @class(['rtl'])>
    <strong>{{$ticket->text}}</strong>
</h5>
@endcomponent
@endcomponent
