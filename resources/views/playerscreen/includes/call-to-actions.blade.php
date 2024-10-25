{{-- @foreach($callToActions ?? [] as $cta)
    @foreach($cta['trigger_points'] ?? [] as $point)
        <div class="mvp-popup" data-show="{{ $point }}">
            <div class="bg-white">
                <h3>Call To Action</h3>
            </div>
        </div>
    @endforeach
@endforeach --}}

<div class="mvp-popup" data-show="30">
    <div class="bg-white">
        <h3>Popup 1</h3>
    </div>
</div>

<div class="mvp-popup" data-show="40">
    <div class="bg-white">
        <h3>Popup 2</h3>
    </div>
</div>