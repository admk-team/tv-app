@extends('layouts.app')

@push('style')
    <style>
        body {
            overflow-x: hidden;
        }

        .main-div {
            height: 100% !important;
        }

        .whoIsWatching {
            padding-top: 120px;
        }

        .addIcon i {
            font-size: 7.9vw !important;
        }
    </style>
@endpush

@section('content')
    <div class="whoIsWatching">
        <!--<div class="logo-section">-->
        <!--    <a href="/"><img src="images/logo.png" alt="logo"></a>-->
        <!--</div>-->

        <div class="main-div">
            <h1>Who's watching?</h1>
            <div class="memberDiv">
                <button class="addIcon"><i class="fa fa-plus-circle"></i> <span>Add Profile</span></button>
            </div>
            <!--<button class="manageProfile">manage Profile</button>-->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var totalProfiles = 0;

        $(document).ready(function() {
            let usersProfiles = [];
            let users = [];
            $.ajax({
                type: "GET",
                url: '{{ env('API_BASE_URL') }}' + '/userprofiles/' +
                    '{{ session('USER_DETAILS')['USER_ID'] }}',
                dataType: 'json',
            }).done(function(data) {
                var dataArray = data;
                usersProfiles = dataArray.data
                if (usersProfiles.length >= 6) {
                    $('.addIcon').hide();
                }
                userIcons(usersProfiles);
                users = usersProfiles;
            });




            console.log('array', users);

            const memberDiv = document.querySelector('.memberDiv');
            const addIcon = document.querySelector('.addIcon');


            const userIcons = (usersProfiles) => {
                console.log('usersProfiles', usersProfiles);
                totalProfiles = usersProfiles.length;
                // usersProfiles.reverse();
                usersProfiles.map((curElem) => {
                    memberDiv.insertAdjacentHTML('afterbegin', `
                <button class="btn" data-id="${curElem.id}"><span>${curElem.name}</span>
                    <i class="bi bi-dash-circle account-delete-icon" onclick="deleteProfile(${curElem.id})"></i>
                    </button>
                `);
                })
            };

            addIcon.addEventListener('click', () => {
                let userName = prompt('please enter your name');
                if (userName == '') {
                    return alert('Please enter your name');
                }

                if (userName != null && !users.includes(userName)) {
                    let queryStringPOST = {
                        userId: '{{ session('USER_DETAILS')['USER_ID'] }}',
                        name: userName
                    }
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
                <button class="btn" data-id="${currentProfile.id}"><span>${currentProfile.name}</span>
                    <i class="bi bi-dash-circle account-delete-icon" onclick="deleteProfile(${currentProfile.id})"></i>
                    </button>
                `);
                            totalProfiles = $(".btn").length;
                            console.log('totalProfiles addd', totalProfiles);
                            if (totalProfiles >= 6) {
                                $('.addIcon').hide();
                            } else {
                                $('.addIcon').show();
                            }
                        }
                    });
                } else {
                    alert('username already exist');
                }
            });
            $(document).on('click', '.btn', function(e) {
                if (!event.target.classList.contains("account-delete-icon")) {
                    window.location.href = "{{ route('home') }}";
                }
            });

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
