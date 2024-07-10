<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .error {
      color: red;
    }

    .success {
      color: green;
    }

    form {
      width: 300px;
    }
  </style>
</head>

<body>
  <h2>Signin Form</h2>
  <form id="signinForm">
    <div>
      <label for="email" class="form-label">Email:</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div>
      <label for="password" class="form-label">Password:</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div>
      <button type="submit" class="btn btn-primary">Sign In</button>
    </div>
  </form>
  <div id="message"></div>

  <script>
    $(document).ready(function() {
      $('#signinForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
          url: 'signin_process.php',
          type: 'POST',
          // data contains the data to be sent to the server. 
          // $(this).serialize() serializes the form data into a query string format. 
          // It converts form data into a URL-encoded string, which is suitable for the POST request. 
          // For example, it might look like email=user@example.com&password=12345.
          // $(this) refers to the current form element that triggered the AJAX request.
          data: $(this).serialize(),
          // success is a callback function that executes when the AJAX request is completed successfully. 
          // It receives the server’s response as an argument.
          success: function(response) {
            // Parses the JSON string from the server response into a JavaScript object.
            // response is a JSON string returned by the server.
            var res = JSON.parse(response);
            if (res.status === 'success') {
              $('#message').html('<span class="success">' + res.message + '</span>');
            } else {
              $('#message').html('<span class="error">' + res.message + '</span>');
            }
          },
          // error is a callback function that executes if the AJAX request fails. 
          // It doesn’t receive the server response but handles any issues that occur during the request.
          error: function() {
            $('#message').html('<span class="error">An unexpected error occurred.</span>');
          }
        });
      });
    });
  </script>

</body>

</html>