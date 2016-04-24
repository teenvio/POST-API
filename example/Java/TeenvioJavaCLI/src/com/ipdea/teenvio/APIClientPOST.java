package com.ipdea.teenvio;

import org.json.JSONObject;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

/**
 * @author Victor J. Chamorro - victor@ipdea.com
 * @copyright (c) Teenvio/Ipdea Land
 * @license LGPL v3
 */
public class APIClientPOST {

    public static final String clientVersion="1.0-java-20160424";

    /**
     * Outputs Mode 
     */
    public static final String OUTPUT_MODE_PLAIN="PLAIN";
    public static final String OUTPUT_MODE_JSON="JSON";
    public static final String OUTPUT_MODE_XML="XML";
    public static final String OUTPUT_MODE_CSV="CSV";

    /**
     * Stat Section
     */
    public static final String STAT_SECTION_ALL="ALL";
    public static final String STAT_SECTION_SEND="SEND";
    public static final String STAT_SECTION_SEND_OPENED="SEND_OPENED";
    public static final String STAT_SECTION_SEND_OPENED_ACTIVE="SEND_OPENED_ACTIVE";
    public static final String STAT_SECTION_SEND_OPENED_UNSUBSCRIBED="SEND_OPENED_UNSUBSCRIBED";
    public static final String STAT_SECTION_SEND_UNOPENED="SEND_UNOPENED";
    public static final String STAT_SECTION_SEND_UNOPENED_DELIVERED="SEND_UNOPENED_DELIVERED";
    public static final String STAT_SECTION_SEND_UNOPENED_BOUNCED="SEND_UNOPENED_BOUNCED";
    public static final String STAT_SECTION_UNSEND="UNSEND";
    public static final String STAT_SECTION_UNSEND_UNSUBSCRIBED="UNSEND_UNSUBSCRIBED";
    public static final String STAT_SECTION_UNSEND_UNSUBSCRIBED_VOLUNTARY="UNSEND_UNSUBSCRIBED_VOLUNTARY";
    public static final String STAT_SECTION_UNSEND_UNSUBSCRIBED_AUTOMATIC="UNSEND_UNSUBSCRIBED_AUTOMATIC";
    public static final String STAT_SECTION_UNSEND_FAILED="UNSEND_FAILED";
    public static final String STAT_SECTION_UNSEND_FAILED_NOMENCLATURE="UNSEND_FAILED_NOMENCLATURE";
    public static final String STAT_SECTION_CLICKED="UNSEND_FAILED_NOMENCLATURE";

    /**
     * URL API Post
     */
    private static final String urlBase="https://master2.teenvio.com/v4/public/api/post/";

    /**
     * User
     */
    private String user="";

    /**
     * Plan/Account
     */
    private String plan="";

    /**
     * Passwrod
     */
    private String pass="";

    /**
     * HTTP Method
     */
    private String apiMethod="post";

    /**
     * Las response from server
     */
    private String lastResponse="";

    /**
     *
     * @param user Username
     * @param plan Name acount
     * @param pass Pass
     */
    public APIClientPOST(String user,String plan,String pass){
        this.user=user;
        this.plan=plan;
        this.pass=pass;
    }

    /**
     * Set POST HTTP method
     * @deprecated method post not implemented
     */
    public void setMethodPOST(){
        this.apiMethod="post";
    }

    /**
     * Set GET HTTP method
     */
    public void setMethodGET(){
        this.apiMethod="get";
    }

    /**
     * Client Version
     */
    public String getClientVersion(){
        return APIClientPOST.clientVersion;
    }

    /**
     * Server Version
     * @return Server Version Info
     * @throws Exception
     */
    public String getServerVersion() throws Exception {
        Map<String,String> data = new HashMap<String, String>();

        data.put("action","get_version");

        String raw=this.getResponse(data);

        if (raw.substring(0,2).equals("OK")){
            return raw.substring(3);
        }

        throw new Exception(raw);
    }

    /**
     * Check the current connection.
     * If this method returns false any setup fails.
     */
    public Boolean ping(){
        try{
            this.getServerVersion();
            return (this.lastResponse.substring(0,2).equals("OK"));
        }catch(Exception $e){
            return false;
        }
    }

    /**
     * Save a contact. For all keys names check the pdf document
     * @param data Map
     * @return New contact Id
     * @throws Exception
     * @link https://github.com/teenvio/POST-API/blob/master/doc/POST-API_es.pdf
     */
    public Integer saveContact(Map<String,String> data) throws Exception{

        data.put("action","contact_save");

        String raw=this.getResponse(data);

        if (raw.substring(0,2).equals("OK")){
            return Integer.valueOf(raw.substring(3));
        }

        throw new Exception(raw);

    }

    /**
     * Delete a contact.
     * @param email Email contact
     * @throws Exception
     */
    public void deleteContact(String email) throws Exception{

        Map<String,String> data = new HashMap<String,String>();
        data.put("action","contact_delete");
        data.put("email",email);


        String raw=this.getResponse(data);

        if (!raw.substring(0,2).equals("OK")){
            throw new Exception(raw);
        }
    }

    /**
     * Save group
     * @param name Group Name
     * @param description Group Description
     * @param idGroup For update data
     * @return idGroup
     */
    public Integer saveGroup(String name,String description,Integer idGroup) throws Exception{
        Map<String,String> data = new HashMap<String,String>();
        data.put("action","group_save");
        data.put("name",name);
        data.put("description",description);
        if (idGroup!=0) {
            data.put("gid", idGroup.toString());
        }

        String raw=this.getResponse(data);

        if (!raw.substring(0,2).equals("OK")){
            throw new Exception(raw);
        }
        return Integer.valueOf(raw.substring(3));
    }

    public Integer saveGroup(String name,String description) throws Exception{
        return this.saveGroup(name,description,0);
    }

    public Integer saveGroup(String name) throws Exception{
        return this.saveGroup(name,"",0);
    }

    /**
     * Delete group
     * @param idGroup Group id
     * @throws Exception
     */
    public void deleteGroup(Integer idGroup) throws Exception{
        Map<String,String> data = new HashMap<String,String>();
        data.put("action","group_delete");
        data.put("gid",idGroup.toString());

        String raw=this.getResponse(data);

        if (!raw.substring(0,2).equals("OK")){
            throw new Exception(raw);
        }
    }

    /**
     * Add a contact into selected group
     * @param email Email contact
     * @param idGroup group ip
     * @throws Exception
     */
    public void groupContact(String email, Integer idGroup) throws Exception{
        Map<String,String> data = new HashMap<String,String>();
        data.put("action","contact_group");
        data.put("gid",idGroup.toString());
        data.put("email",email);

        String raw=this.getResponse(data);

        if (!raw.substring(0,2).equals("OK")){
            throw new Exception(raw);
        }
    }

    /**
     * Remove a contact into selected group
     * @param email Email contact
     * @param idGroup group ip
     * @throws Exception
     */
    public void ungroupContact(String email, Integer idGroup) throws Exception{
        Map<String,String> data = new HashMap<String,String>();
        data.put("action","contact_ungroup");
        data.put("gid",idGroup.toString());
        data.put("email",email);

        String raw=this.getResponse(data);

        if (!raw.substring(0,2).equals("OK")){
            throw new Exception(raw);
        }
    }

    /**
     * Deactivate contact into selected sender
     * @param email Email contact
     * @param idFrom Sender
     * @throws Exception
     */
    public void deactivateContact(String email, Integer idFrom) throws Exception{
        Map<String,String> data = new HashMap<String,String>();
        data.put("action","contact_deactivate");
        data.put("rid",idFrom.toString());
        data.put("email",email);

        String raw=this.getResponse(data);

        if (!raw.substring(0,2).equals("OK")){
            throw new Exception(raw);
        }
    }

    /**
     * Activate contact into selected sender
     * @param email Email contact
     * @param idFrom Sender
     * @throws Exception
     */
    public void activateContact(String email, Integer idFrom) throws Exception{
        Map<String,String> data = new HashMap<String,String>();
        data.put("action","contact_activate");
        data.put("rid",idFrom.toString());
        data.put("email",email);

        String raw=this.getResponse(data);

        if (!raw.substring(0,2).equals("OK")){
            throw new Exception(raw);
        }
    }

    /**
     * Return all contact data: fields, groups and campaigns
     * @param email contact email
     * @param outputMode Use the const OUTPUT_MODE_*
     */
    public String getContactData(String email,String outputMode) throws Exception{

        Map<String,String> data = new HashMap<String,String>();
        data.put("action","contact_data");
        data.put("email",email);
        data.put("mode",outputMode);

        String raw=this.getResponse(data);

        if (!raw.substring(0,2).equals("OK")){
            throw new Exception(raw);
        }

        return raw;
    }
    /**
     * Return JSON Object with all contact data: fields, groups and campaigns
     * @param email contact email
     */
    public String getContactData(String email) throws Exception{
        return this.getContactData(email,APIClientPOST.OUTPUT_MODE_JSON);
    }

    /**
     * Return stats in $outputMode Format
     * Use the const self::OUTPUT_MODE_* for $outputMode
     * @param id Stats / Campaign id
     * @param outputMode Use the consts self::OUTPUT_MODE_*
     * @return string
     * @throws Exception
     */
    public String getStats(Integer id,String outputMode) throws Exception{

        Map<String,String> data = new HashMap<String,String>();
        data.put("action","get_stats");
        data.put("eid",id.toString());
        data.put("mode",outputMode);

        String raw=this.getResponse(data);

        if (raw.trim().equals("")){
            throw new Exception(raw);
        }

        return raw;
    }

    /**
     * Return stats in $outputMode Format
     * Use the const self::OUTPUT_MODE_* for $outputMode
     * @param id Stats / Campaign id
     * @return string
     * @throws Exception
     */
    public String getStats(Integer id) throws Exception{
        return this.getStats(id,APIClientPOST.OUTPUT_MODE_JSON);
    }

    /**
     * Get contacts from section into stat
     * @param id id stat/campaign
     * @param section Use the const STAT_SECTION_*
     * @param outputMode Use the const OUTPUT_MODE_*
     * @return string
     * @throws Exception
     */
    public String getContactsStatSection(Integer id,String section,String outputMode) throws Exception{

        Map<String,String> data = new HashMap<String,String>();
        data.put("action","get_contacts_stat_section");
        data.put("eid",id.toString());
        data.put("mode",outputMode);
        data.put("section",section);

        String raw=this.getResponse(data);

        if (!raw.substring(0,2).equals("OK")){
            throw new Exception(raw);
        }

        return raw;
    }

    /**
     * Send Email/campaign
     * @param idGroup Group Id
     * @param idNewsletter Newsletter Id
     * @param idFrom Sender / From Id
     * @param name Internal private name
     * @param subject Email subject
     * @param analytics String for Google Analytics, empty = disabled
     * @param header Header with link for reading into navigator
     * @param headerShare Header with links for sharing into social networks
     * @param socialFoot Foot with links for your social networks profiles
     * @return New Campaign/Stat Id
     * @throws Exception
     */
    public Integer sendEmail(Integer idGroup,Integer idNewsletter,Integer idFrom,String name,String subject,String analytics,Boolean header, Boolean headerShare,Boolean socialFoot) throws Exception{
        Map<String,String> data = new HashMap<String,String>();
        data.put("action","send_campaign");
        data.put("gid",idGroup.toString());
        data.put("pid",idNewsletter.toString());
        data.put("rid",idFrom.toString());
        data.put("name",name);
        data.put("subject",subject);
        data.put("analytics",analytics);
        data.put("cab",(header ? "1": "0"));
        data.put("share",(headerShare ? "1": "0"));
        data.put("social_foot",(socialFoot? "1": "0"));

        String raw=this.getResponse(data);

        if (!raw.substring(0,2).equals("OK")){
            throw new Exception(raw);
        }

        return Integer.valueOf(raw.substring(3).trim());
    }

    /**
     * Send Email/campaign
     * @param idContact Contact Id
     * @param idNewsletter Newsletter Id
     * @param idFrom Sender / From Id
     * @param name Internal private name
     * @param subject Email subject
     * @param analytics String for Google Analytics, empty = disabled
     * @param header Header with link for reading into navigator
     * @param headerShare Header with links for sharing into social networks
     * @param socialFoot Foot with links for your social networks profiles
     * @return New Campaign/Stat Id
     * @throws Exception
     */
    public Integer sendEmailUnique(Integer idContact,Integer idNewsletter,Integer idFrom,String name,String subject,String analytics,Boolean header, Boolean headerShare,Boolean socialFoot, Map<String,String> vars) throws Exception{
        Map<String,String> data = new HashMap<String,String>();
        data.put("action","send_campaign");
        data.put("contact_id",idContact.toString());
        data.put("pid",idNewsletter.toString());
        data.put("rid",idFrom.toString());
        data.put("name",name);
        data.put("subject",subject);
        data.put("analytics",analytics);
        data.put("cab",(header ? "1": "0"));
        data.put("share",(headerShare ? "1": "0"));
        data.put("social_foot",(socialFoot? "1": "0"));
        data.put("vars",(new JSONObject(vars)).toString());

        String raw=this.getResponse(data);

        if (!raw.substring(0,2).equals("OK")){
            throw new Exception(raw);
        }

        return Integer.valueOf(raw.substring(3).trim());
    }

    /**
     * @param data MAP URL parameters
     * @return String raw response
     */
    private String getResponse(Map<String,String> data){
        String raw="";
        switch (this.apiMethod){
            case "get":
                raw=this.URLGet(data);
            break;
            default:
                System.out.println(this.apiMethod+" not supported");
        }
        this.lastResponse=raw;
        return raw;
    }

    /**
     * GET HTTP petition
     *
     * @param data MAP URL parameters
     * @return String
     */
    private String URLGet(Map<String,String> data){

        data.put("plan",this.plan);
        data.put("user",this.user);
        data.put("pass",this.pass);

        String sUrl= APIClientPOST.urlBase+"?";

        for (String key : data.keySet()){
            sUrl+=key+"="+data.get(key)+"&";
        }

        //System.out.println(sUrl);

        String buffer ="";

        try {
            URL url = new URL(sUrl);
            BufferedReader in = new BufferedReader(new InputStreamReader(url.openStream()));
            String str;
            while ((str = in.readLine()) != null) {
                buffer+=str;
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        return buffer;
    }

    /**
     * GET HTTP petition
     *
     * @param data MAP URL parameters
     * @return JSONObject
     */
    /*private JSONObject UrlGetJson(Map<String,String> data){
        JSONObject buffer=null;
        String sBuffer;

        sBuffer = this.URLGet(data);
        try {
            buffer= (JSONObject) new JSONTokener(sBuffer).nextValue();
        } catch (JSONException e) {
            e.printStackTrace();
        }

        return buffer;
    }*/


}
