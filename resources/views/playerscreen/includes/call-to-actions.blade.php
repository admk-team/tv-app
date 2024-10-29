@foreach($callToActions ?? [] as $cta)
    @foreach($cta['trigger_points'] ?? [] as $point)
        <div class="mvp-popup" data-show="{{ $point }}">
            @if ($cta['type'] === 'image')
                @if ($cta['link_url'] ?? null)
                <a href="{{ $cta['link_url'] }}">
                @endif
                    @if ($cta['image_url'] ?? null)
                        <img class="mvp-popup-img" src="{{ $cta['image_url'] }}" alt=""/>
                    @endif
                @if ($cta['link_url'] ?? null)
                </a>
                @endif
            @endif

            @if ($cta['type'] === 'text')
                <div class="bg-white p-4">
                    @if ($cta['link_url'] ?? null)
                    <a href="{{ $cta['link_url'] }}">
                    @endif
                        <h3>{{ $cta['title'] }}</h3>
                    @if ($cta['link_url'] ?? null)
                    </a>
                    @endif
                    
                    <div>{{ $cta['content'] }}</div>
                </div>
            @endif
        </div>
    @endforeach
@endforeach