<?php 
session_start();
if(empty($_SESSION['id'])):
    header('Location:../index.php');
    endif;

if($_POST)
{
    include('../dist/includes/dbcon.php');

    $start = $_POST['start'];
    $end = $_POST['end'];
    $day = $_POST['day'];
    
    // Query to check if time and day already exist
    $query = mysqli_query($con,"SELECT * FROM time WHERE time_start='$start' AND time_end='$end' AND days='$day'")or die(mysqli_error($con));
        
    $count = mysqli_num_rows($query);

    if ($count > 0)
    {
        echo "<script type='text/javascript'>alert('Time already added!');</script>";    
        echo "<script>document.location='time.php'</script>"; 
    }
    else
    {   
        // Insert the new time and day schedule
        mysqli_query($con, "INSERT INTO time(time_start, time_end, days) 
                    VALUES('$start', '$end', '$day')") or die(mysqli_error($con));
                    
        echo "<script type='text/javascript'>alert('Successfully added time!');</script>";    
        echo "<script>document.location='time.php'</script>";  
    }
}
?>  
