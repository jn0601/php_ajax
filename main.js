// Jquery
$(document).ready(function() {
  function validatePhoneNumber() {
    // Get the input element using the id
    let input = document.getElementById('phone');
  
    // Remove non-numeric characters from the input
    let phoneNumber = input.value.replace(/\D/g, '');
  
    // Check if the phone number has exactly 10 digits
    if (phoneNumber.length === 10) {
      // Valid phone number
      input.setCustomValidity('');
    } else {
      // Invalid phone number, set a custom validation message
      input.setCustomValidity('Phone number must be 10 characters.');
    }
  }

  function validatePassword() {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm_password").value;

    if (password !== confirmPassword) {
      confirmPassword.setCustomValidity('Passwords do not match!');
    } else {
      confirmPassword.setCustomValidity('');
    }
}

  $('#signupForm').on('submit', function(event) {
    event.preventDefault();

    let formData = {
      name: $('#name').val(),
      email: $('#email').val(),
      phone: $('#phone').val(),
      password: $('#password').val(),
      confirm_password: $('#confirm_password').val()
    };

    $.ajax({
      url: 'signup_process.php',
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          $('#message').html('<span class="success">' + response.message + '</span>');
        } else {
          $('#message').html('<span class="error">' + response.message + '</span>');
        }
      }
    });
  });

});