<?php
require 'db.php'; // Include the database connection file

// Validate inputs
function validate($data)
{
  if (empty($data['name'])) {
    return 'Name is required.';
  }
  if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    return 'Valid email is required.';
  }
  if (empty($data['phone']) || !preg_match('/^[0-9]{10,15}$/', $data['phone'])) {
    return 'Valid phone number is required.';
  }
  if (empty($data['password'])) {
    return 'Password is required.';
  }
  if (strlen($data['password']) < 6) {
    return 'Password must be at least 6 characters long.';
  }
  if (!preg_match('/[A-Z]/', $data['password'])) {
    return 'Password must contain at least one capitalized character.';
  }
  if (!preg_match('/[a-z]/', $data['password'])) {
    return 'Password must contain at least one lowercase character.';
  }
  if (!preg_match('/[_!@#$%^&*(),.?":{}|<>]/', $data['password'])) {
    return 'Password must contain at least one special character.';
  }
  if ($data['password'] !== $data['confirm_password']) {
    return 'Passwords do not match.';
  }

  return '';
}

// Simulate form submission process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = [
    'name' => $_POST['name'] ?? '',
    'email' => $_POST['email'] ?? '',
    'phone' => $_POST['phone'] ?? '',
    'password' => $_POST['password'] ?? '',
    'confirm_password' => $_POST['confirm_password'] ?? ''
  ];

  $validationMessage = validate($data);
  if ($validationMessage !== '') {
    $response['message'] = $validationMessage;

    // Return response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
  } else {
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $data['email']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
      $response['message'] = 'Email is already in use.';

      // Return response as JSON
      header('Content-Type: application/json');
      echo json_encode($response);
    } else {
      // Hash the password using bcrypt
      $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

      // Prepare and bind
      $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $data['name'], $data['email'], $data['phone'], $hashedPassword);

      if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Sign up successful.']);
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to sign up.']);
      }
    }

    $stmt->close();
    $conn->close();
  }
}
