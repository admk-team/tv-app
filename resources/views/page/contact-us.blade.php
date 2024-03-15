@extends('layouts.app')

@section('content')
    <section class="credential_form signForm">

        <form name="contact_frm" id="contact_frm" method="POST" action="{{ route('contactus.submit') }}"
            onsubmit="return validation(1, {&quot;name&quot;:{&quot;type&quot;:&quot;text&quot;,&quot;msg&quot;:&quot;Name&quot;,&quot;min&quot;:{&quot;length&quot;:1,&quot;msg&quot;:&quot;1 char&quot;},&quot;max&quot;:{&quot;length&quot;:250,&quot;msg&quot;:&quot;250 chars&quot;}},&quot;email&quot;:{&quot;type&quot;:&quot;email&quot;,&quot;msg&quot;:&quot;Email&quot;,&quot;min&quot;:{&quot;length&quot;:1,&quot;msg&quot;:&quot;1 char&quot;},&quot;max&quot;:{&quot;length&quot;:255,&quot;msg&quot;:&quot;255 chars&quot;}},&quot;message&quot;:{&quot;type&quot;:&quot;textarea&quot;,&quot;msg&quot;:&quot;Message&quot;,&quot;min&quot;:{&quot;length&quot;:1,&quot;msg&quot;:&quot;1 char&quot;},&quot;max&quot;:{&quot;length&quot;:456,&quot;msg&quot;:&quot;456 chars&quot;}}});">
            @csrf
            <div class="login_page main_pg inner-cred">
                <h4>Contact Us</h4>
                <center>
                    <p style="color:red"></p>

                </center>
                <div class="cred_form">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                            <strong>Success!</strong> {{ $message }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-5 ind1">
                            <div class="inner-div dv1 text-white text-center">
                                <h3>Contact Us / Need Help?</h3>
                                <br><br>
                                <p>Do you have any questions? Do you need technical assistance? Please do not hesitate to
                                    contact us directly. Our team will get back to you within a matter of hours to help!</p>

                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="inner-div dv2">
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input id="name" type="text" class="form-control " placeholder="Name"
                                            name="name" autocomplete="name" autofocus="">
                                        <img src="https://stage.24flix.tv/images/ussr.png" class="icn mll">
                                    </label>
                                    <span class="error_box" id="span_name"></span>
                                </div>
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input id="email" type="email" class="form-control " placeholder="Email"
                                            name="email" autocomplete="email" autofocus="">
                                        <img src="https://stage.24flix.tv/images/mail.png" class="icn mll">
                                    </label>
                                    <span class="error_box" id="span_email"></span>
                                </div>
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input id="mobile" type="text" class="form-control " placeholder="Mobile No."
                                            name="mobile" autocomplete="mobile" autofocus="">
                                        <img src="https://stage.24flix.tv/images/mobs.png" class="icn mll">
                                    </label>
                                    <span class="error_box" id="span_mobile"></span>
                                </div>
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <textarea id="message" class="form-control" placeholder="Message" name="message" autocomplete="message"
                                            autofocus=""></textarea>
                                        <img src="https://stage.24flix.tv/images/msgs.png" class="icn mll">
                                    </label>
                                    <span class="error_box" id="span_message"></span>
                                </div>
                                <div class="form-group mt-2">
                                    <button type="button" class="btn" onclick="handleFormSubmit()">SEND</button>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="frmToken" value="dea1a05ad6f68a3f2f87080923519b1c">
                                    <input type="hidden" name="requestAction" value="sendInquiry">
                                    <input type="hidden" name="headerRedirectUrl"
                                        value="https://stage.24flix.tv/page/contact-us">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>
@endsection


@push('scripts')
    <script>
        function validation() {}

        function handleFormSubmit() {
            let form = $("#contact_frm");
            let formData = new FormData(form[0]);
            let didValidate = true;

            if (formData.get('name') == '') {
                didValidate = false;
                $("#span_name").html('Please enter Name');
            } else {
                $("#span_name").html('');
            }

            if (formData.get('email') == '') {
                didValidate = false;
                $("#span_email").html('Please enter email');
            } else {
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailRegex.test(formData.get('email'))) {
                    didValidate = false;
                    $("#span_email").html('Please enter a valid email address');
                } else {
                    $("#span_email").html('');
                }
            }

            if (formData.get('message') == '') {
                didValidate = false;
                $("#span_message").html('Please enter message');
            } else {
                $("#span_message").html('');
            }

            if (didValidate)
                $("#contact_frm").submit();
        }
    </script>
@endpush
