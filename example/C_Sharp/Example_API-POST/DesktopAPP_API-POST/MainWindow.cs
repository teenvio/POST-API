using System;
using System.Threading;
using System.Xml;
using Gtk;
using Teenvio;

namespace DesktopAPP_APIPOST
{

	[Gtk.TreeNode (ListOnly=true)]
	public class CampaignTreeNode : Gtk.TreeNode {

		public CampaignTreeNode (int id, string name)
		{
			this.id = id;
			this.Name = name;
		}

		[Gtk.TreeNodeValue (Column=0)]
		public int id;

		[Gtk.TreeNodeValue (Column=1)]
		public string Name;
	}

	public partial class MainWindow : Gtk.Window
	{


		private TeenvioAPI api;

		public MainWindow () : base(Gtk.WindowType.Toplevel)
		{
			this.Build ();
		}

		protected void OnDeleteEvent (object sender, DeleteEventArgs a)
		{
			Application.Quit ();
			a.RetVal = true;
		}

		public void setAPI(TeenvioAPI api){
			this.api = api;
			lblStatusBarVersion.Text = "Version: "+api.getServerVersion ();

		}

		protected void OnQuitActionActivated (object sender, EventArgs e)
		{
			Application.Quit();
		}

		private void LoadLastCampaigns(){

			lblState.Text = "Loading...";

			Thread oThread = new Thread(new ThreadStart(delegate() {
				try{

					nodeviewTable.Hide();

					int[] ids = api.GetCampaigns();

					Gtk.NodeStore store = new Gtk.NodeStore (typeof (CampaignTreeNode));
					foreach(int i in ids){
						store.AddNode (new CampaignTreeNode (i, getStatName(i)));
					}
					
					Gtk.NodeView view = new Gtk.NodeView (store);

					nodeviewTable.NodeStore=view.NodeStore;

					nodeviewTable.AppendColumn("Id", new Gtk.CellRendererText (), "text", 0);
					nodeviewTable.AppendColumn("Name", new Gtk.CellRendererText (), "text", 1);

					lblTableTitle.Text="Last Campaigns";
					nodeviewTable.NodeSelection.Changed += new System.EventHandler (OnNodeviewTableChange);

					nodeviewTable.Show();


				}catch(Exception ex){
					MessageDialog msg = new MessageDialog (this, DialogFlags.Modal, MessageType.Error, ButtonsType.Close, ex.Message);
					msg.Title = "Error";

					ResponseType response = (ResponseType) msg.Run();
					if (response == ResponseType.Close || response == ResponseType.DeleteEvent) {
						msg.Destroy();
					}
				}
				lblState.Text = "Ready";
			}));
			oThread.Start ();

		}

		private string getStatName(int id){
			string xml = api.GetStats (id); 

			XmlDocument dom = new XmlDocument();
			dom.LoadXml(xml);

			return dom.GetElementsByTagName("name").Item(0).InnerText;

		}

		protected void OnListAction1Activated (object sender, EventArgs e)
		{
			this.LoadLastCampaigns ();
		}

		protected void OnNodeviewTableChange (object o, System.EventArgs args)
		{
			Gtk.NodeSelection selection = (Gtk.NodeSelection) o;

			CampaignTreeNode node = (CampaignTreeNode) selection.SelectedNode;

			lblState.Text = "Selected campaign " + node.Name;
			//label.Text = "Current Selection: \"" + node.SongTitle + "\" by " + node.Artist;


		}
	}
}

