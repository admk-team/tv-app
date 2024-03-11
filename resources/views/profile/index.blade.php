@extends('layouts.app')

@push('style')
    <style>
        body {
            overflow-x: hidden;
        }
    </style>
@endpush

@section('content')
    <div class="all__profiles">
        <div class="whoIsWatching">
            <h1 class="text-white text-center">Who's watching?</h1>
            <div class="memberDiv">
                <button class="addIcon">
                    <span>Add Profile</span>
                    <i class="fa fa-plus-circle"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="addIconModal" role="dialog" aria-labelledby="addIconModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addIconModalLabel">Add Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label for="userNameModal" class="form-label"
                                        style="color: #000 !important; background-color: #fff !important;">Your
                                        Name:</label>
                                    <input type="text" id="userNameModal" class="form-control"
                                        style="color: #000 !important; background-color: #fff !important;">
                                    <small id="nameErrorMessageModal" class="text-danger"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- New dropdown for content ratings -->
                                    <div class="row">
                                        <label for="content_rating" class="form-label"
                                            style="color: #000 !important; background-color: #fff !important;">Content
                                            Rating:</label>
                                    </div>
                                    <select name="content_rating[]" class="form-control app_code_select" id="content_rating"
                                        multiple="multiple"
                                        style="color: #000 !important; background-color: #fff !important; width:465px">
                                        @foreach ($user_data['all_ratings'] as $rating)
                                            @if ($rating['title'])
                                                <option value="{{ $rating['code'] }}">{{ $rating['title'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Close</button> --}}
                        <button type="button" class="app-primary-btn rounded" id="addIconModalBtn">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- INTERNAL QUILL JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Function to populate the content rating dropdown

        var totalProfiles = 0;
        var users = []; // Define users array
        var select2type = $('.app_code_select').select2({
            dropdownParent: $("#addIconModal"),
            placeholder: "Select",
        });

        $(document).ready(function() {
            let usersProfiles = [];

            // Fetch user profiles from API
            $.ajax({
                type: "GET",
                url: '{{ env('API_BASE_URL') }}' + '/userprofiles/' +
                    '{{ session('USER_DETAILS')['USER_ID'] }}',
                dataType: 'json',
            }).done(function(data) {
                var dataArray = data;
                usersProfiles = dataArray.user_profiles;

                // Call the function to populate the dropdown
                // populateContentRatingDropdown(dataArray.all_ratings);

                if (usersProfiles.length >= 6) {
                    $('.addIcon').hide();
                }
                userIcons(usersProfiles);
                users = usersProfiles.map(user => user.name); // Populate users array with names
            });


            const memberDiv = document.querySelector('.memberDiv');
            const addIcon = document.querySelector('.addIcon');

            const userIcons = (usersProfiles) => {
                totalProfiles = usersProfiles.length;
                usersProfiles.map((curElem) => {
                    memberDiv.insertAdjacentHTML('afterbegin', `
                        <button class="btn" data-id="${curElem.id}">
                            <span>${curElem.name}</span>
                            <i class="bi bi-dash-circle account-delete-icon" onclick="deleteProfile(${curElem.id})"></i>
                        </button>
                    `);
                });
            };

            addIcon.addEventListener('click', () => {
                // Show the modal
                $('#addIconModal').modal('show');
            });

            // Handle the modal add button click
            $('#addIconModalBtn').on('click', function() {
                let userName = $('#userNameModal').val();
                let content_rating = $('#content_rating').val(); // Get selected content rating
                let nameErrorMessage = $('#nameErrorMessageModal');

                // Validate the name field
                if (userName === '') {
                    nameErrorMessage.text('Please enter your name');
                    return;
                } else {
                    // Clear the error message if the name is provided
                    nameErrorMessage.text('');
                }

                if (!users.includes(userName)) {
                    let queryStringPOST = {
                        userId: '{{ session('USER_DETAILS')['USER_ID'] }}',
                        name: userName,
                        content_rating: content_rating, // Include content rating in the post request
                    }

                    // Your existing AJAX call remains unchanged
                    $.ajax({
                        type: "POST",
                        url: '{{ env('API_BASE_URL') }}' + '/userprofiles',
                        dataType: 'json',
                        data: queryStringPOST,
                    }).done(function(data) {
                        let currentProfile = data.pop();
                        if (data.error) {
                            alert(data.error);
                        } else {
                            users.push(userName);
                            memberDiv.insertAdjacentHTML('afterbegin', `
                                <button class="btn" data-id="${currentProfile.id}">
                                    <span>${currentProfile.name}</span>
                                    <i class="bi bi-dash-circle account-delete-icon" onclick="deleteProfile(${currentProfile.id})"></i>
                                </button>
                            `);
                            totalProfiles = $(".btn").length;

                            if (totalProfiles >= 6) {
                                $('.addIcon').hide();
                            } else {
                                $('.addIcon').show();
                            }

                            // Hide the modal after successful addition
                            $('#addIconModal').modal('hide');
                            // Clear the name field for the next entry
                            $('#userNameModal').val('');
                        }
                    });
                } else {
                    alert('Username already exists');
                }
            });
            var profileid = null;
            $(document).on('click', '.btn', function(e) {
                var profileid = this.getAttribute('data-id');
                if (!event.target.classList.contains("account-delete-icon")) {
                    window.location.href = '{{ url('/') }}' + '/view/profile/' + profileid;
                }
            });

            // Function to populate content rating dropdown
            function populateContentRatingDropdown(contentRatings) {
                let contentRatingDropdown = $('#contentRatingModal');
                contentRatingDropdown.empty(); // Clear existing options

                // Add default option
                contentRatingDropdown.append($('<option>', {
                    value: '',
                    text: 'Select Content Rating',
                }));

                // Add options for each content rating
                contentRatings.forEach(function(rating) {
                    contentRatingDropdown.append($('<option>', {
                        value: rating.id,
                        text: rating.name,
                    }));
                });
            }
        });

        function deleteProfile(id) {
            $.ajax({
                    type: 'GET',
                    url: `{{ env('API_BASE_URL') }}/userprofiles/delete/${id}`,
                    dataType: 'json',
                })
                .done(function(data) {
                    if (data.success) {
                        var deletedProfile = $(`[data-id=${id}]`);
                        if (deletedProfile.length)
                            deletedProfile.remove();

                        totalProfiles = $(".btn").length;
                        if (totalProfiles < 6) {
                            $('.addIcon').show();
                        }
                    }
                })
                .fail(function(error) {
                    alert(error.responseJSON.message);
                    console.error('Error deleting profile:', error.responseJSON.message);
                });
        }
    </script>
@endpush
