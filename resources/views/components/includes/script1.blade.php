<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>

<script>
    $(document).ready(function() {
        let previewStreamUrl = "{{ route('register') }}";

        $('#submit').click(function(event) {
            event.preventDefault(); // Prevent the default behavior of the button

            // Custom email validation
            let email = $('#email').val();
            let errorSpan = $('.email-error');

            if (!isValidEmail(email)) {
                errorSpan.text('Please enter a valid email address.');
                return;
            } else {
                errorSpan.text(''); // Clear error message if email is valid
            }
            // Create a hidden link with the desired URL and form data
            let hiddenLink = $('<a>', {
                href: previewStreamUrl + '?' + 'email=' + email,
                target: '_self',
                style: 'display:none'
            });

            // Append the link to the body and trigger a click
            $('body').append(hiddenLink);
            hiddenLink[0].click();

            // Remove the link after clicking
            hiddenLink.remove();
        });

        // Custom function to validate email format
        function isValidEmail(email) {
            // Regular expression for email validation
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    });
</script>