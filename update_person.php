<?php
session_start();
if (!isset($_SESSION['username'])){
    header("Location: login.php");
}




// retrieve one product will be here
// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once 'config/database.php';
include_once 'objects/persons.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$person = new Person($db);
  
// set ID property of product to be edited
$person->id = $id;
  
// read the details of product to be edited
$person->readOne();
  
// set page header
$page_title = "Update Person";
include_once "layout_header.php";
  
// contents will be here
echo "<div class='right-button-margin'>
          <a href='index.php' class='btn btn-default pull-right'>Read Products</a>
     </div>";
  
?>
<!-- post code will be here -->
<?php 
// if the form was submitted
if($_POST){
  
    // set product property values
    $person->role = $_POST['role'];
    $person->fname = $_POST['fname'];
    $person->lname = $_POST['lname'];
    $person->email = $_POST['email'];
    $person->phone = $_POST['phone'];
    $salt = MD5(microtime(true));
    $person->password_hash = MD5($_POST['password'] . $salt);
    $person->password_salt = $salt;
    $person->address = $_POST['address'];
    $person->address2 = $_POST['address2'];
    $person->city = $_POST['city'];
    $person->state = $_POST['state'];
    $person->zip_code = $_POST['zip_code'];

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip_code'];
    
    if ($_POST['fname'] == "" || $_POST['lname'] == "" || $_POST['email'] == "" || $_POST['phone'] == "" ||
    $_POST['password'] == "" || $_POST['address'] == "" || $_POST['city'] == "" || $_POST['state'] == "" || $_POST['zip_code'] == "" ||
    strlen($_POST['password']) < 16 || strpos($_POST['email'], "@") == false){

        if ($_POST['fname'] == ""){
            $_POST['fname'] = "First";
            $fname = $_POST['fname'];
        }
        if ($_POST['lname'] == ""){
            $_POST['lname'] = "Last";
            $lname = $_POST['lname'];
        }
        if ($_POST['email'] == "" || strpos($_POST['email'], "@") == false){
            $_POST['email'] = "Someone@something.com";
            $email = $_POST['email'];
        }
        if ($_POST['phone'] == ""){
            $_POST['phone'] = "###-###-####";
            $phone = $_POST['phone'];
        }

        if (strlen($_POST['password']) < 16){
            $_POST['password'] = "****************";
            $password = $_POST['password'];
        }
        
        if ($_POST['address'] == ""){
            $_POST['address'] = "### N Somewhere St.";
            $address = $_POST['address'];
        }
        if ($_POST['city'] == ""){
            $_POST['city'] = "Saginaw";
            $city = $_POST['city'];
        }
        if ($_POST['state'] == ""){
            $_POST['state'] = "Michigan";
            $state = $_POST['state'];
        }
        if ($_POST['zip_code'] == ""){
            $_POST['zip_code'] = "12345";
            $zip = $_POST['zip_code'];
        }
    }
    else{
        // update the product
        if($person->update()){
            echo "<div class='alert alert-success alert-dismissable'>";
                echo "Person was updated.";
            echo "</div>";
        }
  
        // if unable to update the product, tell the user
        else{
            echo "<div class='alert alert-danger alert-dismissable'>";
                echo "Unable to update person.";
            echo "</div>";
        }

    }
    
}
?>
  
<!-- 'update product' form will be here -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
  
    <tr>
            <td>Role</td>
            <!--<input type='text' name='role' class='form-control' />-->
        
            <td>
                <select name = 'role'>
                    <option value='admin'>Admin</option>
                    <option value='user' selected>User</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>First Name</td>
            <td><input type='text' name='fname' value= "<?php echo (isset($fname))?$fname:''; ?>" class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Last Name</td>
            <td><input type='text' name='lname' value= "<?php echo (isset($lname))?$lname:''; ?>"class='form-control' /></td>
        </tr>

        <tr>
            <td>Email</td>
            <td><input type='text' name='email' value= "<?php echo (isset($email))?$email:''; ?>"class='form-control' /></td>
        </tr>

        <tr>
            <td>Phone</td>
            <td><input type='text' name='phone' value= "<?php echo (isset($phone))?$phone:''; ?>"class='form-control' /></td>
        </tr>

        <tr>
            <td>Password</td>
            <td><input type='password' name='password' value= "<?php echo (isset($password))?$password:''; ?>"class='form-control' /></td>
        </tr>
        <!--<tr>
            <td>Password Hash</td>
            <td><input type='text' name='password_hash' class='form-control' /></td>
        </tr>

        <tr>
            <td>Password Salt</td>
            <td><input type='text' name='password_salt' class='form-control' /></td>
        </tr>-->

        <tr>
            <td>Address</td>
            <td><input type='text' name='address' value= "<?php echo (isset($address))?$address:''; ?>"class='form-control' /></td>
        </tr>

        <tr>
            <td>Address2</td>
            <td><input type='text' name='address2' value = "Optional" class='form-control' /></td>
        </tr>

        <tr>
            <td>City</td>
            <td><input type='text' name='city' value= "<?php echo (isset($city))?$city:''; ?>"class='form-control' /></td>
        </tr>

        <tr>
            <td>State</td>
            <td><input type='text' name='state' value= "<?php echo (isset($state))?$state:''; ?>"class='form-control' /></td>
        </tr>

        <tr>
            <td>Zip Code</td>
            <td><input type='text' name='zip_code' value= "<?php echo (isset($zip))?$zip:''; ?>"class='form-control' /></td>
        </tr>
  
        <tr>
            
                <!-- categories select drop-down will be here -->
				<?php
//$stmt = $category->read();
  
// put them in a select drop-down
/*echo "<select class='form-control' name='category_id'>";
  
    echo "<option>Please select...</option>";
    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
        $category_id=$row_category['id'];
        $category_name = $row_category['name'];
  
        // current category of the product must be selected
        if($product->category_id==$category_id){
            echo "<option value='$category_id' selected>";
        }else{
            echo "<option value='$category_id'>";
        }
  
        echo "$category_name</option>";
    }
echo "</select>";*/
?>
        
  
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
  
    </table>
</form>
  
// set page footer
<?php
include_once "layout_footer.php";
?>