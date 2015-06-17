/// ---------------------------------------------------------------------------------
/// <copyright>Ipdea Land, S.L. / Teenvio</copyright>
/// <author>Víctor J. Chamorro</author>
///
/// LGPL v3 - GNU LESSER GENERAL PUBLIC LICENSE
///
/// This program is free software: you can redistribute it and/or modify
/// it under the terms of the GNU LESSER General Public License as published by
/// the Free Software Foundation, either version 3 of the License.
/// 
/// This program is distributed in the hope that it will be useful,
/// but WITHOUT ANY WARRANTY; without even the implied warranty of
/// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
/// GNU General Public License for more details.
///
/// You should have received a copy of the GNU LESSER General Public License
/// along with this program.  If not, see <http://www.gnu.org/licenses/>.
/// ---------------------------------------------------------------------------------

namespace Example_APIPOST{
	using System;
	using System.Web;
	using System.Web.UI;
	using System.Collections.Generic;
	using System.Xml;

	public partial class Default : System.Web.UI.Page{

		private teenvio.com.API api;

		private int currentIdCampaign=0;

		public void onLoad (object sender, EventArgs args){

			//**************************************
			//   Change this auth-data!
			//**************************************

			// user.plan: two parts from teenvio login separated by .
			api = new teenvio.com.API("user","plan","password");

			//***************************************
			//    Set the HTTP Method: GET or POST
			//***************************************
			api.useMethodGET();   
			//api.useMethodPOST();


			if (listBox1.SelectedValue.Length > 0) {
				this.currentIdCampaign = int.Parse(listBox1.SelectedValue);
			}
		}

		//Add/update Contact 
		public void button1Clicked (object sender, EventArgs args){

			//View all fields names in the documentation

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

		//Delete contact
		public void button2Clicked (object sender, EventArgs args){

			textBox2.Text = api.DeleteContact ("api.net@teenvio.com");

		}

		//Get stats
		public void button3Clicked (object sender, EventArgs args){

			int[] ids = api.GetCampaigns();
		
			if (ids.Length > 0) {
				this.GetStats (ids[0]);
				textBox3.Text = "OK";
			} else {
				textBox3.Text = "No campaign";
			}


		}

		//Get last Campaings
		public void button4Clicked (object sender, EventArgs args){

			int[] ids = api.GetCampaigns();

			listBox1.Items.Clear();

			foreach (int i in ids) {
				listBox1.Items.Add (new System.Web.UI.WebControls.ListItem(i.ToString()+" - "+getStatName(i),i.ToString()));
			}

		}

		//Show stat
		public void listBox1SelectedIndexChanged (object sender, EventArgs args){
			string curItem = listBox1.SelectedValue;
			this.currentIdCampaign = int.Parse (curItem);
			GetStats (this.currentIdCampaign);
		}

		//Show contacts from section into stat
		public void button5Clicked (object sender, EventArgs args){

			int id = this.currentIdCampaign;

			if (this.currentIdCampaign == 0) {

				int[] ids = api.GetCampaigns ();

				if (ids.Length > 0) {
					id = ids [0];
				} else {
					textBox5.Text = "No campaign";
				}
			}

			string xml = api.GetContactsStatSection (id, teenvio.com.API.StatSection.SEND_OPENED_UNSUBSCRIBED);

			XmlDocument dom = new XmlDocument();
			dom.LoadXml(xml);


			treeView1.Nodes.Clear();
			treeView1.Nodes.Add(new System.Web.UI.WebControls.TreeNode(dom.DocumentElement.Name));
			System.Web.UI.WebControls.TreeNode tNode = new System.Web.UI.WebControls.TreeNode();
			tNode = treeView1.Nodes[0];

			AddNode(dom.DocumentElement, tNode);
			treeView1.ExpandAll();
		}

		//Example get data from XML
		private string getStatName(int id){
			string xml = api.GetStats (id); 

			XmlDocument dom = new XmlDocument();
			dom.LoadXml(xml);

			return dom.GetElementsByTagName("name").Item(0).InnerText;

		}

		//Load XML into treeView
		private void GetStats(int id){
			string xml = api.GetStats (id); 

			XmlDocument dom = new XmlDocument();
			dom.LoadXml(xml);


			treeView1.Nodes.Clear();
			treeView1.Nodes.Add(new System.Web.UI.WebControls.TreeNode(dom.DocumentElement.Name));
			System.Web.UI.WebControls.TreeNode tNode = new System.Web.UI.WebControls.TreeNode();
			tNode = treeView1.Nodes[0];

			AddNode(dom.DocumentElement, tNode);
			treeView1.CollapseAll();
		}

		//Add node into treeView
		private void AddNode(XmlNode inXmlNode, System.Web.UI.WebControls.TreeNode inTreeNode){
			XmlNode xNode;
			System.Web.UI.WebControls.TreeNode tNode;
			XmlNodeList nodeList;
			int i;

			// Loop through the XML nodes until the leaf is reached.
			// Add the nodes to the TreeView during the looping process.
			if (inXmlNode.HasChildNodes){
				nodeList = inXmlNode.ChildNodes;
				for(i = 0; i<=nodeList.Count - 1; i++){
					xNode = inXmlNode.ChildNodes[i];
					inTreeNode.ChildNodes.Add(new System.Web.UI.WebControls.TreeNode(xNode.Name));
					tNode = inTreeNode.ChildNodes[i];
					AddNode(xNode, tNode);
				}
			}else{
				// Here you need to pull the data from the XmlNode based on the
				// type of node, whether attribute values are required, and so forth.
				inTreeNode.Text = (inXmlNode.OuterXml).Trim();
			}
		}
	}
}

