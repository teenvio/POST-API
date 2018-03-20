
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
                string version = api.getServerVersion();
                Console.WriteLine("Connected! Server API Version: "+version);

                this.saveExampleContact();
                this.getExampleSenders();
                this.getExampleListGroups();
                
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
    }
}
