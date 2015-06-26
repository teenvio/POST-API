using System;
using Gtk;

namespace DesktopAPP_APIPOST
{
	class MainClass
	{



		public static void Main (string[] args)
		{			
			Application.Init ();
			LoginWindow win = new LoginWindow ();
			win.Show ();
			Application.Run ();
		}
	}
}
