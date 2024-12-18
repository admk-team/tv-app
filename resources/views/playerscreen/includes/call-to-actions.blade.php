@foreach($callToActions ?? [] as $cta)
    @foreach($cta['trigger_points'] ?? [] as $point)
            @switch($cta['type'])
                @case('image')
                    <div class="mvp-popup" data-show="{{ $point }}">
                        @if ($cta['link_url'] ?? null)
                        <a href="{{ $cta['link_url'] }}">
                        @endif
                            @if ($cta['image_url'] ?? null)
                                <img class="mvp-popup-img" src="{{ $cta['image_url'] }}" alt=""/>
                            @endif
                        @if ($cta['link_url'] ?? null)
                        </a>
                        @endif
                    </div>
                    @break
                @case('text')
                    <div class="mvp-popup" data-show="{{ $point }}">
                        <div class="bg-white p-4">
                            {{-- @if ($cta['link_url'] ?? null)
                            <a href="{{ $cta['link_url'] }}">
                            @endif --}}
                                <h3>{{ $cta['title'] }}</h3>
                            {{-- @if ($cta['link_url'] ?? null)
                            </a>
                            @endif --}}
                            
                            <div>{{ $cta['content'] }}</div>
                        </div>
                    </div>
                    @break
                @case('form')
                    <div class="mvp-popup mvp-popup-iframe"  data-show="{{ $point }}">
                        <iframe src="about:blank" data-src="{!! isset($cta['form'])? $cta['form']['url'] . '?user_code=' . session('USER_DETAILS.USER_CODE') . '&stream_code=' . $arrSlctItemData['stream_guid']: '' !!}" frameborder="0" scrolling="yes" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    </div>
                    @break
            @endswitch
    @endforeach
@endforeach

<script>
    window.addEventListener('message', (event) => {
        if (event.data === "close-player-popup") {
            window.player.closePopup();
        }
    });
</script>