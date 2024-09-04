<?php
include_once 'connection.php';

$id = $_POST['data_id'] ?? '';
$Employee = $_POST['Employee'] ?? '';
$Gender = $_POST['Gender'] ?? '';
$Address = $_POST['Address'] ?? '';
$Contact = $_POST['Contact'] ?? '';
$Salary = $_POST['Salary'] ?? '';
$JoinDate = $_POST['JoinDate'] ?? '';
$EndDate = $_POST['EndDate'] ?? '';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$newpassword = $_POST['newpassword'] ?? '';

if ($password != $newpassword) {
    header('Location: ../staff.php?type=error&message=Password does not match!');
    exit();
}

$sql = "UPDATE users SET
    username = :username,
    Employee = :Employee,
    Gender = :Gender,
    Address = :Address,
    Contact = :Contact,
    Salary = :Salary,
    JoinDate = :JoinDate,
    EndDate = :EndDate,
    password = :password
    WHERE id = :id";

$statement = $db->prepare($sql);
$statement->bindParam(':username', $username);
$statement->bindParam(':Employee', $Employee);
$statement->bindParam(':Gender', $Gender);
$statement->bindParam(':Address', $Address);
$statement->bindParam(':Contact', $Contact);
$statement->bindParam(':Salary', $Salary);
$statement->bindParam(':JoinDate', $JoinDate);
$statement->bindParam(':EndDate', $EndDate);
$statement->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
$statement->bindParam(':id', $id);
$statement->execute();

generate_logs('Update Staff', $username . ' | Staff was updated');
header('Location: ../staff.php?type=success&message=Staff updated successfully!');
exit();
?>