<?php 
//include('../include/connection.php');
class user
{
	 private $db;
 
    function __construct($conn)
    {
      $this->db = $conn;
    }
	public function doLogin($username, $password)
	{
		try
		{
			$query= $this->db->prepare('SELECT * FROM user WHERE username = :username and password = :password ');
			$query->execute(array(':username'=>$username, ':password'=>$password));
			$userRow=$query->fetch(PDO::FETCH_ASSOC);
			if($query->rowCount() > 0)
			{
				if($userRow['id'] == 1){
					$_SESSION['username'] = $username;
					$_SESSION['type'] = 0;
					return true;
				}else{
					$_SESSION['username'] = $username;
					$_SESSION['type'] = 1;
					return true;

				}
			}
		}
		catch(PDOException $e)
       	{
           echo $e->getMessage();
       	}
	}
	public function doLoginMember($username, $password,$table)
	{
		try
		{
			$query= $this->db->prepare("SELECT * FROM `$table` WHERE email = :username and password = :password ");
			$query->execute(array(':username'=>$username, ':password'=>$password));
			$userRow=$query->fetch(PDO::FETCH_ASSOC);
			if($query->rowCount() > 0)
			{
				$_SESSION['email'] = $username;
				return true;
			}
		}
		catch(PDOException $e)
       	{
           echo $e->getMessage();
       	}
	}
	public function getField($id,$table,$field) 
	{
    	$sql = "SELECT * FROM `$table` WHERE id = :id";
    	$sth = $this->db->prepare($sql);
    	$sth->execute(array(':id' => $id));
	    $category = $sth->fetch(PDO::FETCH_ASSOC);
		if ($sth->rowCount() > 0) {
			return $category[$field];
		} else {
			return FALSE;
		}
	}
	public function getFieldUser($id,$table,$field) 
	{
    	$sql = "SELECT * FROM `$table` WHERE user_id = :id";
    	$sth = $this->db->prepare($sql);
    	$sth->execute(array(':id' => $id));
	    $category = $sth->fetch(PDO::FETCH_ASSOC);
		if ($sth->rowCount() > 0) {
			return $category[$field];
		} else {
			return FALSE;
		}
	}
	public function getProduct($id1,$id,$table) 
	{
    	$sql = "SELECT * FROM `$table` WHERE $id1 = :id";
    	$sth = $this->db->prepare($sql);
    	$sth->execute(array(':id' => $id));
	    return $sth->rowCount();
	}

	public function getBrandName($name) 
	{
    	$sql = "SELECT * FROM brand WHERE name LIKE :name";
    	$sth = $this->db->prepare($sql);
    	$sth->execute(array(':name' => $name));
	    return $sth->rowCount();
	}
	public function getBrandId($name) 
	{
    	$sql = "SELECT * FROM brand WHERE name LIKE :name";
    	$sth = $this->db->prepare($sql);
    	$sth->execute(array(':name' => $name));
		$brandValue= $sth->fetch(PDO::FETCH_ASSOC);
	    return $brandValue['id'];
	}

	public function changeDate($date) 
	{ 
		Return date("d-m-Y", strtotime($date));  	
	}
	
	public function getField1($email,$table,$field,$id) 
	{
    	$sql = "SELECT * FROM `$table` WHERE $id = :email";
    	$sth = $this->db->prepare($sql);
    	$sth->execute(array(':email' => $email));
	    $category = $sth->fetch(PDO::FETCH_ASSOC);
		if ($sth->rowCount() > 0) {
			return $category[$field];
		} else {
			return FALSE;
		}
	}
	public function redirect($url)
   	{
       header("Location: $url");
   	}
	public function is_loggedin()
   	{
      	if(isset($_SESSION['username']))
      	{
        	return true;
      	}
   	}
	public function logout()
   	{
        session_destroy();
        unset($_SESSION['username']);
        return true;
   	}
	
}

?>