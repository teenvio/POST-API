using System.Collections.Generic;

namespace Example_APIPOST
{
	using System;
	using System.Web;
	using System.Web.UI;

	public partial class Default : System.Web.UI.Page
	{
		//********************************
		//   Change this auth-data!
		//********************************
		private teenvio.com.API api = new teenvio.com.API("user","plan","pass");
		
		public void button1Clicked (object sender, EventArgs args){

			Dictionary<string, string> contact = new Dictionary<string,string>();
			contact.Add ("email", "api.net@teenvio.com");		//Email
			contact.Add ("nombre", "example api teenvio.com");	//Name
			contact.Add ("empresa", "teenvio.com");				//Company
			contact.Add ("eciudad", "Madrid");					//Compay city
			contact.Add ("eprovincia","Madrid");				//Company state
			contact.Add ("epais", "Spain");						//Compaty contry
			contact.Add ("dato_1", "extra data one");			//Extra data 1
			contact.Add ("dato_2", "extra data two");			//Extra data 2

			textBox1.Text = api.SaveContact (contact, 1);

		}

		public void button2Clicked (object sender, EventArgs args){

			textBox2.Text = api.DeleteContact ("api.net@teenvio.com");

		}
	}
}

