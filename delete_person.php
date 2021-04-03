<?php
session_start();
if (!isset($_SESSION['username'])){
    header("Location: login.php");
}


// check if value was posted
if($_POST){
  
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/persons.php';
  
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
  
    // prepare product object
    $person = new Person($db);
      
    // set product id to be deleted
    $person->id = $_POST['object_id'];
      
    // delete the product
    if($person->delete()){
        echo "Person was deleted.";
    }
      
    // if unable to delete the product
    else{
        echo "Unable to delete object.";
    }
}
?>