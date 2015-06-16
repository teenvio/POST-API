<%@ Page Language="C#" Inherits="Example_APIPOST.Default" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head runat="server">
	<title>Default</title>
	<style type="text/css">
		input[type=text]{width:500px;}
	</style>
</head>
<body>
	<form id="form1" runat="server">
		<asp:Button id="button1" runat="server" Text="Add/update contact - Click me!" OnClick="button1Clicked" />
		<asp:TextBox id="textBox1" runat="server" />
		<br/>
		
		<asp:Button id="button2" runat="server" Text="Delete contact - Click me!" OnClick="button2Clicked" />
		<asp:TextBox id="textBox2" runat="server" />
		
		
	</form>
</body>
</html>
