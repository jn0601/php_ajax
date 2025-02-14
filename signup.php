<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Form</title>
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
  <h2>Signup Form</h2>
  <form id="signupForm">
    <label for="name" class="form-label">Name:</label>
    <input type="text" class="form-control" id="name" name="name" required>
    <br>
    <label for="email" class="form-label">Email:</label>
    <input type="email" class="form-control" id="email" name="email" required>
    <br>
    <label for="phone" class="form-label">Phone Number:</label>
    <input type="text" class="form-control" id="phone" name="phone" maxlength="10" oninput="validatePhoneNumber()" required>
    <br>
    <label for="password" class="form-label">Password:</label>
    <input type="password" class="form-control" id="password" name="password" required>
    <br>
    <label for="confirm_password" class="form-label">Confirm Password:</label>
    <input type="password" class="form-control" id="confirm_password" name="confirm_password" oninput="validatePassword()" required>
    <br>
    <button type="submit" class="btn btn-primary">Sign Up</button>
  </form>
  <div id="message"></div>
  
  <script src="main.js"></script>
</body>

</html>