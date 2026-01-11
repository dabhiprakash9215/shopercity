<?php include("../include/connection.php");
	
	if(isset($_POST["id"]))
	{
		foreach($_POST["id"] as $id)
		{
			$update_query=$conn->prepare("DELETE FROM product_gallery WHERE id=:id");
			$update_record=$update_query->execute( array(':id'=> $id));
		}
	}
?>