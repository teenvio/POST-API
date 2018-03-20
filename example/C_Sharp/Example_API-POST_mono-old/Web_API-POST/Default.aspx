<%@ Page Language="C#" Inherits="Example_APIPOST.Default" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head runat="server">
	<title>Default</title>
	<style type="text/css">
		input[type=text]{width:500px;}
	</style>
</head>
<body onload="onLoad" runat="server">

	<h1>Teenvio C# Examples - POST-API</h1>
	
	<p><strong>Warning!!</strong> Change the Auth data in Default.aspx.cs, onLoad method</p>

	<form id="form1" runat="server">
		<asp:Button id="button1" runat="server" Text="Add/update contact - Click me!" OnClick="button1Clicked" />
		<asp:TextBox id="textBox1" runat="server" />
		<br/>
		
		<asp:Button id="button2" runat="server" Text="Delete contact - Click me!" OnClick="button2Clicked" />
		<asp:TextBox id="textBox2" runat="server" />
		
		
		<br/>
		<asp:Button id="button3" runat="server" Text="Get Last Campaign Stats - Click me!" OnClick="button3Clicked" />
		<asp:TextBox id="textBox3" runat="server" />
		
		<br/>
		<asp:Button id="button4" runat="server" Text="Get Campaigns - Click me!" OnClick="button4Clicked" />
		
		<br/>
		<asp:ListBox id="listBox1" runat="server" AutoPostBack="true" OnSelectedIndexChanged="listBox1SelectedIndexChanged" ></asp:ListBox>
		
		<br/>
		<asp:TreeView id="treeView1" runat="server"></asp:TreeView>
		
		<br/>
		<asp:Button id="button5" runat="server" Text="Get Contacts Stat SEND_UNOPENED_BOUNCED - Click me!" OnClick="button5Clicked" />
		<asp:TextBox id="textBox5" runat="server" />
		
	</form>
</body>
</html>
