using System;
using Gtk;
using Teenvio;
using DesktopAPP_APIPOST;

public partial class LoginWindow: Gtk.Window
{	
	public LoginWindow (): base (Gtk.WindowType.Toplevel)
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
		TeenvioAPI api = new TeenvioAPI (txtUser.Text, txtPlan.Text, txtPassword.Text);

		try{
			api.getServerVersion ();
			MainWindow win = new MainWindow();
			win.Show();
			win.setAPI(api);
			this.Destroy();

		}catch(TeenvioException ex){
			MessageDialog msg = new MessageDialog (this, DialogFlags.Modal, MessageType.Error, ButtonsType.Close, ex.Message);
			msg.Title = "Error";

			ResponseType response = (ResponseType) msg.Run();
			if (response == ResponseType.Close || response == ResponseType.DeleteEvent) {
				msg.Destroy();
			}
		}catch(Exception ex){
			MessageDialog msg = new MessageDialog (this, DialogFlags.Modal, MessageType.Error, ButtonsType.Close, ex.Message);
			msg.Title = "Error";

			ResponseType response = (ResponseType) msg.Run();
			if (response == ResponseType.Close || response == ResponseType.DeleteEvent) {
				msg.Destroy();
			}
		}



	}
}
