
//
//Sample CLI utility using TeenvioAPI
//
namespace TeenvioCLI
{

    using System;
    using Teenvio;
    using System.Collections.Generic;

    class CLI
    {
        private TeenvioAPI api;
        static void Main(string[] args){
            (new CLI()).Run();
        }

        private void Run(){
            Console.WriteLine("TeenvioCLI API sample utility v1.0");

            if (this.connect()){
                api.getServerVersion();
                string version = api.getServerVersion();
                Console.WriteLine("Connected! Server API Version: "+version);

                this.menuTest();                
            }
        }

        private bool connect(){

            try{

                string user="", plan="", pass="";
                
                if (pass.Trim()==""){
                    Console.WriteLine("Username:");
                    user=Console.ReadLine();
                    Console.WriteLine("Plan/Account:");
                    plan=Console.ReadLine();
                    Console.WriteLine("Pass:");
                    
                    ConsoleKeyInfo key = Console.ReadKey(true);

                    while (key.Key != ConsoleKey.Enter){
                        if (key.Key != ConsoleKey.Backspace){
                            pass += key.KeyChar;
                            Console.Write("*");                            
                        }else{
                            if (pass.Length>0){
                                pass=pass.Substring(0,pass.Length-1);
                            }
                        }
                        key = Console.ReadKey(true);
                    }

                    Console.WriteLine();
                }
                
                api = new TeenvioAPI(user,plan,pass);
                
            }catch(TeenvioException ex){
                Console.WriteLine(ex.Message);
                return false;
            }
            
            return true;
        }

        private void saveExampleContact(){
            Console.WriteLine();
            Console.WriteLine("- Save contact:");
            //Create the Dictionary contact data
            Dictionary<string, string> contact = new Dictionary<string,string>();
			contact.Add ("email", "api.net@teenvio.com");		//Email
			contact.Add ("nombre", "example api teenvio.com");	//Name
			contact.Add ("empresa", "teenvio.com");				//Company
			contact.Add ("eciudad", "Madrid");					//Compay city
			contact.Add ("eprovincia","Madrid");				//Company state
			contact.Add ("epais", "Spain");						//Compaty contry
			contact.Add ("dato_1", "extra data one");			//Extra data 1
			contact.Add ("dato_2", "extra data two");			//Extra data 2

			try{
				int idContact=api.SaveContact (contact, 1);
				Console.WriteLine("Contact id "+idContact+" save!");
			}catch(TeenvioException ex){
				Console.WriteLine("Fail to save contact: "+ex.Message);
			}
        }

        private void getExampleSenders(){
            Console.WriteLine();
            Console.WriteLine("- Froms/Senders:");
            
            string xml;
            try{
                xml=api.GetSenderList();
            }catch(TeenvioException ex){
				Console.WriteLine("Fail to get senders: "+ex.Message);
                return;
			}
            //Console.WriteLine(xml);
            System.Xml.XmlDocument xmlDoc = new System.Xml.XmlDocument();
            xmlDoc.LoadXml(xml);
            var nodes = xmlDoc.SelectNodes("data/*");
            foreach (System.Xml.XmlNode childrenNode in nodes){
                string line="";
                line+=childrenNode.SelectSingleNode("id[1]").InnerText;
                line+=": ";
                line+=childrenNode.SelectSingleNode("name[1]").InnerText;
                line+=" <";
                line+=childrenNode.SelectSingleNode("email[1]").InnerText;
                line+=">";
                Console.WriteLine(line);
            }
        }

        private void getExampleListGroups(){
            Console.WriteLine();
            Console.WriteLine("- Contact groups:");
            
            string xml;
            try{
                xml=api.GetGroupsList();
            }catch(TeenvioException ex){
				Console.WriteLine("Fail to get groups: "+ex.Message);
                return;
			}
            //Console.WriteLine(xml);
            System.Xml.XmlDocument xmlDoc = new System.Xml.XmlDocument();
            xmlDoc.LoadXml(xml);
            var nodes = xmlDoc.SelectNodes("data/*");
            foreach (System.Xml.XmlNode childrenNode in nodes){
                string line="";
                line+=childrenNode.SelectSingleNode("id[1]").InnerText;
                line+=": ";
                line+=childrenNode.SelectSingleNode("name[1]").InnerText;
                line+=" | Description: ";
                line+=childrenNode.SelectSingleNode("description[1]").InnerText;
                line+=" | Contacts: ";
                line+=childrenNode.SelectSingleNode("contact_count[1]").InnerText;
                Console.WriteLine(line);
            }
        }

        private void sendEmailTest(string mailTo,string subject,int idSender,string html){

            try{

                //1º create the newsletter content
                int idNewsletter=api.SaveNewsletter("Newsletter test c# api",html,"text plain");

                //2º create/update the contact
                Dictionary<string, string> contact = new Dictionary<string, string>();
                contact.Add ("email", mailTo.Trim());		//Email
                int idContact=api.SaveContact(contact);

                //3º send email/campaing
                int idCampaing = api.SendEmailUnique(idContact,idNewsletter,idSender,"Api c# test",subject);

                Console.WriteLine("- Send email id campaing: "+idCampaing.ToString());
                return;

            }catch(TeenvioException ex){
				Console.WriteLine("Fail to send test: "+ex.Message);
                return;
			}
        }

        private void menuTest(){
            Console.WriteLine();
            Console.WriteLine("**************************");
            Console.WriteLine("* Select example to run: *");
            Console.WriteLine("**************************");
            Console.WriteLine("[0] Exit");
            Console.WriteLine("[1] Save Contact");
            Console.WriteLine("[2] Get Senders");
            Console.WriteLine("[3] Get Contacts Groups");
            Console.WriteLine("[4] Send Email test");
            Console.WriteLine();

            string option = Console.ReadLine();
            
            switch(option){
                case "1":
                    this.saveExampleContact();
                    break;
                case "2":
                    this.getExampleSenders();
                    break;
                case "3":
                    this.getExampleListGroups();
                    break;
                case "4":
                    Console.Write("To:");
                    string to = Console.ReadLine();
                    Console.Write("Subject:");
                    string subject=Console.ReadLine();
                    Console.Write("From:");
                    string from = Console.ReadLine();
                    Console.Write("Body HTML:");
                    string html = Console.ReadLine();

                    this.sendEmailTest(to,subject, int.Parse(from) ,html);

                    break;
                case "0":
                    return;              
            }

            this.menuTest();
        }
    }
}
