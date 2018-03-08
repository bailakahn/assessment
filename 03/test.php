<?php

	require 'UserModel.php';
	//require 'Database.php';

	$db = new Database();

	$user = new UserModel($db);

	//create a user
	/*
	$user->create([
		'first_name' => 'Baila',
		'last_name' => 'Kahn',
		'job_title' => 'Developer',
		'salt' => 'Sel'
		]);
	*/

	//update a user
	/*
	$user->update(1, [
		'first_name' => 'Thanh',
		'last_name' => 'Nguyen',
		'job_title' => 'Lead Developer',
		'salt' => 'Sucre'
		]);
	*/

	//delete a user
	$user->delete(3);

	$users = $user->all();
	
	var_dump($users);
?>