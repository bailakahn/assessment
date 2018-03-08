<?php

	/**
     * @param $data string clean data sent by the users
     * @return string cleaned data
     */
     function cleanData($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlentities($data);
            return $data;
    }

    /**
	* @param $order_id string the id of the order
    */
    function sendMail($order_id, $transaction_id){

	$mail = new PHPMailer(true);
	//Send email
    $mail->isSMTP();
    $mail->Host = 'smtp1.example.com;smtp2.example.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'user@example.com';
    $mail->Password = 'secret';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');

	$sql3 = "SELECT * FROM order WHERE order_id = " . $order_id;
	$order = mysql_query($sql3);
	$order = mysql_result($order);

    $mail->addAddress($order['email'], $order['customer _name']);

    $mail->addReplyTo('info@example.com', 'Information');
    $mail->isHTML(true);
    $mail->Subject = 'Your order is complete!';
    $mail->Body    = 'Thank you for completing your order with us! Here\'s your transaction ID: ' . $transaction_id;
    $mail->send();

    echo "Okay!";

    }

 public function completeOrder($order_id) {
	//Order status 2 = 'complete';
	$sql = "UPDATE order SET status_id = 2 WHERE order_id = " . $order_id;
	$result = mysql_query($sql);

	// clean the data sent by the user
	$cardholder = cleanData($_POST['cardholder']);
	$number = cleanData($_POST['number']);
	$exp_month = cleanData($_POST['exp_month']);
	$exp_year = cleanData($_POST['exp_year']);
	$cvv = cleanData($_POST['cvv']);
	$type = cleanData($_POST['type']);

	//Charge credit card
	$transaction = new Transaction();
	$transaction->cardholder = $cardholder;
	$transaction->number = $number;
	$transaction->exp_month = $exp_month;
	$transaction->exp_year = $exp_year;
	$transaction->cvv = $cvv;
	$transaction->type = $type;

	$transaction_id = $transaction->charge(); //Function returns transaction_id

	$sql2 = "UPDATE order SET transaction_id = " . $transaction_id;
	mysql_query($sql2);

	sendMail($order_id, $transaction_id);
	
}
?>