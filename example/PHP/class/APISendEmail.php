<?php
namespace Teenvio;
require_once __DIR__.'/APIException.php';
require_once __DIR__.'/APISendEmail.php';

/**
 * Object for send emails under Teenvio API
 * @package API
 * @author Víctor J. Chamorro <victor@ipdea.com>
 * @copyright (c) Teenvio/Ipdea Land
 * @license LGPL v3
 */
class APISendEmail{

	/**
	 * Instance APIClientPOST
	 * @var \Teenvio\APIClientPOST
	 */
	private $api=null;
	
	/**
	 * @var string
	 */
	private $subject="";
	
	/**
	 * @var string
	 */
	private $name="";
	
	/**
	 * @var int
	 */
	private $senderId=0;
	
	/**
	 * @var int
	 */
	private $idGroup=0;
	
	/**
	 * @var int
	 */
	private $idContact=0;
	
	/**
	 * @var int
	 */
	private $idNewsletter=0;
	
	/**
	 * @var string
	 */
	private $analytics="";
	
	/**
	 * @var boolean
	 */
	private $header=true;
	
	/**
	 * @var boolean
	 */
	private $socialFooter=false;
	
	/**
	 * @var boolean
	 */
	private $shareHeader=false;
	
	/**
	 * @var string[string]
	 */
	private $vars=array();
		
	/**
	 * Object for Send emails under Teenvio API
	 * @param \Teenvio\APIClientPOST $apiInstance
	 * @throws TeenvioException
	 */
	public function __construct(\Teenvio\APIClientPOST $apiInstance) {
		
		if (!$apiInstance instanceof APIClientPOST){
			throw new TeenvioException('$apiInstance is not instance of APIClientPOST');
		}
		$this->api=$apiInstance;
	}
	
	/**
	 * @return string
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function getSenderId() {
		return $this->senderId;
	}

	/**
	 * @return int
	 */
	public function getIdGroup() {
		return $this->idGroup;
	}

	/**
	 * @return int
	 */
	public function getIdContact() {
		return $this->idContact;
	}

	/**
	 * @return int
	 */
	public function getIdNewsletter() {
		return $this->idNewsletter;
	}

	/**
	 * @return string
	 */
	public function getAnalytics() {
		return $this->analytics;
	}

	/**
	 * @return int
	 */
	public function getHeader() {
		return $this->header;
	}

	/**
	 * @return int
	 */
	public function getSocialFooter() {
		return $this->socialFooter;
	}

	/**
	 * @return int
	 */
	public function getShareHeader() {
		return $this->shareHeader;
	}

	/**
	 * Email Subject
	 * @param string $subject
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
	}

	/**
	 * Internal/private Name
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Teenvio Id of Sender
	 * @param int $senderId
	 */
	public function setSenderId($senderId) {
		$this->senderId = (int) $senderId;
	}

	/**
	 * Teenvio Id of Group
	 * @param int $idGroup
	 */
	public function setIdGroup($idGroup) {
		$this->idGroup = (int) $idGroup;
	}

	/**
	 * Teenvio Id of Contact
	 * @param int $idContact
	 */
	public function setIdContact($idContact) {
		$this->idContact = (int) $idContact;
	}

	/**
	 * Teenvio Id of Newsletter
	 * @param int $idNewsletter
	 */
	public function setIdNewsletter($idNewsletter) {
		$this->idNewsletter = (int) $idNewsletter;
	}

	/**
	 * Text for Google Analytics param
	 * @param string $analytics
	 */
	public function setAnalytics($analytics) {
		$this->analytics = $analytics;
	}

	/**
	 * Enable the email top bar: link of read into browser
	 * @param boolean $cab
	 */
	public function setHeader($header) {
		$this->header = (bool) $header;
	}

	/**
	 * Enable social footer: buttons of social networ profiles
	 * @param boolean $socialFooter
	 */
	public function setSocialFooter($socialFooter) {
		$this->socialFooter = (bool) $socialFooter;
	}

	/**
	 * Enable extra top bar for share social buttons
	 * @param boolean $shareHeader
	 */
	public function setShareHeader($shareHeader) {
		$this->shareHeader = (bool) $shareHeader;
	}
	
	/**
	 * Add a custom var for the campaing
	 * @param string $varName
	 * @param string $varContent
	 */
	public function setVar($varName,$varContent){
		$this->vars[$varName]=$varContent;
	}

	/**
	 * Send email, return the campaing id
	 * @return int
	 * @throws TeenvioException
	 */
	public function send(){
		
		if (empty($this->subject))  throw new TeenvioException('Subject is empty');
		if (empty($this->name))     throw new TeenvioException('Name is empty');
		if ($this->senderId==0)     throw new TeenvioException('Sender is empty');
		if ($this->idNewsletter==0) throw new TeenvioException('Newsletter content is empty');
		if ($this->idContact==0 && $this->idGroup==0){
			throw new TeenvioException('No recipients: select any group or any contact');
		}
		
		$response=0;
		
		if ($this->idContact!=0){
			$response=$this->api->sendEmailUnique($this->idContact, $this->idNewsletter, $this->senderId, $this->name, $this->subject, $this->analytics, $this->header, $this->shareHeader, $this->socialFooter, $this->vars);
		}else{
			$response=$this->api->sendEmail($this->idGroup, $this->idNewsletter, $this->senderId, $this->name, $this->subject, $this->analytics, $this->header, $this->shareHeader, $this->socialFooter, $this->vars);
		}
		
		return $response;
	}
	
}

?>