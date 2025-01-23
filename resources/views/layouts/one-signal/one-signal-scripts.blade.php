    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        const oneSignalWorkerPath = "{{ asset('onesignal/OneSignalSDKWorker.js') }}";

        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register(oneSignalWorkerPath).then(
                (registration) => {
                    console.log("Service worker registration succeeded:", registration);
                },
                (error) => {
                    console.error(`Service worker registration failed: ${error}`);
                },
            );
        } else {
            console.error("Service workers are not supported.");
        }

        // Initialize OneSignal
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        OneSignalDeferred.push(async function(OneSignal) {
            await OneSignal.init({
                appId: "{{ config('services.onesignal.app_id') }}",
                autoRegister: false,
                serviceWorkerParam: {
                    scope: '/onesignal/',
                },
                serviceWorkerPath: oneSignalWorkerPath,
                allowLocalhostAsSecureOrigin: true,
                notifyButton: {
                    enable: true
                }
            });
            OneSignal.Notifications.requestPermission(true);
            let permission = OneSignal.Notifications.permission;
            let subscriptionId = OneSignal.User.PushSubscription.id;
            var onesignalId = OneSignal.User.onesignalId;
            console.log("OneSignal Init");
            console.log("subscriptionId: ", subscriptionId);
            console.log("onesignalId: " + onesignalId);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
            // Check notfication status
            $.ajax({
                url: "{{ route('check.subscription.status') }}",
                method: "GET",
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        if (response.subscribed) {
                            $('#subscribe-icon').removeClass('fa-bell').addClass(
                                'fa-bell-slash');
                            $('#subscribe-text').text('Unsubscribe');
                        } else {
                            $('#subscribe-icon').removeClass('fa-bell-slash').addClass(
                                'fa-bell');
                            $('#subscribe-text').text('Subscribe');
                        }
                    } else {
                        console.error('Subscription check failed:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking subscription status:', xhr
                        .responseText);
                },
            });
            //toggle notification
            $('#subscribe-form-toggle').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('toggle.subscribe') }}",
                    method: "POST",
                    data: {
                        player_id: subscriptionId,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('#subscribe-icon').toggleClass('fa-bell fa-bell-slash');
                            $('#subscribe-text').text(response.subscribed ? 'Unsubscribe' :
                                'Subscribe');
                        } else {
                            console.error('Subscription toggle failed:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error toggling subscription:', xhr.responseText);
                    },
                });
            });

        });
    </script>
