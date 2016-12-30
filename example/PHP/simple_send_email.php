<?php
	require_once __DIR__.'/class/APIClientPOST.php';
	require_once __DIR__.'/class/APISendEmail.php';

	//Credentials: Can get this data in teenvio's app.
	$user="user";     //User
	$plan="acount";   //Acount
	$pass="pass";     //Password
	$senderId=1;      //Sender (from)

	//************************************
	//1º Create the API object
	
	$api=new Teenvio\APIClientPOST($user,$plan,$pass);
	
	//************************************
	//2º Create and save the content
	
	$html="<html>
		<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/></head>
		<body>
		<p>Hello ###nombre###,<br> News <b>api</b></p>
		<p> Dinamic var 1: [[[var_code_1]]]<br>
		    Dinamic var 2: [[[var_code_2]]]</p>
		<hr></body></html>";
	
	$id_news=$api->saveNewsletter('API Newsletter', $html);
	echo "Newsletter Id: $id_news<br>\n";
	
	//************************************
	//3º Save Contact
	
	$contact=array(
		'email'=>'info@teenvio.com',
		'nombre'=>'Teenvio' //Name
		//See doc for more fields
	);
		
	$id_contact=$api->saveContact($contact);
	echo "Contact Id: $id_contact<br>\n";
	
	//************************************
	//4º Create Group/list
	
	$id_group= $api->saveGroup('API New Group');
	echo "Group Id: $id_group<br>\n";
	
	//************************************
	//5º Add contact to group/list
	$api->groupContact($contact['email'], $id_group);
	
	//************************************
	//6º Send Email
	
	$sendEmail=new \Teenvio\APISendEmail($api);
	$sendEmail->setSubject('This is the email subject');
	$sendEmail->setName('This is the campaign name');
	$sendEmail->setIdNewsletter($id_news);        //Set the id newsletter / content
	$sendEmail->setSenderId($senderId);           //Set the Sender Id. Can get this id in teenvio's app.
	
	$sendEmail->setVar('var_code_1', '0000001');  //Set custom vars content
	$sendEmail->setVar('var_code_2', '0000002');  //Set custom vars content
	
	$sendEmail->setIdContact($id_contact);        //Send single email
	//$sendEmail->setIdGroup($id_group);          //Send campaign to a full group/list
	
	$id_campaign=$sendEmail->send();
	
	echo "Id campaign $id_campaign<br>\n";
	
	

?>