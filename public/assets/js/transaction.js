$(document).ready(function () {
    $('#cancelSub').on('click', function (e) {
        e.preventDefault();

        var myModalEl = document.getElementById('cancelSubModal');
        var myModal = bootstrap.Modal.getInstance(myModalEl);
        if (myModal) {
            myModal.hide();
        }

        let subId = $('#subId').val(); 

        $.ajax({
            url: '/cancelsubscription/' + subId,
            method: 'get',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                Swal.fire(
                    'Cancelled!',
                    'Your subscription has been cancelled.',
                    'success'
                ).then(() => {
                    window.location.reload();
                });
            },
            error: function (xhr) {
                Swal.fire(
                    'Error!',
                    'Something went wrong. Please try again.',
                    'error'
                );
            }
        });

    });
});

$(document).on('click','#openCancelModal',function(){

    var subid = $(this).data('id');

   var myModal = new bootstrap.Modal(document.getElementById('cancelSubModal'));
    myModal.show();


    $('#subId').val(subid);
})

$(document).on('click', '#pauseSub', function () {

    let subId = $('#subId').val(); 

    Swal.fire({
        title: 'Pause Your Subscription?',
        html: "Need a break? You can pause your subscription and come back anytime.<br><br><strong>Select how long you'd like to pause:</strong>",
        icon: 'info',
        showCancelButton: false,
        showConfirmButton: false,
        footer: `
            <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
                <button data-days="30" class="pause-btn app-primary-btn rounded mx-1">Pause for 30 Days</button>
                <button data-days="60" class="pause-btn app-primary-btn rounded mx-1">Pause for 60 Days</button>
                <button data-days="90" class="pause-btn app-primary-btn rounded mx-1">Pause for 90 Days</button>
            </div>
        `,
    });

    $(document).off('click', '.pause-btn').on('click', '.pause-btn', function () {
        const days = $(this).data('days');
        Swal.close();
        hideModal();
        $.ajax({
            url: '/pause-subscription',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                days: days,
                subscription_id: subId
            },
            success: function (res) {
                window.location.reload();
                Swal.fire('Paused!', `${res.message} for ${res.paused_for_days} days.`, 'success');
            },
            error: function () {
                Swal.fire('Error', 'Something went wrong while pausing your subscription.', 'error');
            }
        });
    });

    function hideModal() {
        const myModalEl = document.getElementById('cancelSubModal');
        const myModal = bootstrap.Modal.getInstance(myModalEl);
        if (myModal) {
            myModal.hide();
        }
    }
});


