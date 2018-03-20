<?php
namespace Teenvio;
require_once __DIR__.'/APIException.php';

/**
 * @package API
 * @author Víctor J. Chamorro <victor@ipdea.com>
 * @copyright (c) Teenvio/Ipdea Land
 * @license LGPL v3
 * @link https://github.com/teenvio/POST-API/blob/master/doc/POST-API_es.pdf
 */
class APIClientPOST{
	
	/**
	 * @var string
	 */
	const clientVersion="2.4-php-201707";
	
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
	private $urlBase="https://central1.teenvio.com/v4/public/api/post/";
	
	/**
	 * URL API Post
	 * @var string
	 */
	private $urlCall="";
	
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
	 * @throws \Teenvio\TeenvioException
	 */
	public function __construct($user,$plan,$pass) {
		$this->user=$user;
		$this->plan=$plan;
		$this->pass=$pass;
		
		if (!$this->ping()){
			throw new TeenvioException($this->lastResponse);
		}
		
		if ($this->urlCall=="") {
			//Calculate the URL Call for acount
			$this->urlCall=$this->getURLCall();
		}
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
			return (int) substr($bruto,4);
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
	 * @param string $senderId
	 * @throws TeenvioException
	 */
	public function deactivateContact($email,$senderId){
		$data=array();
		$data['action']='contact_deactivate';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['email']=$email;
		$data['rid']=$senderId;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)!="OK"){
			throw new TeenvioException($bruto);
		}
	}
	
	/**
	 * Activate Contact from sender
	 * @param string $email
	 * @param string $senderId
	 * @throws TeenvioException
	 */
	public function activateContact($email,$senderId){
		$data=array();
		$data['action']='contact_activate';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['email']=$email;
		$data['rid']=$senderId;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)!="OK"){
			throw new TeenvioException($bruto);
		}
	}
	
	/**
	 * Return all ocntacta data: fields, groups and campaings
	 * @param string $email
	 * @param string $outputMode Use the consts self::OUTPUT_MODE_*
	 * @throws TeenvioException
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
	 * Return fields names and internal names from contacts
	 * @param string $outputMode Use the consts self::OUTPUT_MODE_*
	 * @throws TeenvioException
	 */
	public function getContactFields($outputMode=self::OUTPUT_MODE_JSON){
		$data=array();
		$data['action']='contact_fields';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['mode']=$outputMode;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="KO"){
			throw new TeenvioException($bruto);
		}
		
		return $bruto;
	}
	
	/**
	 * Return group data
	 * @param int $gid
	 * @param string $outputMode Use the consts self::OUTPUT_MODE_*
	 * @throws TeenvioException
	 */
	public function getGroupData($gid,$outputMode=self::OUTPUT_MODE_JSON){
		$data=array();
		$data['action']='group_data';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['gid']=$gid;
		$data['mode']=$outputMode;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="KO"){
			throw new TeenvioException($bruto);
		}
		
		return $bruto;
	}
	
	/**
	 * Return group contacts list
	 * @param int $gid
	 * @param string $outputMode Use the consts self::OUTPUT_MODE_*
	 * @throws TeenvioException
	 */
	public function getGroupContacts($gid,$outputMode=self::OUTPUT_MODE_JSON){
		$data=array();
		$data['action']='group_list_contacts';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['gid']=$gid;
		$data['mode']=$outputMode;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="KO"){
			throw new TeenvioException($bruto);
		}
		
		return $bruto;
	}
	
	/**
	 * Get groups list
	 * @param string $outputMode Use the consts self::OUTPUT_MODE_*
	 * @throws TeenvioException
	 */
	public function getGroupList($outputMode=self::OUTPUT_MODE_JSON){
		$data=array();
		$data['action']='group_list';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
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
	 * Return from in $outputMode Format
	 * Use the consts self::OUTPUT_MODE_* for $outputMode
	 * @param int $id
	 * @param string $outputMode Use the consts self::OUTPUT_MODE_*
	 * @return string
	 * @throws TeenvioException
	 */
	public function getAccountData($outputMode=self::OUTPUT_MODE_XML){
		$data=array();
		$data['action']='get_acount_data';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['mode']=$outputMode;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="KO"){
			throw new TeenvioException($bruto);
		}
		
		return $bruto;
	}
	
	/**
	 * Return from in $outputMode Format
	 * Use the consts self::OUTPUT_MODE_* for $outputMode
	 * @param int $id
	 * @param string $outputMode Use the consts self::OUTPUT_MODE_*
	 * @return string
	 * @throws TeenvioException
	 */
	public function getFrom($id,$outputMode=self::OUTPUT_MODE_XML){
		$data=array();
		$data['action']='get_from';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['mode']=$outputMode;
		$data['rid']=$id;
		
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
	 * Get last ids Campaings/Stats
	 * @param int $limit
	 * @return int[]
	 * @throws TeenvioException
	 */
	public function getCampaigns($limit=25){
		$data=array();
		$data['action']='get_campaigns';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['mode']='plain';
		$data['limit']=$limit;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="KO"){
			throw new TeenvioException($bruto);
		}
		
		$exit=explode("\n",$bruto);
		array_walk($exit,function(&$item){
			$item=(int)$item;
		});
		
		return $exit;
	}
	
	/**
	 * Send Email/campaign
	 * @param int $idGroup
	 * @param int $idNewsletter
	 * @param int $senderId
	 * @param string $name Interal private name
	 * @param string $subject 
	 * @param string $analytics
	 * @param boolean $header Header with link for reading into navigator
	 * @param boolean $headerShare Header with links for sharing into social networks
	 * @param boolean $socialFoot Foot with links for your social networks profiles
	 * @param array $vars Associative Array (table hash) for parse custom vars into email
	 * @return int New Campaing/Stat Id
	 * @throws TeenvioException
	 */
	public function sendEmail($idGroup,$idNewsletter,$senderId,$name,$subject,$analytics='',$header=true,$headerShare=false,$socialFoot=false,$vars=null){
		$data=array();
		$data['action']='send_campaign';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['gid']=$idGroup;
		$data['pid']=$idNewsletter;
		$data['rid']=$senderId;
		$data['name']=$name;
		$data['subject']=$subject;
		$data['analytics']=$analytics;
		$data['cab']=($header) ? 1 : 0;
		$data['share']=($headerShare) ? 1 : 0;
		$data['social_foot']=($socialFoot) ? 1 : 0;
		if (is_array($vars)){
			$data['vars']=json_encode($vars);
		}
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="OK"){
			return (int) substr($bruto,4);
		}
		
		throw new TeenvioException($bruto);
	}
	
	/**
	 * Send Email/campaing to one contact
	 * @param int $idContact
	 * @param int $idNewsletter
	 * @param int $senderId
	 * @param string $name Interal private name
	 * @param string $subject 
	 * @param string $analytics
	 * @param boolean $header Header with link for reading into navigator
	 * @param boolean $headerShare Header with links for sharing into social networks
	 * @param boolean $socialFoot Foot with links for your social networks profiles
	 * @param array $vars Associative Array (table hash) for parse custom vars into email
	 * @return int New Campaing/Stat Id
	 * @throws TeenvioException
	 */
	public function sendEmailUnique($idContact,$idNewsletter,$senderId,$name,$subject,$analytics='',$header=true,$headerShare=false,$socialFoot=false,$vars=null){
		$data=array();
		$data['action']='send_campaign';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['contact_id']=$idContact;
		$data['pid']=$idNewsletter;
		$data['rid']=$senderId;
		$data['name']=$name;
		$data['subject']=$subject;
		$data['analytics']=$analytics;
		$data['cab']=($header) ? 1 : 0;
		$data['share']=($headerShare) ? 1 : 0;
		$data['social_foot']=($socialFoot) ? 1 : 0;
		if (is_array($vars)){
			$data['vars']=json_encode($vars);
		}
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="OK"){
			return (int) substr($bruto,4);
		}
		
		throw new TeenvioException($bruto);
	}
	
	/**
	 * Save Newsletter
	 * @param string $name Newsletter name
	 * @param string $html HTML
	 * @param string $plain Text Plain
	 * @param int $idNewsletter Id newsletter, for update data
	 * @return int Id saved newsletter
	 * @throws TeenvioException
	 */
	public function saveNewsletter($name,$html,$plain="",$idNewsletter=0){
		$data=array();
		$data['action']='newsletter_save';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		
		$data['id_newsletter']=$idNewsletter;
		$data['name']=$name;
		$data['html']=$html;
		$data['plain']=$plain;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="OK"){
			return (int) substr($bruto,4);
		}
		
		throw new TeenvioException($bruto);
	}
	
	/**
	 * Delete Newsletter
	 * @param int $idNewsletter
	 * @throws TeenvioException
	 */
	public function deleteNewsletter($idNewsletter){
		$data=array();
		$data['action']='newsletter_delete';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		
		$data['id_newsletter']=$idNewsletter;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)!="OK"){
			throw new TeenvioException($bruto);
		}
	}
	
	/**
	 * Get Newsletter data
	 * @param type $idNewsletter
	 * @param type $outputMode Use the consts self::OUTPUT_MODE_*
	 * @return string
	 * @throws TeenvioException
	 */
	public function getNewsletterData($idNewsletter,$outputMode=self::OUTPUT_MODE_JSON){
		$data=array();
		$data['action']='newsletter_data';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		
		$data['mode']=$outputMode;
		$data['id_newsletter']=$idNewsletter;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="KO"){
			throw new TeenvioException($bruto);
		}
		
		return $bruto;
	}

	/**
	 * Get the hotzones from sent Newsletter 
	 * @param String $eid
	 * @return String HTML string
	 * @throws TeenvioException
	 */
	public function getStatsHotZones($eid){
		$data=array();
		$data['action']='get_stats_hotzones';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['eid']=$eid;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="KO"){
			throw new TeenvioException($bruto);
		}
		
		return $bruto;
		
	}
	
	/**
	 * Get the graphs from sent Newsletter 
	 * @param String $eid
	 * @return String HTML string
	 * @throws TeenvioException
	 */
	public function getStatsGraphs($eid){
		$data=array();
		$data['action']='get_stats_graphs';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['eid']=$eid;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="KO"){
			throw new TeenvioException($bruto);
		}
		
		return $bruto;
		
	}
	
	/**
	 * Upload a file
	 * @param string $name
	 * @param string $raw Binary/raw content
	 * @param string $path
	 * @return string Public URL
	 * @throws TeenvioException
	 */
	public function uploadFile($name,$raw,$path='/'){
		$data=array();
		$data['action']='newsletter_add_file';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['name']=$name;
		$data['path']=$path;
		$data['content']=  base64_encode($raw);
		$data['encoding']= 'base64';
				
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="OK"){
			return substr($bruto,4);
		}
		
		throw new TeenvioException($bruto);
	}
	
	/**
	 * Get sender list
	 * @param string $outputMode Use the consts self::OUTPUT_MODE_*
	 * @throws TeenvioException
	 */
	public function getSenderList($outputMode=self::OUTPUT_MODE_JSON){
		$data=array();
		$data['action']='sender_list';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		$data['mode']=$outputMode;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="KO"){
			throw new TeenvioException($bruto);
		}
		
		return $bruto;
	}
	
	/**
	 * Get URL Call for acount
	 * @return string
	 * @throws TeenvioException
	 */
	public function getURLCall(){
		$data=array();
		$data['action']='get_url_call';
		$data['plan']=$this->plan;
		$data['user']=$this->user;
		$data['pass']=$this->pass;
		
		$bruto=$this->getResponse($data);
		
		if (substr($bruto,0,2)=="OK"){
			return substr($bruto,4);
		}
		
		throw new TeenvioException($bruto);
	}
	
	/**
	 * Return response from Server
	 * @param array $data
	 * @throws TeenvioException
	 */
	private function getResponse($data){
		
		$data['client']=self::clientVersion;
		
		$url=$this->urlCall;
		
		if ($this->urlCall==""){
			$url=$this->urlBase;
		}
		
		$context=null;
		
		if (ini_get('allow_url_fopen')=="1"){
			
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

			$this->lastResponse=file_get_contents($url,false,$context);
			
		}elseif (function_exists('curl_init')){
				
			switch($this->apiMethod){
				case 'post':
					$curl_sesion = curl_init($url);
					if ($curl_sesion){
						curl_setopt($curl_sesion, CURLOPT_POST, true);
						curl_setopt($curl_sesion, CURLOPT_POSTFIELDS, $data);
						curl_setopt($curl_sesion, CURLOPT_HEADER, false);
						curl_setopt($curl_sesion, CURLOPT_USERAGENT, 'Robot APIClientPOST - '.self::clientVersion);
						curl_setopt($curl_sesion, CURLOPT_RETURNTRANSFER, true);
						$this->lastResponse=curl_exec($curl_sesion);
						curl_close($curl_sesion);
					}
					break;
				case 'get':
					$url.='?';
					foreach($data as $name=>$value){
						$url.=$name.'='.urlencode($value).'&';
					}
					$curl_sesion = curl_init($url);
					if ($curl_sesion){
						curl_setopt($curl_sesion, CURLOPT_HEADER, false);
						curl_setopt($curl_sesion, CURLOPT_USERAGENT, 'Robot APIClientPOST - '.self::clientVersion);
						curl_setopt($curl_sesion, CURLOPT_RETURNTRANSFER, true);
						$this->lastResponse=curl_exec($curl_sesion);
						curl_close($curl_sesion);
					}
					break;
				default:			
					throw new TeenvioException('method not valid');
			}
		}else{
			return 'KO: Remote connections are not enable. Please contact to hosting administrator: allow_url_fopen disabled and cURL not enabled';
		}
		
		
		if ($this->lastResponse!==false && substr($this->lastResponse,0,2)=='OK'){
			//OK
			return $this->lastResponse;
		}else{
			//KO/FAIL
			return $this->lastResponse;
		}
	}
	
}

?>
