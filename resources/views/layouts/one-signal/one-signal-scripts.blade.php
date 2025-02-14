    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        var oneSignalAppId;
        const oneSignalWorkerPath = "{{ asset('onesignal/OneSignalSDKWorker.js') }}";
        var oneSignalAppId =
            '{{ isset(\App\Services\AppConfig::get()->app->colors_assets_for_branding->one_signal_app_id) ? \App\Services\AppConfig::get()->app->colors_assets_for_branding->one_signal_app_id : '' }}';

        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register(oneSignalWorkerPath).then(
                (registration) => {
                    // console.log("Service worker registration succeeded:", registration);
                },
                (error) => {
                    // console.error(`Service worker registration failed: ${error}`);
                },
            );
        } else {
            console.error("Service workers are not supported.");
        }
        // Initialize OneSignal
        window.OneSignalDeferred = window.OneSignalDeferred || [];

        OneSignalDeferred.push(async function(OneSignal) {
            await OneSignal.init({
                appId: oneSignalAppId,
                autoRegister: false,
                serviceWorkerParam: {
                    scope: '/onesignal/',
                },
                serviceWorkerPath: oneSignalWorkerPath,
                allowLocalhostAsSecureOrigin: true,
                notifyButton: {
                    enable: false
                }
            });
            $('.onesignal-customlink-container').on('click', function(e) {
                setTimeout(async function() {
                    let subscriptionId = OneSignal.User.PushSubscription._id;
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('toggle.subscribe') }}",
                        method: "POST",
                        data: {
                            player_id: subscriptionId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // console.log(response);
                            // $('#subscribe-icon').toggleClass('fa-bell fa-bell-slash');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error toggling subscription:', xhr
                                .responseText);
                        },
                    });
                }, 10000); //  10-second delay to get the subscription id
            });
        });
    </script>
