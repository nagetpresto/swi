<?php 
session_start(); 
include "connect.php";

if ( isset($_POST["login"])){

	$username = $_POST['username'];
	$password = $_POST['password'];
    //$name = $_POST['name'];
    //$position = $_POST['position'];

       // mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password ='$password'");
        //return mysqli_affected_rows($conn);

		$sql = "SELECT * FROM user_accounts WHERE username='$username' AND password ='$password'";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['position'] === 'Admin') {
            	//$_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
            	//$_SESSION['id'] = $row['id'];
            	header("Location: qc-reject-material.php");
		        exit();}

            else if ($row['position'] === 'QCS') {
            	//$_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
            	//$_SESSION['id'] = $row['id'];
            	header("Location: qc-reject-material.php");
		        exit();}

            else if ($row['position'] === 'PRDS') {
            	//$_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
            	//$_SESSION['id'] = $row['id'];
            	header("Location: qc-reject-material.php");
		        exit();}

            else if ($row['position'] === 'Master') {
            	//$_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
            	//$_SESSION['id'] = $row['id'];
            	header("Location: qc-reject-material.php");
		        exit();                    
            }else{
                echo "<script>
                alert('Incorect Username or Password!');
                document.location.href = 'index.html';
                </script>";	
                exit();
			}
		}else{
            echo "<script>
            alert('Incorect Username or Password!');
            document.location.href = 'index.html';
            </script>";	
            exit();
		}
	
	
}else{
	echo "<script>
    alert('Error!');
    document.location.href = 'index.html';
    </script>";	
    exit();
}
