@component('mail::message')
# Progress Complete

<p>Title: {{ $title }}</p>
<br>

@component('mail::button', ['url' => route('video.download', ['streamId' => $id])])
Download
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
