<?php
/*
	in the first two assessment i ignored the fact that mysql_query is depreciated

	i only tried to clean the code, find the bugs and create functions

*/
//include necessary files
include "const.php";
include "db.php";

	//make sure something is sent via a form first
	if (!empty($_POST)) {

		//if company_id is not empty
		if(isset($_POST['company_id']) && $_POST['company_id'] <> 0){

			//update the company table
			$sql = "UPDATE company SET name=" . $_POST['name'] . ", address=" . $_POST['address'] . " WHERE company_id=" .$_POST['company_id'];
			


			$result = mysql_query($sql);

		}else{

			// if company_id is empty create a new record
			$sql = "INSERT INTO company SET name =" .$_POST['name'] . ", address=" . $_POST['address'] ;
			
			$result = mysql_query($sql);
	
		}

	}


	if (!empty($_GET['company_id'])) {

		//get the company informations
		$sql = "SELECT * FROM company WHERE company_id=" . $_GET['company_id'];
		
		$result = mysql_query($sql);

	}

?>

<!DOCTYPE html>
	<html lang="en">

		<head>

			<meta charset="utf-8">
			<title>Company</title>
			<meta name="description" content="This is an example of HTML5 header element. header element is the head of a new section." />

		</head>

		<body>

			<?=  (empty($_GET['company_id'])) ? '<h1>Add your company</h1>' : '<h1>Edit your company</h1>'; ?>

				<form action="messy-code.php" method="post">

					<?php
					
						if (!empty($_GET['company_id'])) {
					
					?>

					<input type="hidden" name="company_id" value="<?= empty($_GET['company_id']) ? '' : $result['company_id'] ;?>">
					
					<?php

						}

					?>

					<label for="name" >Name</label>
					<input id="name" type="text" name="name" value="<?= empty($_GET['company_id']) ? '' : $result['name'] ; ?>" />
					
					<br />

					<label for="address" >Address</label>
					<input id="address" type="text" name="address" value="<?= empty($_GET['company_id']) ? '' : $result['address'] ; ?>" />
					
					<br />

					<input type="submit" name="submit" value="submit" />

			</form>
		</body>
	</html>