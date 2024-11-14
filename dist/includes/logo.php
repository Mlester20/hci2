<?php session_start();
 if (empty($_SESSION['id'])):
	 header('Location:../index.php');
 endif; 
?>

<img src="../images/isu-logo.png" width="60px" height="60px" class="logo">
<img src="../images/isu-logo.png" width="60px" height="60px" class="logo2" style="display:hidden">
        <h5 align="center">
            Isabela State University</br>
            Roxas, Isabela</br><br><br>
            CLASS <?php echo strtoupper($rows['term']); ?> EXAM SCHEDULE</br>
        </h5>
