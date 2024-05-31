jQuery(document).ready(function ($) {
    	$('#btn_form_devexhub').click(function(){
    		$('#Formmodal_devexhub').addClass('show');
    		$('#Formmodal_devexhub').show();
    	})
    	$('#close_btn_devexhub').click(function(){
    		$('#Formmodal_devexhub').removeClass('show');
    		$('#Formmodal_devexhub').hide();
    	})
        // AJAX for form submission
        $('#email-form').submit(function (e) {
            e.preventDefault();

            // Gather form data
            var formData = {
                'name': $('#name').val(),
                'email': $('#email').val(),
                'message': $('#message').val(),
                'action': 'send_email_ajax' // Action hook for WordPress AJAX
            };

            // AJAX request
            $.ajax({
                type: 'POST',
                url: ajaxurl, // WordPress AJAX URL
                data: formData,
                success: function (response) {
                    // Handle success
                    $('#name').val('');
                    $('#email').val('');
                    $('#message').val('');
                    $('#sent_message_success').css('display', 'block').fadeOut(3000); 
                    // alert('Email sent successfully!');
                },
                error: function (error) {
                    // Handle error
                    console.error('Error:', error);
                }
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        var labels = document.querySelectorAll('.devexhub-label');

        labels.forEach(function (label) {
            var radio = label.querySelector('input[type="radio"]');
            var imageContainer = label.querySelector('.image-container');

            if (imageContainer) {
                imageContainer.addEventListener('click', function () {
                    // Remove 'selected' class from all labels
                    labels.forEach(function (otherLabel) {
                        otherLabel.classList.remove('selected');
                    });

                    // Toggle the 'selected' class on the clicked label
                    label.classList.toggle('selected', !label.classList.contains('selected'));

                    // Check/uncheck the radio button
                    radio.checked = !radio.checked;
                });
            }
        });
    });