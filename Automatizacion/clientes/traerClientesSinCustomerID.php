<?php 
require_once '/var/www/vhosts/' . $_SERVER['HTTP_HOST'] . '/httpdocs/Automatizacion/database/dbSelectors.php';

$selectBDD = selectBDD();
$dbname    = $selectBDD[dbname];
$username  = $selectBDD[username];
$password  = $selectBDD[password];

if($activeStore == 'testdemo'){
	$username = "ps_test";
	$dbname = "prestashop_test";
	$password = "En93#eq0";
}else if ($activeStore == 'devdemo'){
	$username = "ps_dev";
	$dbname = "prestashop_dev";
	$password = "En93#eq0";
}
$db_index = "prstshp_";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$clientes = [];
$sql =  "SELECT id_customer, firstname, lastname, email, RFC FROM {$db_index}customer WHERE (RFC IS NOT NULL AND RFC != '') AND (customerID IS NULL OR customerID = '') LIMIT 3";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$contador=0;
	while($row = $result->fetch_assoc()) {
		$id_customer = $row[id_customer];
		$firstname = utf8_encode($row[firstname]);
		$lastname = utf8_encode($row[lastname]);
		$email = utf8_encode($row[email]);
		$RFC = $row[RFC];
		$filtro = "dataAreaId eq 'inn' and RFCNumber eq '{$RFC}'";
		if($RFC == 'XAXX010101000'){
			$filtro = "";
		}
		$clientes[$contador] = array( "id_customer" =>(int)$row[id_customer],  
			"firstname" => "{$firstname}", 
			"lastname" 	=> "{$lastname}", 
			"email" 	=> "{$email}", 
			"RFC" 		=>  "{$RFC}",
			"filtro" 	=> "{$filtro}"
		);
		$contador++;
	}
}
echo json_encode($clientes);
?>