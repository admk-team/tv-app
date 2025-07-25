@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow border-0 rounded-3">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="text-center mb-4 fw-semibold">{{ $form['title'] }}</h2>

                            <form method="POST" action="{{ route('store.registertion.form', [$form['id']]) }}">
                                @csrf
                                <input type="hidden" name="user_code" value="{{ session('USER_DETAILS.USER_CODE') }}">

                                <div class="row">
                                    @foreach ($form['fields'] as $field)
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-semibold">
                                                {{ $field['label'] }}
                                                @if ($field['is_required'])
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>

                                            @switch($field['type'])
                                                @case('text')
                                                    <input type="text" name="fields[{{ $field['id'] }}]"
                                                        class="form-control text-dark"
                                                        placeholder="{{ $field['placeholder'] ?? '' }}" {{ $field['is_required'] ? 'required' : '' }}>
                                                @break

                                                @case('paragraph')
                                                    <textarea name="fields[{{ $field['id'] }}]" class="form-control text-dark" rows="4" {{ $field['is_required'] ? 'required' : '' }}></textarea>
                                                @break

                                                @case('dropdown')
                                                    <select name="fields[{{ $field['id'] }}]" class="form-select" {{ $field['is_required'] ? 'required' : '' }}>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($field['options'] as $option)
                                                            <option value="{{ $option }}">{{ $option }}</option>
                                                        @endforeach
                                                    </select>
                                                @break

                                                @case('multiple_choice')
                                                    <div>
                                                        @foreach ($field['options'] as $option)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input text-dark" type="radio"
                                                                    name="fields[{{ $field['id'] }}]" value="{{ $option }}"
                                                                    id="radio_{{ $field['id'] }}_{{ $loop->index }}" {{ $field['is_required'] ? 'required' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="radio_{{ $field['id'] }}_{{ $loop->index }}">
                                                                    {{ $option }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @break

                                                @case('checkboxes')
                                                    <div>
                                                        @foreach ($field['options'] as $option)
                                                            <div class="form-check">
                                                                <input class="form-check-input text-dark" type="checkbox"
                                                                    name="fields[{{ $field['id'] }}][]"
                                                                    value="{{ $option }}"
                                                                    id="checkbox_{{ $field['id'] }}_{{ $loop->index }}">
                                                                <label class="form-check-label"
                                                                    for="checkbox_{{ $field['id'] }}_{{ $loop->index }}">
                                                                    {{ $option }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @break

                                                @default
                                                    <p class="text-danger">Unsupported field type: {{ $field['type'] }}</p>
                                            @endswitch

                                            @if (!empty($field['description']))
                                                <small class="text-muted">{{ $field['description'] }}</small>
                                            @endif
                                        </div>
                                    @endforeach

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="app-primary-btn rounded w-100 py-2">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
