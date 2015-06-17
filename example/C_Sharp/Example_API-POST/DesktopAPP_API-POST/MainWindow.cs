using System;
using Gtk;
using System.Collections.Generic;

public partial class MainWindow: Gtk.Window
{	
	public MainWindow (): base (Gtk.WindowType.Toplevel)
	{
		Build ();
	}

	protected void OnDeleteEvent (object sender, DeleteEventArgs a)
	{
		Application.Quit ();
		a.RetVal = true;
	}

	protected void btnEnter_Click (object sender, EventArgs e)
	{
		teenvio.com.API api = new teenvio.com.API (txtUser.Text, txtPlan.Text, txtPassword.Text);
		Dictionary<string, string> contact = new Dictionary<string,string> ();
		contact.Add ("email", "soporte@teenvio.com");

		string campaings = api.SaveContact (contact);

		if (campaings.Substring (0, 2) == "KO") {
			MessageDialog msg = new MessageDialog (this, DialogFlags.Modal, MessageType.Error, ButtonsType.Close, campaings);
			msg.Title = "Error";
			ResponseType response = (ResponseType) msg.Run();
			if (response == ResponseType.Close || response == ResponseType.DeleteEvent) {
				msg.Destroy();
			}
		} else {
			MessageDialog msg = new MessageDialog (this, DialogFlags.Modal, MessageType.Error, ButtonsType.Close, campaings);
			msg.Title = "Info";

			ResponseType response = (ResponseType) msg.Run();
			if (response == ResponseType.Close || response == ResponseType.DeleteEvent) {
				msg.Destroy();
			}
		}
	}
}
