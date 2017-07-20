<?php
function getUserInfo() {
	if (!isset($_GET['email'])) {
		responseJson([
			'code' => 200,
			'type' => 0,
			'error_msg' => 'Please enter email'
		]);
	}
	
	$email = mysql_escape_string($_GET['email']);
	$sql_get_user = "SELECT * FROM user WHERE email = '". $email . "' LIMIT 1";
	$check_sql_get_user = mysql_query($sql_get_user);
	
	if(mysql_num_rows($check_sql_get_user) > 0) {
		$user_info = mysql_fetch_assoc($check_sql_get_user);
		responseJson([
			'code' => 200,
			'type' => 1,
			'data' => [
					'user_info' => [
					'email' => $user_info['email'],
					'name' => $user_info['name'],
					'address' => $user_info['address'],
					'tel' => $user_info['tel'],
				]
			]
		]);
	}
	else {
		responseJson([
			'code' => 200,
			'type' => 0,
			'error_msg' => 'Not found user with email: ' . $email
		]);
	}
}

function updateUserInfo() {
	if (!isset($_POST['email'])) {
		responseJson([
			'code' => 200,
			'type' => 0,
			'error_msg' => 'Please enter email'
		]);
	}
	
	$email = mysql_escape_string($_POST['email']);
	
	$name = $address = $tel = null;
	$arr_update = [];
	if (isset($_POST['name'])) {
		$name = mysql_escape_string($_POST['name']);
		$arr_update['name'] = $name;
	}
	if (isset($_POST['address'])) {
		$name = mysql_escape_string($_POST['address']);
		$arr_update['address'] = $address;
	}
	if (isset($_POST['tel'])) {
		$tel = mysql_escape_string($_POST['tel']);
		$arr_update['tel'] = $tel;
	}
	
	if (!$name && !$address && !$tel) {
		responseJson([
			'code' => 200,
			'type' => 0,
			'error_msg' => 'Nothing to update'
		]);
	}
	
	$sql_update = "UPDATE user SET ";
	foreach ($arr_update as $key => $v) {
		$sql_update .= $key . " = '" . $v . "'";
	}
	$sql_update .= " WHERE email = '" . $email . "'";
	if(mysql_query($sql_update)) {
		responseJson([
			'code' => 200,
			'type' => 1,
			'msg' => 'Update successfully'
		]);
	}
	else {
		responseJson([
			'code' => 200,
			'type' => 0,
			'error_msg' => 'Update failed'
		]);
	}
}

function responseJson($data) {
	try {
		$response = json_encode($data); 
		echo $response;
	}
	catch(Expcetion $e) {
		echo $e->getMessage();
	}
	exit();
}

function beforeDoApi($method) {
	if (!isset($method['key'])) {
		responseJson([
			'code' => 200,
			'type' => 0,
			'error_msg' => 'Please enter key'
		]);
	}
	if (!isset($method['secret'])) {
		responseJson([
			'code' => 200,
			'type' => 0,
			'error_msg' => 'Please enter secret'
		]);
	}
	
	$key = mysql_escape_string($method['key']);
	$secret = mysql_escape_string($method['secret']);
	
	if (!checkPairKeySecret($key, $secret)) {
		responseJson([
			'code' => 200,
			'type' => 0,
			'error_msg' => 'Key and secret are not correct'
		]);
	}
	
	return true;
}

function checkPairKeySecret($key, $secret) {
	$check_existed = "SELECT * FROM client_config WHERE client_key = '". $key . "' AND client_secret = '" . $secret . "' LIMIT 1";
	$check_existed_query_result = mysql_query($check_existed);
	if(mysql_num_rows($check_existed_query_result)==0) {
		return false;
	}
	return true;
}

include '../connect_to_database.php';

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (strpos($actual_link, "/getUserInfo") !== false) {
	if (beforeDoApi($_GET)) {
		getUserInfo();
	}
}
if (strpos($actual_link, "/updateUserInfo") !== false) {
	if (beforeDoApi($_POST)) {
		updateUserInfo();
	}
}