package com.ipdea.teenvio;

import org.json.JSONObject;

public class TeenvioJavaCLI {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		
		Integer idCampaing=0;
		
		if (args.length < 3){
			System.out.println("Usage: teenviojavacli [user] [plan/account] [password]");
			return;
		}
		if (args.length>3){
			idCampaing= Integer.parseInt(args[3]);
		}
		
		APIClientPOST api = new APIClientPOST(args[0], args[1], args[2]);
		api.setMethodGET();
		
		if (api.ping()){
			System.out.println("Ok, you are connected!");
			
			try {
				System.out.println("Stats Campaign Id: "+idCampaing);
				String stats = api.getStats(idCampaing);
				System.out.println(stats);
				JSONObject json = new JSONObject(stats);
				String asunto = json.get("subject").toString();
				String openeds = json.get("views_unique").toString();
				
				//Main Data
				System.out.println("Subject: "+asunto);
				System.out.println("Openeds: "+openeds);
				
				//Tree Data
				JSONObject tree=json.getJSONObject("contacts");
				
				System.out.println("All Contacts: "+tree.getInt("all"));
				
				JSONObject send = tree.getJSONObject("send");			
				JSONObject unsend = tree.getJSONObject("unsend");
				
				JSONObject opened = send.getJSONObject("opened");
				JSONObject unopened = send.getJSONObject("unopened");
				//Etc...
				
				
				System.out.println("- Contacts send: "+send.getInt("all"));
				System.out.println("  - Contacts opened: "+opened.getInt("all"));
				System.out.println("  - Contacts unopened: "+unopened.getInt("all"));
				System.out.println("- Contacts unsend: "+unsend.getInt("all"));
				//Etc....
				
			} catch (Exception e) {
				
				//e.printStackTrace();
				System.out.println("Failed to get stats from campaign "+idCampaing);
			}
			
			
		}else{
			System.out.println("Error to connect, check the credential data");
		}
		
	}

}
