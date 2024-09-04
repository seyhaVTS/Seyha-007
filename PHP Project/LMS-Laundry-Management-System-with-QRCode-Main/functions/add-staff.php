<?php
include_once 'connection.php';

$Employee = $_POST['Employee'] ?? '';
$Gender = $_POST['Gender'] ?? '';
$Address = $_POST['Address'] ?? '';
$Contact = $_POST['Contact'] ?? '';
$Salary = $_POST['Salary'] ?? '';
$JoinDate = $_POST['JoinDate'] ?? '';
$EndDate = $_POST['EndDate'] ?? '';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$repassword = $_POST['re-password'] ?? '';

// Validate if all required fields are filled
if (empty($Employee) || empty($Gender) || empty($Address) || empty($Contact) || empty($Salary) || empty($JoinDate) || empty($EndDate) || empty($username) || empty($password) || empty($repassword)) {
    header('Location: ../staff.php?type=error&message=All fields are required');
    exit;
}

// Validate if passwords match
if ($password !== $repassword) {
    header('Location: ../staff.php?type=error&message=The two passwords do not match');
    exit;
}

// Check if username already exists
$sql = "SELECT COUNT(*) FROM users WHERE username = :username";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->execute();

if ($stmt->fetchColumn() > 0) {
    header('Location: ../staff.php?type=error&message=The username is already taken');
    exit;
}

// Hash the password securely
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user
$sql = "INSERT INTO users (username, password, Employee, Gender, Address, Contact, Salary, JoinDate, EndDate,level) VALUES (:username, :password, :Employee, :Gender, :Address, :Contact, :Salary, :JoinDate, :EndDate,1)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $passwordHash);
$stmt->bindParam(':Employee', $Employee);
$stmt->bindParam(':Gender', $Gender);
$stmt->bindParam(':Address', $Address);
$stmt->bindParam(':Contact', $Contact);
$stmt->bindParam(':Salary', $Salary);
$stmt->bindParam(':JoinDate', $JoinDate);
$stmt->bindParam(':EndDate', $EndDate);
$stmt->execute();

// Log the addition of a new staff member
generate_logs('Adding Staff', $username . ' | New Staff was added');

header('Location: ../staff.php?type=success&message=The user was added successfully');
exit;
?>