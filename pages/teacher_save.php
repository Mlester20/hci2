<?php 
session_start();
if(empty($_SESSION['id'])):
    header('Location:../index.php');
    exit();
endif;

include('../dist/includes/dbcon.php');

$salut = $_POST['salut'];    
$last = $_POST['last'];    
$first = $_POST['first'];    
$rank = $_POST['rank'];    
$dept = $_POST['dept'];    
$designation = $_POST['designation'];    
$username = preg_replace('/\s+/','', $first);  // Remove dept from username
$username = strtolower($username);
$password = preg_replace('/\s+/','', $last);
$password = strtolower($password);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Encrypt the password
$status = $_POST['status'];    
                
$query = mysqli_query($con, "SELECT * FROM member WHERE member_last='$last' AND member_first='$first'") or die(mysqli_error($con));
$count = mysqli_num_rows($query);

if ($count > 0) {
    echo "<script type='text/javascript'>alert('Member already exists');</script>";
    echo "<script>document.location='teacher.php'</script>";  
} else {
    mysqli_query($con, "INSERT INTO member (member_salut, member_last, member_first, member_rank, dept_code, designation_id, username, password, status) 
    VALUES ('$salut', '$last', '$first', '$rank', '$dept', '$designation', '$username', '$hashed_password', '$status')") or die(mysqli_error($con));
    
    echo "<script type='text/javascript'>alert('Successfully added new member');</script>";    
    echo "<script>document.location='teacher.php'</script>";  
}
?>
