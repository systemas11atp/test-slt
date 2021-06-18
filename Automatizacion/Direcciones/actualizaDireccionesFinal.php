<?php 
require_once('/var/www/vhosts/lideart.net/httpdocs/logs_locales.php');

include(dirname(__FILE__).'/config/config.inc.php');
include_once(dirname(__FILE__).'/config/settings.inc.php');
include_once('/classes/Cookie.php');
include('/init.php');
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
	throw new Exception('Request method must be POST!');
}
include '../token.php';

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

$content = trim(file_get_contents("php://input"));

$decodedT = json_decode($content, true);

if(!is_array($decodedT)){
	throw new Exception('Received content contained invalid JSON!');
}

$activeStore = explode("/",$_SERVER['REQUEST_URI'])[1];

$dbname = "prestashop_3";
$username = "admin_lideart";
$password = "Avanceytec_2022";

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

//$addressID =  $decodedT[addressID];
$customerID =  $decodedT[customerID];
$addressID =  $decodedT[addressID];
$accion =  $decodedT[accion];
$Effective =  $decodedT[Effective];
$AddressDescription =  $decodedT[AddressDescription];
$AddressCountyId =  $decodedT[AddressCountyId];
$AddressCity =  $decodedT[AddressCity];
$AddressZipCode =  $decodedT[AddressZipCode];
$AddressStreet =  $decodedT[AddressStreet];
$AddressState =  $decodedT[AddressState];

$id_address =  $decodedT[id_addres];

$token = new Token(); 
$tokenTemp = $token->getToken("LIN","prue"); 
$token = $tokenTemp[0]->Token; 
if($accion == "actualizar"){

	$urlProd = "https://ayt.operations.dynamics.com";
	$urlPrue = "https://tes-ayt.sandbox.operations.dynamics.com";
	$api = "/Data/CustomerPostalAddresses";
	$filterPatch = "(dataAreaId=%27lin%27,CustomerAccountNumber=%27{$customerID}%27,CustomerLegalEntityId=%27lin%27,AddressLocationId=%27{$addressID}%27,Effective={$Effective})";
	$fullUrl = "{$urlPrue}{$api}{$filterPatch}";
	$POSTFIELDS = "{";
	$POSTFIELDS .= "\n\t\"Effective\" : \"{$Effective}\",";
	$POSTFIELDS .= "\n\t\"AddressDescription\" : \"{$AddressDescription}\",";
	$POSTFIELDS .= "\n\t\"AddressCountyId\" : \"{$AddressCountyId}\",";
	$POSTFIELDS .= "\n\t\"AddressCity\" : \"{$AddressCity}\",";
	$POSTFIELDS .= "\n\t\"AddressZipCode\" : \"{$AddressZipCode}\",";
	$POSTFIELDS .= "\n\t\"AddressStreet\" : \"{$AddressStreet}\",";
	$POSTFIELDS .= "\n\t\"AddressState\" : \"{$AddressState}\"";
	$POSTFIELDS .= "\n}";
	print_r("fullUrl : {$fullUrl}\n\n");
	print_r("POSTFIELDS : {$POSTFIELDS}\n\n");
	print_r("token : {$token}\n\n");

	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_URL => $fullUrl,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "PATCH",
		CURLOPT_POSTFIELDS => $POSTFIELDS,
		CURLOPT_HTTPHEADER => [
			"Accept: application/json",
			"Authorization: Bearer {$token}",
			"Content-Type: application/json"
		],
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		$sql =  "UPDATE prstshp_address SET effective = '{$Effective}' WHERE id_address = {$id_address}";
		print_r("sql : {$sql}\n\n");
		if($conn->query($sql)){
			print_r("true");
		}else{
			print_r("false");
		}
	}
	
}
exit();
?>