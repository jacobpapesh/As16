<?php
session_start();
if (!isset($_SESSION['username'])){
    header("Location: login.php");
}


// include database and object files
include_once 'config/database.php';
include_once 'objects/persons.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$person = new Person($db);

// set page headers
$page_title = "Create Person";
include_once "layout_header.php";
  
// contents will be here
echo "<div class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-right'>Read Products</a>
    </div>";
  
?>

<!-- PHP post code will be here -->
<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
  
    // set person property values
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
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip_code'];
	
	/*$image=!empty($_FILES["image"]["name"])
        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]) : "";
	$product->image = $image;*/


    if (empty($_POST['fname']) || $_POST['lname'] == "" || $_POST['email'] == "" || $_POST['phone'] == "" ||
    $_POST['password'] == "" || $_POST['address'] == "" || $_POST['city'] == "" || $_POST['state'] == "" || $_POST['zip_code'] == "" ||
    strlen($_POST['password']) < 16 || strpos($_POST['email'], "@") == false){

        if (empty($_POST['fname'])){
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
        // create the product
        if($person->create()){
            echo "<div class='alert alert-success'>Person was created.</div>";
		
		    // try to upload the submitted file
		    // uploadPhoto() method will return an error message, if any.

		    //echo $product->uploadPhoto();
        }
  
        // if unable to create the product, tell the user
        else{
            echo "<div class='alert alert-danger'>Unable to create product.</div>";
        }
    }
}
?>

<!-- 'create product' html form will be here -->

<!-- HTML form for creating a product -->

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
 
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
            <td><input type='text' name='fname' value= "<?php echo (isset($fname))?$fname:""; ?>" class='form-control' /></td>
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
            <td><input type='password' name='password' class='form-control' /></td>
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
            <!-- categories from database will be here -->
			<?php
// read the product categories from the database
/*$stmt = $category->read();
  
// put them in a select drop-down
echo "<select class='form-control' name='category_id'>";
    echo "<option>Select category...</option>";
  
    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row_category);
        echo "<option value='{$id}'>{$name}</option>";
    }
  
echo "</select>";*/
?>
			
         
		<!--<tr>
				<td>Photo</td>
				<td><input type="file" name="image" /></td>
		</tr>-->
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
  
    </table>
</form>


<?php
  
// footer
include_once "layout_footer.php";
?>