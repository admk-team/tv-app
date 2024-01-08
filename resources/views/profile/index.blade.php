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
                usersProfiles = dataArray.data.map(item => item.name)
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
                // usersProfiles.reverse();
                usersProfiles.map((curElem) => {
                    memberDiv.insertAdjacentHTML('afterbegin', `
                <button class="btn"><span>${curElem}</span></button>
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
                        if (data.error) {
                            alert(data.error);
                        } else {
                            users.push(userName);
                            memberDiv.insertAdjacentHTML('afterbegin', `
                <button class="btn"><span>${userName}</span></button>
                `);
                            if (users.length >= 6) {
                                $('.addIcon').hide();
                            }
                        }
                    });
                } else {
                    alert('username already exist');
                }
            });
            $(document).on('click', '.btn', function() {
                // Your click event code here
                window.location.href = "{{ route('home') }}";
            });
        });
    </script>
@endpush
