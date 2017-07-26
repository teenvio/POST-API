<?php
require_once './class/APIClientPOST.php';

use Teenvio\APIClientPOST as APIClient;


try{
	$api=new APIClient('user', 'plan/acount', 'pass');
	
	$api->ping();
	
	echo "<br/> Contact fields:<br><pre>";
	print_r(json_decode($api->getContactFields(),true));
	echo "</pre>";
		
	echo "<br/> Version: ".$api->getServerVersion();
	
	$contact=array(
		'email'=>'soporte@teenvio.com', //Email
		'nombre'=>'Soporte Teenvio'	//Name
						//More...
	);
	
	echo "<br/> Id contacto: ".$api->saveContact($contact);
	
	/**
	 * Change this id for your id stats
	 */
	$json=$api->getStats(15, APIClient::OUTPUT_MODE_JSON);
	
	echo "<br/> Estadísticas:<br/><pre>".print_r(json_decode($json,true),true)."</pre>";
	
}catch(TeenvioException $e){
	echo $e->getMessage();
}

?>
