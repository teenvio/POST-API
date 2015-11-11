<?php

namespace Teenvio;

/**
 * @package API
 * @author Víctor J. Chamorro <victor@ipdea.com>
 * @copyright (c) Teenvio/Ipdea Land
 * @license LGPL v3
 */
class APIClientPOST{
	
	/**
	 * @var string
	 */
	const clientVersion="1.0-php-20150720";
	
	/**
	 * Outputs Mode 
	 */
	const OUTPUT_MODE_PLAIN='PLAIN';
	const OUTPUT_MODE_JSON='JSON';
	const OUTPUT_MODE_XML='XML';
	const OUTPUT_MODE_CSV='CSV';
	
	/**
	 * Stat Section
	 */
	const STAT_SECTION_ALL='ALL';
	const STAT_SECTION_SEND='SEND';
	const STAT_SECTION_SEND_OPENED='SEND_OPENED';
	const STAT_SECTION_SEND_OPENED_ACTIVE='SEND_OPENED_ACTIVE';
	const STAT_SECTION_SEND_OPENED_UNSUBSCRIBED='SEND_OPENED_UNSUBSCRIBED';
	const STAT_SECTION_SEND_UNOPENED='SEND_UNOPENED';
	const STAT_SECTION_SEND_UNOPENED_DELIVERED='SEND_UNOPENED_DELIVERED';
	const STAT_SECTION_SEND_UNOPENED_BOUNCED='SEND_UNOPENED_BOUNCED';
	const STAT_SECTION_UNSEND='UNSEND';
	const STAT_SECTION_UNSEND_UNSUBSCRIBED='UNSEND_UNSUBSCRIBED';
	const STAT_SECTION_UNSEND_UNSUBSCRIBED_VOLUNTARY='UNSEND_UNSUBSCRIBED_VOLUNTARY';
	const STAT_SECTION_UNSEND_UNSUBSCRIBED_AUTOMATIC='UNSEND_UNSUBSCRIBED_AUTOMATIC';
	const STAT_SECTION_UNSEND_FAILED='UNSEND_FAILED';
	const STAT_SECTION_UNSEND_FAILED_NOMENCLATURE='UNSEND_FAILED_NOMENCLATURE';
	const STAT_SECTION_CLICKED='UNSEND_FAILED_NOMENCLATURE';
	
	/**
	 * User
	 * @var string
	 */
	private $user='';
	
	/**
	 * Plan/Acount
	 * @var string
	 */
	private $plan='';
	
	/**
	 * Passwrod
	 * @var string 
	 */
	private $pass='';
	
	/**
	 * URL API Post
	 * @var string
	 */
	private $urlBase="https://master2.teenvio.com/v4/public/api/post/";
	
	/**
	 * HTTP Method
	 * @var type 
	 */
	private $apiMethod='post';
	
	/**
	 * Las response from server
	 * @var string
	 */
	private $lastResponse='';
	
	/**
	 * Instance a API client Class.
	 * 
	 * User, Plan/Acount, Password is required
	 * 
	 * @param string $user
	 * @param string $plan
	 * @param string $pass
	 */
	public function __construct($user,$plan,$pass) {
		$this->user=$user;
		$this->plan=$plan;
		$this->pass=$pass;
	}
	
	/**
	 * Set POST HTTP method 
	 */
	public function setMethodPOST(){
		$this->apiMethod='post';
	}
	
	/**
	 * Set GET HTTP method
	 */
	public function setMethodGET(){
		$this->apiMethod='get';
	}
	
	/**
	 * Client Version
	 * @return string
	 */
	public function getClientVersion(){
		return self::clientVersion;
	}
	
	/**
	 * Server Version
	 * @return string
	 * @throws TeenvioException
	 */
	public function getServerVersion(){
		$data=array();
		$data['action']='get_version';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="OK"){
			return substr($bruto,3);
		}
		
		throw new TeenvioException($bruto);
	}
	
	/**
	 * Check the current connection.
	 * If this method returns false any setup fails.
	 * 
	 * @return boolean
	 */
	public function ping(){
		try{
			$this->getServerVersion();
			return (substr($this->lastResponse,0,2)=="OK");
		}catch(TeenvioException $e){}
		return false;
	}
	
	/**
	 * Save a contact. For all keys names check the pdf document
	 * @param array $data Asociative array
	 * @return int
	 * @throws TeenvioException
	 * @link https://github.com/teenvio/POST-API/blob/master/doc/POST-API_es.pdf
	 */
	public function saveContact($data){
		
		if (!is_array($data)){throw new TeenvioException('Input data for saveContact is not asociative array');}
		
		$data['action']='contact_save';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="OK"){
			return (int) substr($bruto,3);
		}
		
		throw new TeenvioException($bruto);
	}
	
	/**
	 * Delete a contact.
	 * @param string $email
	 * @throws TeenvioException
	 */
	public function deleteContact($email){
		$data=array();
		$data['action']='contact_delete';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['email']=$email;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)!="OK"){
			throw new TeenvioException($bruto);
		}
	}
	
	/**
	 * Save group
	 * @param string $name
	 * @param string $description
	 * @param int $idGroup For update data
	 * @return int idGroup
	 */
	public function saveGroup($name,$description='',$idGroup=0){
		$data=array();
		$data['action']='group_save';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['name']=$name;
		$data['description']=$description;
		if ($idGroup!==0){ $data['gid']=$idGroup;}
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)!="OK"){
			throw new TeenvioException($bruto);
		}
		return (int) substr($bruto,4);
	}
	
	/**
	 * Delete group
	 * @param int $idGroup
	 * @throws TeenvioException
	 */
	public function deleteGroup($idGroup){
		$data=array();
		$data['action']='group_delete';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['gid']=$idGroup;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)!="OK"){
			throw new TeenvioException($bruto);
		}
	}
	
	/**
	 * Group a contact
	 * @param string $email
	 * @param string $groupId
	 * @throws TeenvioException
	 */
	public function groupContact($email, $groupId){
		$data=array();
		$data['action']='contact_group';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['email']=$email;
		$data['gid']=$groupId;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)!="OK"){
			throw new TeenvioException($bruto);
		}
	}
	
	/**
	 * Ungroup a contact
	 * @param string $email
	 * @param string $groupId
	 * @throws TeenvioException
	 */
	public function ungroupContact($email, $groupId){
		$data=array();
		$data['action']='contact_ungroup';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['email']=$email;
		$data['gid']=$groupId;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)!="OK"){
			throw new TeenvioException($bruto);
		}
	}
	
	/**
	 * Deactivate Contact from sender
	 * @param string $email
	 * @param string $fromId
	 * @throws TeenvioException
	 */
	public function deactivateContact($email,$fromId){
		$data=array();
		$data['action']='contact_deactivate';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['email']=$email;
		$data['rid']=$fromId;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)!="OK"){
			throw new TeenvioException($bruto);
		}
	}
	
	/**
	 * Activate Contact from sender
	 * @param string $email
	 * @param string $fromId
	 * @throws TeenvioException
	 */
	public function activateContact($email,$fromId){
		$data=array();
		$data['action']='contact_activate';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['email']=$email;
		$data['rid']=$fromId;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)!="OK"){
			throw new TeenvioException($bruto);
		}
	}
	
	/**
	 * Return all ocntacta data: fields, groups and campaings
	 * @param string $email
	 * @param string $outputMode Use the consts self::OUTPUT_MODE_*
	 */
	public function getContactData($email,$outputMode=self::OUTPUT_MODE_JSON){
		$data=array();
		$data['action']='contact_data';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['email']=$email;
		$data['mode']=$outputMode;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="KO"){
			throw new TeenvioException($bruto);
		}
		
		return $bruto;
	}
	
	/**
	 * Return stats in $outputMode Format
	 * Use the consts self::OUTPUT_MODE_* for $outputMode
	 * @param int $id
	 * @param string $outputMode Use the consts self::OUTPUT_MODE_*
	 * @return string
	 * @throws TeenvioException
	 */
	public function getStats($id,$outputMode=self::OUTPUT_MODE_XML){
		$data=array();
		$data['action']='get_stats';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['mode']=$outputMode;
		$data['eid']=$id;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="KO"){
			throw new TeenvioException($bruto);
		}
		
		return $bruto;
	}
	
	/**
	 * Get contact from section into stats
	 * @param int $id id stat/campaing
	 * @param string $section Use the consts self::STAT_SECTION_*
	 * @param string $outputMode Use the consts self::OUTPUT_MODE_*
	 * @return string
	 * @throws TeenvioException
	 */
	public function getContactsStatSection($id,$section=self::STAT_SECTION_ALL,$outputMode=self::OUTPUT_MODE_JSON){
		$data=array();
		$data['action']='get_contacts_stat_section';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['mode']=$outputMode;
		$data['eid']=$id;
		$data['section']=$section;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="KO"){
			throw new TeenvioException($bruto);
		}
		
		return $bruto;
	}
	
	/**
	 * Send Email/campaing
	 * @param int $idGroup
	 * @param int $idNewsletter
	 * @param int $idFrom
	 * @param string $name Interal private name
	 * @param string $subject 
	 * @param string $analytics
	 * @param boolean $header Header with link for reading into navigator
	 * @param boolean $headerShare Header with links for sharing into social networks
	 * @param boolean $socialFoot Foot with links for your social networks profiles
	 * @return int New Campaing/Stat Id
	 * @throws TeenvioException
	 */
	public function sendEmail($idGroup,$idNewsletter,$idFrom,$name,$subject,$analytics='',$header=true,$headerShare=false,$socialFoot=false){
		$data=array();
		$data['action']='send_campaign';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['gid']=$idGroup;
		$data['pid']=$idNewsletter;
		$data['rid']=$idFrom;
		$data['name']=$name;
		$data['subject']=$subject;
		$data['analytics']=$analytics;
		$data['cab']=($header) ? 1 : 0;
		$data['share']=($headerShare) ? 1 : 0;
		$data['social_foot']=($socialFoot) ? 1 : 0;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="OK"){
			return (int) substr($bruto,3);
		}
		
		throw new TeenvioException($bruto);
	}
	
	/**
	 * Send Email/campaing to one contact
	 * @param int $idContact
	 * @param int $idNewsletter
	 * @param int $idFrom
	 * @param string $name Interal private name
	 * @param string $subject 
	 * @param string $analytics
	 * @param boolean $header Header with link for reading into navigator
	 * @param boolean $headerShare Header with links for sharing into social networks
	 * @param boolean $socialFoot Foot with links for your social networks profiles
	 * @return int New Campaing/Stat Id
	 * @throws TeenvioException
	 */
	public function sendEmailUnique($idContact,$idNewsletter,$idFrom,$name,$subject,$analytics='',$header=true,$headerShare=false,$socialFoot=false){
		$data=array();
		$data['action']='send_campaign';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['contact_id']=$idContact;
		$data['pid']=$idNewsletter;
		$data['rid']=$idFrom;
		$data['name']=$name;
		$data['subject']=$subject;
		$data['analytics']=$analytics;
		$data['cab']=($header) ? 1 : 0;
		$data['share']=($headerShare) ? 1 : 0;
		$data['social_foot']=($socialFoot) ? 1 : 0;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="OK"){
			return (int) substr($bruto,3);
		}
		
		throw new TeenvioException($bruto);
	}
	
	/**
	 * Return response from Server
	 * @param array $data
	 * @throws TeenvioException
	 */
	private function getResponse($data){
		
		$url=$this->urlBase;
		$context=null;
		
		switch($this->apiMethod){
			case 'post':
				//POST: create a build_query
				$data=http_build_query($data);
				
				$context = stream_context_create(array(
					'http' => array(
						'ignore_errors' => true,	//Enable response with http return code != 200
						'method' => 'POST',
						'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
							. "Content-Length: " . strlen($data) . "\r\n"
							. "User-Agent: Robot APIClientPOST - ".self::clientVersion,
						'content' => $data
					)
				));
				break;
			case 'get':
				//GET: create a url with all data params
				$url.='?';
				foreach($data as $name=>$value){
					$url.=$name.'='.urlencode($value).'&';
				}
				
				$context = stream_context_create(array(
					'http' => array(
						'ignore_errors' => true,	//Enable response with http return code != 200
						'method' => 'GET',
						'header'=> "User-Agent: Robot APIClientPOST - ".self::clientVersion
					)
				));
				break;
			default:			
				throw new TeenvioException('method not valid');
		}
		
		$response=file_get_contents($url,false,$context);
		
		$this->lastResponse=$response;

		if ($response!==false && substr($response,0,2)=='OK'){
			//OK
			return $response;
		}else{
			//KO/FAIL
			return $response;
		}
	}
	
}

class TeenvioException extends \Exception{}

?>
