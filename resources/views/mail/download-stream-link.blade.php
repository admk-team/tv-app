@component('mail::message')
# Progress Complete

<p>Title: {{ $title }}</p>
<br>

@component('mail::button', ['url' => $playback_url])
Download
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
