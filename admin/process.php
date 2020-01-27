<?php 
    include("../functions.php");

        //checking username and password input
        if (isset($_POST['username']) && isset($_POST['password'])) {

            //prevent sql injection by escaping special characters
            $username = $sqlconnection->real_escape_string($_POST['username']);
            $password = $sqlconnection->real_escape_string($_POST['password']);

            //sql statement
            $sql = "SELECT * FROM tbl_admin WHERE username ='$username' AND password = '$password'";

            if ($result = $sqlconnection->query($sql)) {

                if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    
                    $uid = $row['ID'];
                    $username = $row['username'];

                    $_SESSION['uid'] = $uid;
                    $_SESSION['username'] = $username;
                    $_SESSION['user_level'] = "admin";

                    echo "correct";
                }

                else {
                    echo "Wrong username or password.";
                }

            }

        }
      
?>