<?php
$response = array('success' => false, 'message' => '');
require 'db.php'; // Include the database connection file

// Validate inputs
function validate($data)
{
  // Validate email
  if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    return 'Valid email is required.';
  }

  // Validate password
  if (empty($data['password'])) {
    return 'Password is required.';
  }

  return '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = [
    'email' => $_POST['email'] ?? '',
    'password' => $_POST['password'] ?? '',
  ];

  $validationMessage = validate($data);

  if ($validationMessage !== '') {
    $response['message'] = $validationMessage;

    // Return response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
  } else {
    // Prepare and bind (prevent SQL Injection)
    // This line prepares an SQL statement for execution. The ? is a placeholder for a parameter that will be provided later.
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    // This line binds the actual value to the placeholder. 
    // The "s" indicates that the parameter is a string. 
    // $data['email'] is the value that will be bound to the placeholder ?.
    $stmt->bind_param("s", $data['email']);
    // This line executes the prepared statement with the bound parameters.
    $stmt->execute();
    // This line stores the result of the query so that you can check the number of rows returned.
    $stmt->store_result();

    // Checking if the Email Exists
    // This line checks if there are any rows returned from the query. 
    // If num_rows is greater than 0, it means the email exists in the database.
    if ($stmt->num_rows > 0) {
      // This line binds the result of the query to the variable $hashedPassword.
      $stmt->bind_result($hashedPassword);
      // This line fetches the result so that it can be used in the script.
      $stmt->fetch();

      if (password_verify($data['password'], $hashedPassword)) {
        echo json_encode(['status' => 'success', 'message' => 'Sign in successful.']);
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
      }
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
    }

    $stmt->close();
    $conn->close();
  }
}
