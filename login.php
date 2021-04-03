<?php
// ini_set("display_errors", 1);
// error_reporting(E_ALL);
// error reporting(0);
session_start();
//print_r($_SESSION);
// exit();

include_once 'config/database.php';

$errMsg=''; // initialize message to display on HTML form
    if (isset($_POST['login'])
        && !empty($_POST['username'])
        && !empty($_POST['password'])) {
            
        $_POST['username'] = htmlspecialchars($_POST['username']);
        $_POST['password'] = htmlspecialchars($_POST['password']);

        if ($_POST['username'] == 'admin@admin.com'
            && $_POST['password'] == 'admin') {

            $_SESSION['username']='admin@admin.com';

             header("Location: index.php");

        } else {
            
            $database = new Database();
            $db = $database->getConnection();
            $sql = "SELECT * FROM persons "
                . " WHERE username=? "
                . " AND password=? "
                . " LIMIT 1"
                ;
            
            $query=$db->prepare($sql);
            $query->execute(Array($_POST['username'], $_POST['password']));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if ($result){
                $_SESSION['username'] = $result['username'];
                header('Location: display_list.php');
            }
            else{
                $errMsg='Login failure: wrong username or password';
            }
            
            
        }
}
?>

<!DOCTYPE html>
<html lang-"en-US">
        <head>
            <title>Crud Applet with login</title>
            <meta charset-"utf-8" />
        </head>
        
        <body>
            <h1>Crud Applet with Login</h1>
            <h2>Login</h2>
            
            <form action="" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <p style="color: red;"><?php echo $errMsg; ?></p>
                <tr>
                    <td><input type="text" class="form-control"
                    name="username" placeholder="admin@admin.com"
                    required autofocus /> </td>
                </tr>
                <tr>
                    <td><input type="password" class="form-control"
                    name="password" placeholder="admin" required /></td>
                </tr>
                <tr>
                   <td> <button class="btn btn-lg btn-primary btn-block"
                        type="submit" name="login">Login</button></td>
                </tr>
            </table>
            </form>
        </body>
</html>