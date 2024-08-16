@extends('layouts.app')
<style>
    h1 {
        color: white !important;
    }

    .content {
        color: white !important;
    }

    .select2-selection__choice__display {
        color: black;
    }
</style>
@section('content')
    <div class="container-fluid actor-container">
        <div class="container mt-4">
            <div>
                <h1>Manage Profiles</h1>
            </div>
            <div class="d-flex flex-column" style="margin-top:50px; margin-left: 200px; margin-bottom:200px">
                @foreach (($user_data['user_profiles'] ?? []) as $user)
                    <div class="row" style="margin: 20px;">
                        <div>
                            <h4>Profile Name: </h4>
                        </div>
                        <div class="col-sm-2" style="margin-top:10px">
                            <h4>{{ $user['name'] }}</h4>
                        </div>
                        <div class="col-lg-2">
                            <form id="mangeprofile">
                                @csrf
                                <select name="content_rating[]" class="form-control app_code_select"
                                    id="{{ $user['id'] }}_content_rating" multiple="multiple" style="width:465px">
                                    @foreach (($user_data['all_ratings'] ?? []) as $rating)
                                        @php
                                            $selected = collect(old('content_rating'))->contains($rating['title']) || (isset($rating['code']) && in_array($rating['code'], explode(',', $user['content_rating']))) ? 'selected' : '';
                                        @endphp
                                        @if($rating['title'])
                                        <option value="{{ $rating['code'] }}" {{ $selected }}
                                            style="color:black !important">
                                            {{ $rating['title'] }}
                                        </option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="button" class="app-primary-btn rounded submit" id="{{ $user['id'] }}"
                                    style="margin-top: 10px">Update</button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var select2type = $('.app_code_select').select2({});

        $('.submit').on('click', function(event) {
            event.preventDefault();
            console.log(this.id);
            let content_rating = $('#' + this.id + '_content_rating').val();
            var action_url = '';
            // var formdata = new FormData(this);
            action_url = '{{ env('API_BASE_URL') }}' + '/manageprofiles/' + this.id;
            let formData = new FormData();
            formData.append('content_rating', content_rating);
            $.ajax({
                url: action_url,
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(data) {

                    var html = '';
                    if (data.message) {
                        html = '<div class="alert alert-success">' + data.message +
                            '</div>';
                        $('#sample_form')[0].reset();
                        window.LaravelDataTables["tvactor-table"].ajax.reload();
                        setTimeout(function() {
                            $('#formModal').modal('hide'); // Hide the modal
                        }, 1000);
                    }
                    $('#form_result').html(html);
                },
                error: function(data) {
                    console.log('data', data)
                    if (data.responseJSON.message) {
                        html = '<div class="alert alert-danger">';
                        html += '<span>' + data.responseJSON.message + '</span>'
                        // for (var count = 0; count < data.errors.length; count++) {
                        //     html += '<p>' + data.errors[count] + '</p>';
                        // }
                        html += '</div>';
                        $('#form_result').html(html);
                    }

                }

            });
        });
    </script>
@endpush
