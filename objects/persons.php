<?php
class Person{
  
    // database connection and table name
    private $conn;
    private $table_name = "persons";
  
    // object properties
    public $id;
    public $role;
	public $fname;
	public $lname;
	public $email;
	public $phone;
	public $password_hash;
	public $password_salt;
	public $address;
	public $address2;
	public $city;
	public $state;
	public $zip_code;
  
    public function __construct($db){
        $this->conn = $db;
    }
  
    // create product
    function create(){
  
        //write query
        $query = "INSERT INTO " . $this->table_name . "
            SET role=:role, fname=:fname, lname=:lname, email=:email, phone=:phone,
			password_hash=:password_hash, password_salt=:password_salt,
			address=:address, address2=:address2, city=:city, state=:state,
			zip_code=:zip_code";
  
        $stmt = $this->conn->prepare($query);
  
        // posted values
        $this->role=htmlspecialchars(strip_tags($this->role));
		$this->fname=htmlspecialchars(strip_tags($this->fname));
		$this->lname=htmlspecialchars(strip_tags($this->lname));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->phone=htmlspecialchars(strip_tags($this->phone));
		$this->password_hash=htmlspecialchars(strip_tags($this->password_hash));
		$this->password_salt=htmlspecialchars(strip_tags($this->password_salt));
		$this->address=htmlspecialchars(strip_tags($this->address));
		$this->address2=htmlspecialchars(strip_tags($this->address2));
		$this->city=htmlspecialchars(strip_tags($this->city));
		$this->state=htmlspecialchars(strip_tags($this->state));
		$this->zip_code=htmlspecialchars(strip_tags($this->zip_code));
        
  
        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');
  
        // bind values 
        $stmt->bindParam(":role", $this->role);
		$stmt->bindParam(":fname", $this->fname);
		$stmt->bindParam(":lname", $this->lname);
		$stmt->bindParam(":email", $this->email);
		$stmt->bindParam(":phone", $this->phone);
		$stmt->bindParam(":password_hash", $this->password_hash);
		$stmt->bindParam(":password_salt", $this->password_salt);
		$stmt->bindParam(":address", $this->address);
		$stmt->bindParam(":address2", $this->address2);
		$stmt->bindParam(":city", $this->city);
		$stmt->bindParam(":state", $this->state);
		$stmt->bindParam(":zip_code", $this->zip_code);
        
  
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
  
    }
	
	function readAll($from_record_num, $records_per_page){
  
		$query = "SELECT
                id, fname, lname, email, role
            FROM
                " . $this->table_name . "
            ORDER BY lname ASC
            LIMIT {$from_record_num}, {$records_per_page}"
		;
  
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
  
		return $stmt;
	}	
	
	// used for paging products
	public function countAll(){
  
		$query = "SELECT id FROM " . $this->table_name . "";
  
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
  
		$num = $stmt->rowCount();
  
		return $num;
	}
	
	function readOne(){
  
		$query = "SELECT
		          role, fname, lname, email, phone, password_hash, password_salt, address, address2, city, state, zip_code
            FROM
                " . $this->table_name . "
            WHERE
                id = ?
            LIMIT
                0,1";
  
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();
  
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
  
		$this->role = $row['role'];
		$this->fname = $row['fname'];
		$this->lname = $row['lname'];
		$this->email = $row['email'];
		$this->phone = $row['phone'];
		$this->password_hash = $row['password_hash'];
		$this->password_salt = $row['password_salt'];
		$this->address = $row['address'];
		$this->address2 = $row['address2'];
		$this->city = $row['city'];
		$this->state = $row['state'];
		$this->zip_code = $row['zip_code'];
		
	}
	
	function update(){
		

		
		
		$query = "UPDATE
                " . $this->table_name . "
            SET
                role = :role,
                fname = :fname,
				lname = :lname,
				email = :email,
				phone = :phone,
				password_hash = :password_hash,
				password_salt = :password_salt,
				address = :address,
				address2 = :address2,
				city = :city,
				state = :state,
				zip_code = :zip_code
            WHERE
                id = :id";
  
		$stmt = $this->conn->prepare($query);
  
		// posted values
		$this->role=htmlspecialchars(strip_tags($this->role));
		$this->fname=htmlspecialchars(strip_tags($this->fname));
		$this->lname=htmlspecialchars(strip_tags($this->lname));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->phone=htmlspecialchars(strip_tags($this->phone));
		$this->password_hash=htmlspecialchars(strip_tags($this->password_hash));
		$this->password_salt=htmlspecialchars(strip_tags($this->password_salt));
		$this->address=htmlspecialchars(strip_tags($this->address));
		$this->address2=htmlspecialchars(strip_tags($this->address2));
		$this->city=htmlspecialchars(strip_tags($this->city));
		$this->state=htmlspecialchars(strip_tags($this->state));
		$this->zip_code=htmlspecialchars(strip_tags($this->zip_code));
		$this->id=htmlspecialchars(strip_tags($this->id));
  
		// bind parameters
		$stmt->bindParam(':role', $this->role);
		$stmt->bindParam(':fname', $this->fname);
		$stmt->bindParam(':lname', $this->lname);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':phone', $this->phone);
		$stmt->bindParam(':password_hash', $this->password_hash);
		$stmt->bindParam(':password_salt', $this->password_salt);
		$stmt->bindParam(':address', $this->address);
		$stmt->bindParam(':address2', $this->address2);
		$stmt->bindParam(':city', $this->city);
		$stmt->bindParam(':state', $this->state);
		$stmt->bindParam(':zip_code', $this->zip_code);
		$stmt->bindParam(':id', $this->id);
  
		// execute the query
		if($stmt->execute()){
			return true;
		}
  
		return false;
		
	}
	
	// delete the person
	function delete(){
  
		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
      
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
  
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// read persons by search term
	/*public function search($search_term, $from_record_num, $records_per_page){
  
		// select query
		$query = "SELECT
                p.role, p.fname, p.lname, p.email, p.phone
            FROM
                " . $this->table_name . " p
				WHERE p.fname LIKE ? OR p.lname LIKE ?
				ORDER BY p.lname ASC
				LIMIT ?, ?";
  
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
  
		// bind variable values
		$search_term = "%{$search_term}%";
		$stmt->bindParam(1, $search_term);
		$stmt->bindParam(2, $search_term);
		$stmt->bindParam(3, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(4, $records_per_page, PDO::PARAM_INT);
  
		// execute query
		$stmt->execute();
  
		// return values from database
		return $stmt;
	}
  
	public function countAll_BySearch($search_term){
  
		// select query
		$query = "SELECT
                COUNT(*) as total_rows
            FROM
                " . $this->table_name . " p 
				WHERE p.fname Like ? OR p.lname Like ?";
  
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
  
		// bind variable values
		$search_term = "%{$search_term}%";
		$stmt->bindParam(1, $search_term);
		$stmt->bindParam(2, $search_term);
  
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
  
		return $row['total_rows'];
		
	}*/
	
	/*// will upload image file to server
	function uploadPhoto(){
  
		$result_message="";
  
		// now, if image is not empty, try to upload the image
		if($this->image){
  
			// sha1_file() function is used to make a unique file name
			$target_directory = "uploads/";
			$target_file = $target_directory . $this->image;
			$file_type = pathinfo($target_file, PATHINFO_EXTENSION);
  
			// error message is empty
			$file_upload_error_messages="";
			
			// make sure that file is a real image
			$check = getimagesize($_FILES["image"]["tmp_name"]);
			if($check!==false){
				// submitted file is an image
			}else{
				$file_upload_error_messages.="<div>Submitted file is not an image.</div>";
			}
  
			// make sure certain file types are allowed
			$allowed_file_types=array("jpg", "jpeg", "png", "gif");
			
			if(!in_array($file_type, $allowed_file_types)){
				$file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
			}
  
			// make sure file does not exist
			if(file_exists($target_file)){
				$file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
			}
  
			// make sure submitted file is not too large, can't be larger than 1 MB
			if($_FILES['image']['size'] > (1024000)){
				$file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
			}
  
			// make sure the 'uploads' folder exists
			// if not, create it
			if(!is_dir($target_directory)){
				mkdir($target_directory, 0777, true);
			}
			
			// if $file_upload_error_messages is still empty
			if(empty($file_upload_error_messages)){
				// it means there are no errors, so try to upload the file
				if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
					// it means photo was uploaded
				}else{
					$result_message.="<div class='alert alert-danger'>";
						$result_message.="<div>Unable to upload photo.</div>";
						$result_message.="<div>Update the record to upload photo.</div>";
					$result_message.="</div>";
				}
			}
  
			// if $file_upload_error_messages is NOT empty
			else{
				// it means there are some errors, so show them to user
				$result_message.="<div class='alert alert-danger'>";
					$result_message.="{$file_upload_error_messages}";
					$result_message.="<div>Update the record to upload photo.</div>";
				$result_message.="</div>";
			}
  
		}
  
		return $result_message;
	}*/
}
?>