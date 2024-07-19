@component('mail::message')
# Progress Complete


<p>Title: {{ $title }}</p>
<br>

<x-mail::button :url="$url">
Download
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
