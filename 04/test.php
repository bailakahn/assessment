<?php

	require 'User.php';
	require 'order.php';

	$baila = new User('Baila', 'Kahn', 'on');

	var_dump($baila);

	$order = new Order($baila, 1000, 'kahn');

	var_dump($order->chargeTaxes());

?>