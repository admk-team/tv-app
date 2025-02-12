@extends('layouts.app')

@push('style')
    <style>
        body {
            overflow-x: hidden;
        }

        .text-c {
            color: var(--themePrimaryTxtColor);
        }

        .input {
            background: var(--headerBgColor) !important;
            color: var(--themeSecondaryTxtColor);
            
        }

        .form-label {
            color: var(--themeActiveColor);
        }

        .label-button {
            padding: 5px;
            margin-top: 10px;
            border-radius: 10px;
            color: var(--themeSecondaryTxtColor);
            background: var(--themeActiveColor) !important;
        }

        .profile-card {
            max-width: 600px;
            margin: auto;
            background: var(--themePrimaryTxtColor);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px var(--themeActiveColor);
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--themeActiveColor);
        }

        .custom-file-label {
            overflow: hidden;
        }

        .model-tab {
            padding-bottom: 20px;
        }

        .friend-card {
            width: 18rem;
            border: none;
            border-radius: 8px;
            box-shadow: 0 0 8px var(--themeActiveColor);
            background-color: var(--themePrimaryTxtColor);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            gap: 10px;
        }

        .container-image {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            overflow: hidden;
        }

        .container-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }

        .friend-name {
            font-size: 1.25rem;
            font-weight: 500;
            color: var(--bgcolor);
            text-align: center;
        }

        .friend-action {
            text-align: center;
        }

        .friend-action .btn,
        .btn-e {
            background-color: var(--themeActiveColor) !important;
            color: var(--themeSecondaryTxtColor);
            border-radius: 20px;
            border: none;
            padding: 10px 20px;
            width: 100%;
            outline: none !important;
            border: none !important;
        }

        .friend-action .btn:hover,
        .btn-e:hover {
            background-color: var(--bgcolor) !important;
            color: var(--themeActiveColor) !important;
            outline: 2px solid var(--themeActiveColor) !important;
        }

        .friend-list {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .search-box {
            max-width: 400px;
            margin: 30px auto;
            text-align: center;
        }

        .search-box input {

            width: 100%;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid var(--themeActiveColor);
            margin-bottom: 20px;
        }



        /* for friend requests */

        .request-list {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: var(--themePrimaryTxtColor);
            border-radius: 8px;
            box-shadow: 0 4px 8px var(--themeActiveColor);
        }

        .request-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid var(--themeActiveColor);
        }

        .request-item:last-child {
            border-bottom: none;
        }

        .request-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .request-item .request-info {
            flex-grow: 1;
            display: flex;
            align-items: center;
        }

        .request-item .request-name {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--bgcolor);
            margin: 0;
        }

        .request-item .request-action {
            display: flex;
            gap: 10px;
        }

        .request-item .btn {
            border-radius: 20px;
            padding: 8px 20px;
            font-size: 0.9rem;
            border: none;
        }

        .request-item .btn.accept {
            background-color: #28a745;
            color: white;
        }

        .request-item .btn.accept:hover {
            background-color: #218838;
        }

        .request-item .btn.reject {
            background-color: #dc3545;
            color: white;
        }

        .request-item .btn.reject:hover {
            background-color: #c82333;
        }

        .request-box {
            max-width: 800px;
            margin: 30px auto;
        }

        .request-box h3,
        .heading {
            text-align: center;
            margin-bottom: 20px;
            color: var(--themeActiveColor);
        }

        @media (max-width: 768px) {
            .request-list {
                margin: 10px auto;
                padding: 5px;
            }

            .request-item {
                padding: 0px;
            }

            .request-item .request-action {
                flex-direction: column;
                gap: 10px;
            }

            .request-item .btn {
                padding: 5px 10px;
                font-size: 13px;
                border: none;
            }
        }
    </style>
@endpush

@section('content')
    <ul class="nav nav-underline justify-content-center " id="nav-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#nav-home" data-bs-toggle="tab" role="tab" id="get-profile-data"
                style="color: var(--themeSecondaryTxtColor);">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#nav-profile" data-bs-toggle="tab" role="tab" id="friend-tab"
                style="color: var(--themeSecondaryTxtColor);">Friends</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#nav-contact" data-bs-toggle="tab" role="tab" id="friend-find-tab"
                style="color: var(--themeSecondaryTxtColor);">Find Friend</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#nav-disabled" data-bs-toggle="tab" role="tab" id="friend-requests-tab"
                aria-disabled="true" style="color: var(--themeSecondaryTxtColor);">Friend Requests</a>
        </li>
    </ul>

    <div class="tab-content model-tab" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
            <div class="container mt-5">
                <div class="row">
                    <!-- Profile Section -->
                    <div class="col-md-6">
                        <h3 class="heading">Profile</h3>
                        <div class="profile-card p-4 mb-4">
                            <!-- Profile Image Upload -->
                            <form id="updateProfileForm" enctype="multipart/form-data">
                                <div class="d-flex flex-column align-items-center mb-4">
                                    <img src="{{ asset('assets/images/user1.png') }}" alt="Profile Picture"
                                        class="profile-pic" id="profileImage">
                                    <label class="label-button">
                                        Upload Image
                                        <input type="file" class="d-none" id="fileInput" name="image">
                                        <!-- ✅ Added name="image" -->
                                    </label>
                                </div>

                                <!-- Other Fields -->
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control input" placeholder="John Doe" id="user-name"
                                        name="name">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control input" placeholder="example@gmail.com"
                                        id="user-email" name="email" disabled>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" class="form-control input" placeholder="+123 456 7890"
                                        id="user-phone" name="mobile">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Account Type</label>
                                    <select class="form-control input" id="user-account-type" name="account_type">
                                        <option value=""> Select Visibility </option>
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>
                                    </select>
                                </div>

                                <button class="btn btn-primary w-100 btn-e" type="submit">Save Changes</button>
                            </form>

                        </div>
                    </div>

                    <!-- Change Password Section -->
                    <div class="col-md-6">
                        <h3 class="heading">Change Password</h3>
                        <div class="profile-card p-4 mb-4">
                            <!-- Change Password Form -->
                            <form id="passwordUpdate">
                                <div class="mb-3">
                                    <label class="form-label">Old Password</label>
                                    <input type="password" class="form-control input" placeholder="Enter old password"
                                        id="oldPassword" name="oldPassword">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control input" placeholder="Enter new password"
                                        id="npassword" name="password">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control input" placeholder="Confirm new password"
                                        id="cpassword" name="cpassword">
                                </div>

                                <button type="submit" class="btn btn-primary w-100 btn-e">Save New Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
            <div class="container mt-5 request-box">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Friend List</h3>

                        <!-- Friend Request List Section load dynamicaly -->
                        <div class="request-list" id="all-friends-data">

                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <h3>Favourite Friend</h3>

                        <!-- Friend Request List Section load dynamicaly -->
                        <div class="request-list" id="fav-freind-list">

                        </div>
                    </div> --}}
                </div>

            </div>
        </div>
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
            <div class="container mt-5">
                <!-- Search Bar -->
                <div class="search-box">
                    <input type="text" class="form-control input" id="searchInput"
                        placeholder="Search for friends...">
                </div>

                <!-- Friend Cards Section load dynamicaly -->
                <div class="friend-list" id="friend-list-responce">

                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">
            <div class="container mt-5 request-box">
                <h3>Received Friend Requests</h3>

                <!-- Friend Request List Section load dynamicaly -->
                <div class="request-list" id="friend-request-list-data">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- INTERNAL QUILL JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            //variables
            let filter_Array = [];
            let all_Friends = [];
            let displayedFriends = 20;

            $('#fileInput').on('change', function(event) {
                let file = event.target.files[0];

                if (file) {
                    let reader = new FileReader();
                    reader.readAsDataURL(file);

                    reader.onload = function() {
                        $('#profileImage').attr('src', reader.result);
                    };

                    reader.onerror = function(error) {
                        console.error('Error: ', error);
                    };
                }
            });

            $('#searchInput').on('input', function(event) {
                let searchValue = $(this).val().trim().toLowerCase();
                if ($(this).val().trim() == '') {
                    findFreindTab();
                } else {
                    let friendList = $('#friend-list-responce');
                    friendList.empty();
                    const users = filter_Array.filter(user =>
                        user.name.toLowerCase().includes(searchValue)
                    );
                    if (users.length > 0) {
                        users.forEach(user => {
                            let imageUrl = user.image_url ? user.image_url :
                                "{{ asset('assets/images/user1.png') }}";
                            let buttonHtml = '';
                            if (user.request_status == 1) {
                                buttonHtml =
                                    `<button class="btn reject" data-id="${user.code}" disabled>Sent</button> `;
                            } else {
                                buttonHtml =
                                    `<button class="btn send-request" data-id="${user.code}">Send Friend Request</button> `;
                            }
                            let friendCard = `
                                <div class="friend-card">
                                    <div class="container-image justify-content-center">
                                        <img src="${imageUrl}" alt="${user.name}">
                                    </div>
                                    <div class="friend-card-body">
                                        <p class="friend-name">${user.name}</p>
                                        <div class="friend-action">
                                            ${buttonHtml}
                                        </div>
                                    </div>
                                </div>
                            `;
                            friendList.append(friendCard);
                        });
                    } else {
                        console.log("No Friend Found Message is Triggered");
                        friendList.append(
                            '<h3 style="color: var(--themeActiveColor);">No Friend Found</h3>');
                    }
                }

            });


            // Update the profile
            $('#updateProfileForm').on('submit', (function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('update-profile') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    enctype: 'multipart/form-data',
                    success: function(data) {
                        // console.log(data);
                        if (data.status == true) {
                            Swal.fire({
                                icon: "success",
                                title: data.message,
                            });
                            loadProfileData();
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: data.message,
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }));

            // update password function 
            $('#passwordUpdate').on('submit', (function(event) {
                event.preventDefault();
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('password.update') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {

                        // Loop through the errors and display them
                        if (data.errors) {

                            if (data.errors.oldPassword) {
                                $('#oldPassword').addClass('is-invalid');
                                $('#oldPassword').after('<div class="invalid-feedback">' +
                                    data.errors.oldPassword[0] + '</div>');
                            }
                            if (data.errors.nPassword) {
                                $('#npassword').addClass('is-invalid');
                                $('#npassword').after('<div class="invalid-feedback">' +
                                    data
                                    .errors.nPassword[0] + '</div>');
                            }
                            if (data.errors.cPassword) {
                                $('#cpassword').addClass('is-invalid');
                                $('#cpassword').after('<div class="invalid-feedback">' +
                                    data.errors.cPassword[0] + '</div>');
                            }
                        }
                        if (data.app.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: data.app.msg,
                            });
                        } else {
                            Swal.fire({
                                icon: "warning",
                                title: data.app.msg,
                            });
                        }

                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }));

            // get user data 
            $('#get-profile-data').on('click', function() {
                loadProfileData();
            })

            // get all the public friends
            $('#friend-find-tab').on('click', function() {
                findFreindTab();
            });

            // handel the send freirnd request tab
            $(document).on('click', '.send-request', function() {
                let userId = $(this).data('id');
                $.ajax({
                    url: "{{ route('send-friend-request') }}",
                    method: 'POST',
                    data: {
                        user_code: userId
                    },
                    success: function(data) {
                        if (data.status == true) {
                            Swal.fire({
                                icon: "success",
                                title: data.message,
                            });
                            $('#searchInput').val('');
                            findFreindTab();
                        } else if (data.status == false) {
                            Swal.fire({
                                icon: "warning",
                                title: data.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching friend requests:', error);
                    }
                });
            });

            // get all the friends requests
            $('#friend-requests-tab').on('click', function() {
                loadfriendRequests();
            });

            // get all the friends
            $('#friend-tab').on('click', function() {
                getFirends();
                // getFavFirends();
            });

            // handel the accept the freind request
            $(document).on('click', '.accept-request', function() {
                let userId = $(this).data('id');
                $.ajax({
                    url: "{{ route('accept-friend-request') }}",
                    method: 'POST',
                    data: {
                        receiver_id: userId
                    },
                    success: function(data) {
                        if (data.status == false) {
                            Swal.fire({
                                icon: "error",
                                title: data.message,
                            });
                        } else {
                            Swal.fire({
                                icon: "success",
                                title: data.message,
                            });
                            loadfriendRequests();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching friend requests:', error);
                    }
                });
            });

            // handel the reject freirnd request
            $(document).on('click', '.reject-request', function() {
                let userId = $(this).data('id');
                $.ajax({
                    url: "{{ route('reject-friend-request') }}",
                    method: 'POST',
                    data: {
                        receiver_id: userId
                    },
                    success: function(data) {
                        if (data.status == false) {
                            Swal.fire({
                                icon: "error",
                                title: data.message,
                            });
                        } else {
                            Swal.fire({
                                icon: "success",
                                title: data.message,
                            });
                            loadfriendRequests();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching friend requests:', error);
                    }
                });
            });

            // handel the add to favourit and unfavourite freind 

            // $(document).on('click', '.add-to-fav', function() {
            //     let userId = $(this).data('id');
            //     $.ajax({
            //         url: "{{ route('mark-fav-friend') }}",
            //         method: 'POST',
            //         data: {
            //             receiver_id: userId
            //         },
            //         success: function(data) {
            //             if (data.status == false) {
            //                 Swal.fire({
            //                     icon: "error",
            //                     title: data.message,
            //                 });
            //             } else {
            //                 Swal.fire({
            //                     icon: "success",
            //                     title: data.message,
            //                 });
            //                 getFirends();
            //                 getFavFirends();
            //             }
            //         },
            //         error: function(xhr, status, error) {
            //             console.error('Error fetching friend requests:', error);
            //         }
            //     });
            // });

            // handel the un freirnd request

            // $(document).on('click', '.unfriend', function() {
            //     let userId = $(this).data('id');
            //     $.ajax({
            //         url: "{{ route('un-friend') }}",
            //         method: 'POST',
            //         data: {
            //             receiver_id: userId
            //         },
            //         success: function(data) {
            //             if (data.status == false) {
            //                 Swal.fire({
            //                     icon: "error",
            //                     title: data.message,
            //                 });
            //             } else {
            //                 Swal.fire({
            //                     icon: "success",
            //                     title: data.message,
            //                 });
            //                 getFirends();
            //             }
            //         },
            //         error: function(xhr, status, error) {
            //             console.error('Error fetching friend requests:', error);
            //         }
            //     });
            // });

            // Load More Button Click Event
            $(document).on('click', '#loadMoreBtn', function() {
                displayedFriends += 20;
                renderFriends();
            });

            //freind load more functionality
            function renderFriends() {
                let friendList = $('#friend-list-responce');
                friendList.empty();
                let users = all_Friends.slice(0, displayedFriends);
                users.forEach(user => {
                    let imageUrl = user.image_url ? user.image_url :
                        "{{ asset('assets/images/user1.png') }}";
                    let buttonHtml = '';
                    if (user.request_status == 1) {
                        buttonHtml =
                            `<button class="btn reject" data-id="${user.code}" disabled>Sent</button> `;
                    } else {
                        buttonHtml =
                            `<button class="btn send-request" data-id="${user.code}">Send Friend Request</button> `;
                    }
                    let friendCard = `
                                <div class="friend-card">
                                    <div class="container-image justify-content-center">
                                        <img src="${imageUrl}" alt="${user.name}">
                                    </div>
                                    <div class="friend-card-body">
                                        <p class="friend-name">${user.name}</p>
                                        <div class="friend-action">
                                            ${buttonHtml}
                                        </div>
                                    </div>
                                </div>
                            `;
                    friendList.append(friendCard);
                });
                if (displayedFriends < all_Friends.length) {
                    friendList.append(`
                        <div class="friend-action">
                             <button id="loadMoreBtn" class="btn load-more">Load More</button>
                        </div>
                    `);
                }
            }

            function loadProfileData() {
                $.ajax({
                    url: "{{ route('public-profile') }}",
                    method: 'GET',
                    success: function(data) {
                        // console.log(data);
                        if (data.status == true) {
                            $('#user-name').val(data.message.name);
                            $('#user-email').val(data.message.email);
                            $('#user-phone').val(data.message.mobile);
                            $('#user-account-type').val(data.message.account_type);
                            let profileImage = data.message.image_url && data.message.image_url
                                .trim() !== "" ?
                                data.message.image_url :
                                "{{ asset('assets/images/user1.png') }}";
                            $('#profileImage').attr('src', profileImage);
                        } else {
                            Swal.fire({
                                icon: "warning",
                                title: data.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching profile data:', error);
                    }
                });
            }

            function findFreindTab() {
                $.ajax({
                    url: "{{ route('public-friend') }}",
                    method: 'GET',
                    success: function(data) {
                        // console.log(data);
                        let users = data.public_users;
                        filter_Array = users;
                        all_Friends = users;
                        renderFriends();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching friend requests:', error);
                    }
                });
            }

            function getFirends() {
                let requestList = $('#all-friends-data');
                requestList.empty();

                $.ajax({
                    url: "{{ route('get-friend') }}",
                    method: 'GET',
                    success: function(data) {
                        if (data.status === true) {
                            let users = data.friends;
                            if (users.length > 0) {
                                users.forEach(user => {
                                    // The friend is now dynamically assigned in Laravel as `friend`
                                    let friend = user.friend;
                                    let imageUrl = friend.image_url ? friend.image_url :
                                        "{{ asset('assets/images/user1.png') }}";
                                    let requestCard = `
                                            <div class="request-item">
                                                <div class="request-info">
                                                    <img src="${imageUrl}" alt="Friend 1">
                                                    <p class="request-name">${friend.name}</p>
                                                </div>
                                                <div class="request-action">
                                                 <!--<button class="btn accept add-to-fav" data-id="${friend.code}">
                                                    <i class="fa fa-heart"></i>
                                                 </button> -->
                                                <button class="btn reject unfriend" data-id="${friend.code}">
                                                    Unfriend
                                                </button>
                                                </div>
                                            </div>
                                        `;

                                    requestList.append(requestCard);
                                });
                            } else {
                                requestList.append(`<h3>No Friend Found</h3>`);
                            }
                        } else {
                            requestList.append(`<h3>No Record Found</h3>`);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching friend requests:', error);
                    }
                });
            }

            // function getFavFirends() {
            //     let requestList = $('#fav-freind-list');
            //     requestList.empty();
            //     $.ajax({
            //         url: "{{ route('get-fav-friend') }}",
            //         method: 'GET',
            //         success: function(data) {
            //             // console.log(data);
            //             if (data.status == true) {
            //                 let users = data.friends;
            //                 if (users.length > 0) {
            //                     users.forEach(user => {

            //                         let friend = user.friend;
            //                         let imageUrl = friend.image_url ? friend.image_url :
            //                             "{{ asset('assets/images/user1.png') }}";

            //                         let requestCard = `
            //                             <div class="request-item">
            //                                 <div class="request-info">
            //                                     <img src="${imageUrl}" alt="Friend 1">
            //                                     <p class="request-name">${friend.name}</p>
            //                                 </div>
            //                                 <div class="request-action">
            //                                    <button class="btn btn-warning add-to-fav" data-id="${friend.code}"><i class="fa fa-heart"></i></button>
            //                                 </div>
            //                             </div>
            //                         `;

            //                         requestList.append(requestCard);
            //                     });
            //                 } else {
            //                     requestList.append(`<h3>No Friend Added</h3>`);
            //                 }
            //             } else if (data.status == false) {
            //                 let errorCard = `
            //                        <h3>No Record Found</h3>
            //                     `;
            //                 requestList.append(errorCard);
            //             }

            //         },
            //         error: function(xhr, status, error) {
            //             console.error('Error fetching friend requests:', error);
            //         }
            //     });
            // }

            function loadfriendRequests() {
                let requestList = $('#friend-request-list-data');
                requestList.empty();
                $.ajax({
                    url: "{{ route('get-friend-request') }}",
                    method: 'GET',
                    success: function(data) {
                        // console.log(data);
                        if (data.status == true) {
                            let users = data.incoming_requests;
                            if (users.length > 0) {
                                users.forEach(user => {
                                    let imageUrl = user.sender.image_url ? user.sender
                                        .image_url :
                                        "{{ asset('assets/images/user1.png') }}";
                                    let buttonHtml = '';

                                    if (user.status === 'pending') {
                                        buttonHtml = `
                                            <button class="btn accept accept-request" data-id="${user.sender.code}">Accept</button>
                                            <button class="btn reject reject-request" data-id="${user.sender.code}">Reject</button>
                                        `;
                                    } else if (user.status === 'declined') {
                                        buttonHtml = `
                                            <button class="btn reject" data-id="${user.sender.code}" disabled>Rejected</button>
                                        `;
                                    }

                                    let requestCard = `
                                        <div class="request-item">
                                            <div class="request-info">
                                                <img src="${imageUrl}" alt="Friend 1">
                                                <p class="request-name">${user.sender.name}</p>
                                            </div>
                                            <div class="request-action">
                                                ${buttonHtml}
                                            </div>
                                        </div>
                                    `;

                                    requestList.append(requestCard);
                                });
                            } else {
                                requestList.append(`<h3>No Request Found</h3>`);
                            }
                        } else if (data.status == false) {
                            let errorCard = `
                                   <h3>No Record Found</h3>
                                `;
                            requestList.append(errorCard);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching friend requests:', error);
                    }
                });
            }

            // Load profile data on page load
            loadProfileData();
        })
    </script>
@endpush
