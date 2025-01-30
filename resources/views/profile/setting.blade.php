@extends('layouts.app')

@push('style')
    <style>
        body {
            overflow-x: hidden;
        }

        .text-c {
            color: var(--themePrimaryTxtColor);
        }

        .input{
            background: var(--headerBgColor) !important;
            color: var(--themeSecondaryTxtColor);
        }

        .form-label{
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
            background: var(--headerBgColor);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            background-color: var(--headerBgColor);
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
            color: var(--themeSecondaryTxtColor);
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

            width: 80%;
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
            background-color: var(--headerBgColor);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            color: var(--themeSecondaryTxtColor);
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
    </style>
@endpush

@section('content')
    <ul class="nav nav-underline justify-content-center" id="nav-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#nav-home" data-bs-toggle="tab" role="tab"
                style="color: var(--themeSecondaryTxtColor);">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#nav-profile" data-bs-toggle="tab" role="tab"
                style="color: var(--themeSecondaryTxtColor);">Friends</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#nav-contact" data-bs-toggle="tab" role="tab"
                style="color: var(--themeSecondaryTxtColor);">Find Friend</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#nav-disabled" data-bs-toggle="tab" role="tab" aria-disabled="true"
                style="color: var(--themeSecondaryTxtColor);">Friend Requests</a>
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
                            <div class="d-flex flex-column align-items-center mb-4">
                                <img src="{{ asset('assets/images/download.jpg') }}" alt="Profile Picture"
                                    class="profile-pic" id="profileImage">
                                <label class="label-button">
                                    Upload Image
                                    <input type="file" class="d-none" id="fileInput">
                                </label>
                            </div>

                            <!-- Profile Form -->
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control input" placeholder="John Doe">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control input" placeholder="example@gmail.com">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" class="form-control input" placeholder="+123 456 7890">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control input" placeholder="123 Street, City, Country">
                                </div>

                                <button type="submit" class="btn btn-primary w-100 btn-e">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Section -->
                    <div class="col-md-6">
                        <h3 class="heading">Change Password</h3>
                        <div class="profile-card p-4 mb-4">
                            <!-- Change Password Form -->
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control input" placeholder="Enter new password">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control input" placeholder="Confirm new password">
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
                    <div class="col-md-6">
                        <h3>Friend List</h3>

                        <!-- Friend Request List Section -->
                        <div class="request-list">
                            <!-- Request Item 1 -->
                            <div class="request-item">
                                <div class="request-info">
                                    <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                                    <p class="request-name">John Doe</p>
                                </div>
                                <div class="request-action">
                                    <button class="btn accept"><i class="fa fa-heart"></i></button>
                                    <button class="btn reject">Unfriend</button>
                                </div>
                            </div>

                            <!-- Request Item 2 -->
                            <div class="request-item">
                                <div class="request-info">
                                    <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                                    <p class="request-name">Jane Smith</p>
                                </div>
                                <div class="request-action">
                                    <button class="btn accept"><i class="fa fa-heart"></i></button>
                                    <button class="btn reject">Unfriend</button>
                                </div>
                            </div>

                            <!-- Request Item 3 -->
                            <div class="request-item">
                                <div class="request-info">
                                    <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                                    <p class="request-name">Michael Brown</p>
                                </div>
                                <div class="request-action">
                                    <button class="btn accept"><i class="fa fa-heart"></i></button>
                                    <button class="btn reject">Unfriend</button>
                                </div>
                            </div>

                            <!-- Request Item 4 -->
                            <div class="request-item">
                                <div class="request-info">
                                    <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                                    <p class="request-name">Sarah Lee</p>
                                </div>
                                <div class="request-action">
                                    <button class="btn accept"><i class="fa fa-heart"></i></button>
                                    <button class="btn reject">Unfriend</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>Favourite Friend</h3>

                        <!-- Friend Request List Section -->
                        <div class="request-list">
                            <!-- Request Item 1 -->
                            <div class="request-item">
                                <div class="request-info">
                                    <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                                    <p class="request-name">John Doe</p>
                                </div>
                                <div class="request-action">
                                    <button class="btn btn-warning"><i class="fa fa-heart"></i></button>
                                </div>
                            </div>

                            <!-- Request Item 2 -->
                            <div class="request-item">
                                <div class="request-info">
                                    <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                                    <p class="request-name">Jane Smith</p>
                                </div>
                                <div class="request-action">
                                    <button class="btn btn-warning"><i class="fa fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
            <div class="container mt-5">
                <!-- Search Bar -->
                {{-- <div class="search-box">
                    <input type="text" class="form-control input" id="searchInput" placeholder="Search for friends...">
                </div> --}}

                <!-- Friend Cards Section -->
                <div class="friend-list">
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                    <!-- Friend Card 1 -->
                    <div class="friend-card">
                        <div class="container-image justify-content-center">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">John Doe</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>

                    <!-- Friend Card 2 -->
                    <div class="friend-card">
                        <div class="container-image">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">Jane Smith</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>

                    <!-- Friend Card 3 -->
                    <div class="friend-card">
                        <div class="container-image">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">Michael Brown</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>

                    <!-- Friend Card 4 -->
                    <div class="friend-card">
                        <div class="container-image">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                        </div>
                        <div class="friend-card-body">
                            <p class="friend-name">Sarah Lee</p>
                            <div class="friend-action">
                                <button class="btn">Send Friend Request</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">
            <div class="container mt-5 request-box">
                <h3>Received Friend Requests</h3>

                <!-- Friend Request List Section -->
                <div class="request-list">
                    <!-- Request Item 1 -->
                    <div class="request-item">
                        <div class="request-info">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                            <p class="request-name">John Doe</p>
                        </div>
                        <div class="request-action">
                            <button class="btn accept">Accept</button>
                            <button class="btn reject">Reject</button>
                        </div>
                    </div>

                    <!-- Request Item 2 -->
                    <div class="request-item">
                        <div class="request-info">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                            <p class="request-name">Jane Smith</p>
                        </div>
                        <div class="request-action">
                            <button class="btn accept">Accept</button>
                            <button class="btn reject">Reject</button>
                        </div>
                    </div>

                    <!-- Request Item 3 -->
                    <div class="request-item">
                        <div class="request-info">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                            <p class="request-name">Michael Brown</p>
                        </div>
                        <div class="request-action">
                            <button class="btn accept">Accept</button>
                            <button class="btn reject">Reject</button>
                        </div>
                    </div>

                    <!-- Request Item 4 -->
                    <div class="request-item">
                        <div class="request-info">
                            <img src="{{ asset('assets/images/download.jpg') }}" alt="Friend 1">
                            <p class="request-name">Sarah Lee</p>
                        </div>
                        <div class="request-action">
                            <button class="btn accept">Accept</button>
                            <button class="btn reject">Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- INTERNAL QUILL JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
