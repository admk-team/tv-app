<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        let URL = "{{ route('register') }}";

        // Click event for the first form
        $('#submit').click(function(event) {
            event.preventDefault();
            getStarted('#form');
        });

        // Click event for the second form
        $('#submit1').click(function(event) {
            event.preventDefault();
            getStarted('#form1');
        });

        function getStarted(formId) {
            let form = $(formId);
            let emailInput = form.find('input[name="email"]');
            let errorSpan = form.find('.email-error');
            // Custom email validation
            let email = emailInput.val();

            if (!isValidEmail(email)) {
                errorSpan.text('Please enter a valid email address.');
                return;
            } else {
                errorSpan.text(''); // Clear error message if email is valid
            }

            // Serialize the form data
            let formData = form.serialize();

            // Create a hidden link with the desired URL and form data
            let hiddenLink = $('<a>', {
                href: URL + '?' + formData,
                target: '_self',
                style: 'display:none'
            });

            // Append the link to the body and trigger a click
            $('body').append(hiddenLink);
            hiddenLink[0].click();

            // Remove the link after clicking
            hiddenLink.remove();
        }

        // Custom function to validate email format
        function isValidEmail(email) {
            // Regular expression for email validation
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    });
</script>