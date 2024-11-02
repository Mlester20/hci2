<?php
session_start();
if (empty($_SESSION['id'])):
	header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');

$id = $_SESSION['id'];
$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$old = $_POST['passwordold'];
$new = $_POST['new'];

// Split the full name into first and last names
$name_parts = explode(" ", $name);
$first_name = $name_parts[0]; // Assuming first name is the first part
$last_name = isset($name_parts[1]) ? $name_parts[1] : ''; // Assuming last name is the second part

if ($new <> $password) {
	echo "<script type='text/javascript'>alert('Password mismatch!');</script>";
	echo "<script>document.location='profile.php'</script>";
} else {
	$query = mysqli_query($con, "SELECT password FROM member WHERE member_id='$id'") or die(mysqli_error($con));
	$row = mysqli_fetch_array($query);

	$passold = $row['password'];

	if ($passold == $old) {
		$update_query = "UPDATE member SET username='$username', member_first='$first_name', member_last='$last_name'";

		// Add password update if not empty
		if ($password <> "") {
			$update_query .= ", password='$password'";
		}

		$update_query .= " WHERE member_id='$id'";

		mysqli_query($con, $update_query) or die(mysqli_error($con));

		echo "<script type='text/javascript'>alert('Successfully updated profile details!');</script>";
		echo "<script>document.location='profile.php'</script>";
	} else {
		echo "<script type='text/javascript'>alert('Old Password is incorrect!');</script>";
		echo "<script>document.location='profile.php'</script>";
	}
}
