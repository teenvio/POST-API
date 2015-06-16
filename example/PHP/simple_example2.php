<?php
/**
 * @copyright Ipdea Land, S.L. / Teenvio
 *
 * LGPL v3 - GNU LESSER GENERAL PUBLIC LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU LESSER General Public License as published by
 * the Free Software Foundation, either version 3 of the License.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU LESSER General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * -------- Add or update a contact into Teenvio acount ------------
 *
 */

/* Conf data */

$url="https://secure.teenvio.com/v4/public/api/post/";
$action="contact_save";
$plan="acount_name";	//Change this
$user="username";	//Change this
$pass="password";	//Change this
$rid="1";		//Check this
$gid="1";		//Check this
$pid="1";		//Check this

/* Contact data */
$data=array(
	'action'=>$action,
	'plan'=>$plan,
	'user'=>$user,
	'pass'=>$pass,
	'rid'=>$rid,					//From Id for list-unsubscribers and aut-response
	'gid'=>$gid,
	'email'=>'soporte@teenvio.com',			//Email
	'nombre'=>'Soporte/support teenvio.com',	//Name
	'empresa'=>'teenvio.com',			//Company
	'eciudad'=>'Madrid',				//Compay city
	'eprovincia'=>'Madrid',				//Company state
	'epais'=>'Spain',				//Compaty contry
	'dato_1'=>'extra data one',			//Extra data 1
	'dato_2'=>'extra data two',			//Extra data 2
	'pid'=>''					//Empty
);

print_r($data);

$url.='?';
foreach($data as $name=>$value){
	$url.=$name.'='.urlencode($value).'&';
}

$context = stream_context_create(array(
    'http' => array('ignore_errors' => true),
));

$response=file_get_contents($url,false,$context);

if ($response!==false && substr($response,0,2)=='OK'){
	//OK
	echo $response;
}else{
	//KO/FAIL
	echo $response;
}


?>