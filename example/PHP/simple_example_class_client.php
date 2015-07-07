<?php
require_once './class/APIClientPOST.php';

use Teenvio\APIClientPOST as APIClient;

if (!isset($_GET['key'],$_GET['keyref'])){
	UTLHttp::sendBadRequest('No han llegado los parámetros necesarios');
}

try{
	$api=new APIClient('user', 'plan/acount', 'pass');
	
	$api->ping();
	
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
	$json=$api->getStats(1510, APIClient::OUTPUT_MODE_JSON);
	
	echo "<br/> Estadísticas:<br/><pre>".print_r(json_decode($json,true),true)."</pre>";
	
}catch(TeenvioException $e){
	echo $e->getMessage();
}

?>