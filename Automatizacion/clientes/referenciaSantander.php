<?php 
include '../token.php';
require_once '/var/www/vhosts/' . $_SERVER['HTTP_HOST'] . '/httpdocs/Automatizacion/database/dbSelectors.php';
set_time_limit(0);
/*
$customerID = "CL0001419";
$customerID = "C00000688422";

$organizationNumber=getSantanderConstant($customerID);
print_r("customerID : {$customerID}<br>");
print_r("organizationNumber : {$organizationNumber}<br>");

function santanderSetCharValues($char){
	$assignValuesArray = array(
		'A' => '1','B' => '2','C' => '3','D' => '4',
		'E' => '5','F' => '6','G' => '7','H' => '8',
		'I' => '9','J' => '1','K' => '2','L' => '3',
		'M' => '4','N' => '5','O' => '6','P' => '7',
		'Q' => '8','R' => '9','S' => '1','T' => '2',
		'U' => '3','V' => '4','W' => '5','X' => '6',
		'Y' => '7','Z' => '8'
	);
	if($assignValuesArray[$char]){
		print_r("assignValuesArray[{$char}] : {$assignValuesArray[$char]}<br>");
		return $assignValuesArray[$char];
	} else{
		print_r("char : {$char}<br>");
		return $char;
	}
}

function santanderVerificationDigit($array){
        //print_r($array);
	$multiplierArray = [11,13,17,19,23];
	$resultArray = array();
	$index = 0;
	foreach ($array as $key => $value) {
		if($index > 4) $index = 0;
		$resultArray[] = $value*$multiplierArray[$index];
		$index++;      
	}
	print_r("array_sum(resultArray) : ".array_sum($resultArray)."<br>");
	$toDivide = array_sum($resultArray) + 330;
	print_r("toDivide : {$toDivide}<br>");
        //echo $toDivide;
	$residual = ($toDivide % 97) + 1;
	print_r("residual : {$residual}<br>");
        //echo $residual;
	$formatCode = str_pad($residual, 2, 0, STR_PAD_LEFT);
	print_r("formatCode : {$formatCode}<br>");
	return $formatCode;
}


function getSantanderConstant($clientNumber){
        //echo "dentro de santander";
	$temporalString = str_split($clientNumber);
	//print_r("temporalString : {$temporalString}<br>");
        //print_r($assignValuesArray);
	$formatedChars = array_map("santanderSetCharValues", $temporalString);

	$verificationCode = santanderVerificationDigit(array_reverse($formatedChars));
	//print_r("verificationCode : {$verificationCode}<br>");
	return $clientNumber.$verificationCode; 
}
*/
?>