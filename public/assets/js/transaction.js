$(document).ready(function () {

    let cancelInfo = {};

    // Show cancel modal and store subscription ID
    $(document).on('click', '#openCancelModal', function () {

        $(document).on('click', '#openCancelModal', function () {
            const subId = $(this).data('id');

            cancelInfo = {
                subId: subId,
                planName: $(this).data('plan-name'),
                discount: $(this).data('discount'),
                planPeriod: $(this).data('plan-period'),
                discountDuration: $(this).data('discount-duration'),
                discountStatus: $(this).data('discount-status'),
            };

            $('#subId').val(subId);
            const myModal = new bootstrap.Modal(document.getElementById('cancelSubModal'));
            myModal.show();
        });
    });

    // Pause Subscription Button inside Modal
    $(document).on('click', '#pauseSub', function () {
        const subId = $('#subId').val();
        showPauseOptions(subId);
    });

    // Cancel Subscription Button inside Modal
    $(document).on('click', '#cancelSub', function (e) {
        e.preventDefault();
        const subId = $('#subId').val();
        showPauseOptions(subId, true);
    });

    // Handle pause button click (30, 60, 90 days)
    $(document).on('click', '.pause-btn', function () {
        const days = $(this).data('days');
        const subId = $(this).closest('.swal2-popup').find('#continueCancelSub').data('id') || $('#subId').val();

        Swal.close();
        hideCancelModal();

        $.ajax({
            url: '/pause-subscription',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                days: days,
                subscription_id: subId
            },
            success: function (res) {
                Swal.fire('Paused!', `${res.message} for ${res.paused_for_days} days.`, 'success').then(() => {
                    window.location.reload();
                });
            },
            error: function () {
                Swal.fire('Error', 'Something went wrong while pausing your subscription.', 'error');
            }
        });
    });

    // Handle final cancel button inside SweetAlert
    $(document).on('click', '#continueCancelSub', function () {
        const subId = $(this).data('id');

        if (cancelInfo.discountStatus == 0) {
            Swal.fire({
                title: '<span style="font-family:\'Segoe UI\', sans-serif; font-weight:bold; font-size: 24px; color:#2d3436;">Before You Go…</span>',
                html: `
                    <div style="text-align: left; font-family: 'Segoe UI', sans-serif; font-size: 16px;">
                        <p style="font-size: 17px; line-height: 1.6; color: #2d3436;">
                            Thank you for being a part of our journey. <br><br>
                            Every step you took with us has meant the world, and we’re truly grateful for your time, trust, and presence.
                            <br>
                            Before you go, we’d love to offer you a special discount — not just as a thank you, but as a gentle nudge to stay a little longer with us.
                        </p>
                        <hr style="margin: 15px 0;">
                         <p><strong style="color:#00b894;">Plan:</strong> ${cancelInfo.planName}</p>
                        <p><strong style="color:#00b894;">Discount:</strong> ${cancelInfo.discount || 0}% OFF</p>
                        <p><strong style="color:#00b894;">Valid For:</strong> ${cancelInfo.discountDuration || 0} month(s)</p>
                        <hr style="margin: 15px 0;">
                        <p style="margin-top: 15px; font-weight: bold; color: #0984e3;">
                            You’re more than just a user — you’re a part of our story.
                        </p>                    
                    </div>

                `,
                icon: 'info',
                showCancelButton: true,
                focusCancel: true,
                cancelButtonText: 'Apply Discount & Stay',
                confirmButtonText: 'No Thanks, Cancel Anyway',
                customClass: {
                    confirmButton: 'bg-danger rounded mx-1',
                    cancelButton: 'app-primary-btn rounded mx-1'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    cancelSubscription(subId);
                    hideCancelModal()
                } else if (result.dismiss === Swal.DismissReason.cancel) {

                    const formData = {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        subscription_id: cancelInfo.subId,
                        discount: cancelInfo.discount,
                        duration: cancelInfo.discountDuration,
                        period: cancelInfo.planPeriod
                    };

                    $.ajax({
                        url: '/offer/disscount',
                        method: 'POST',
                        data: formData,
                        success: function (res) {
                            hideCancelModal()
                            Swal.fire(res.message).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire('Error!', 'Something went wrong. Please try again later.', 'error');
                        }
                    });

                }
            });
        } else {
            Swal.fire({
                title: '<span style="font-family:Segoe UI, sans-serif; font-weight:bold; font-size: 24px;">Leaving So Soon? </span>',
                html: `
                <div style="text-align: left; font-family: 'Segoe UI', sans-serif; font-size: 16px;">
                    <p><strong style="color:#00b894;">Plan:</strong> ${cancelInfo.planName}</p>
                    <hr style="margin: 15px 0;">
                    <p style="font-size: 17px; line-height: 1.5; color: #333;">
                        We’re really sad to see you go. <br><br>
                        If there’s anything we can improve, we’d love to hear from you.
                        <br>
                        Your feedback helps us grow. 
                    </p>
                    <p style="margin-top: 10px; font-weight: bold; color: #2d3436;">Hope to see you again soon!</p>
                </div>
            `,
                icon: 'warning',
                showCancelButton: false,
                confirmButtonText: 'Yes, Cancel',
                customClass: {
                    confirmButton: 'app-primary-btn rounded mx-1',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    cancelSubscription(subId);
                    hideCancelModal()
                }
            });
        }
    });


    // Reusable function to cancel subscription
    function cancelSubscription(subId) {
        $.ajax({
            url: '/cancelsubscription/' + subId,
            method: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                Swal.fire('Cancelled!', 'Your subscription has been successfully cancelled.', 'success').then(() => {
                    window.location.reload();
                });
            },
            error: function () {
                Swal.fire('Error!', 'Something went wrong. Please try again later.', 'error');
            }
        });
    }


    // Utility: Hide Bootstrap modal
    function hideCancelModal() {
        const modalEl = document.getElementById('cancelSubModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // Utility: Show SweetAlert for Pause Options
    function showPauseOptions(subId, showCancelBtn = false) {
        const cancelButton = showCancelBtn
            ? `<div class="col-md-4 mt-3" style="margin-left:25%">
                    <button class="app-primary-btn rounded" id="continueCancelSub" data-id="${subId}">
                        Continue to cancel subscription
                    </button>
               </div>`
            : '';

        Swal.fire({
            title: 'Pause Your Subscription?',
            html: `
                Need a break? You can pause your subscription and come back anytime.<br><br>
                <strong>Select how long you'd like to pause:</strong>
            `,
            icon: 'info',
            showCancelButton: false,
            showConfirmButton: false,
            footer: `
                <div class="row">
                    <div class="col-md-4">
                        <button data-days="30" class="pause-btn app-primary-btn rounded">Pause for 30 Days</button>
                    </div>
                    <div class="col-md-4">
                        <button data-days="60" class="pause-btn app-primary-btn rounded">Pause for 60 Days</button>
                    </div>
                    <div class="col-md-4">
                        <button data-days="90" class="pause-btn app-primary-btn rounded">Pause for 90 Days</button>
                    </div>
                    ${cancelButton}
                </div>
            `
        });
    }
});
