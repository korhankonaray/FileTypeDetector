<%@ Page Language="C#" %>

<script runat="server">
    protected void Page_Load(object sender, EventArgs e)
    {
        TreePanel tree = new TreePanel();

        tree.Title = "Online Users";
        tree.RootVisible = false;

        tree.Tools.Add(new Tool(ToolType.Refresh,X.Msg.Alert("Message", "Refresh Tool Clicked!").ToScript(), ""));

        Ext.Net.Node root = new Ext.Net.Node();
        root.NodeID = "root";
        root.Expanded = true;

        tree.Root.Add(root);

        Ext.Net.Node node1 = new Ext.Net.Node();

        node1.Text = "Friends";
        node1.Expanded = true;

        node1.Children.Add(new Ext.Net.Node()
            {
                Text = "George",
                Icon = Icon.User,
                Leaf = true
            });
        node1.Children.Add(new Ext.Net.Node()
            {
                Text = "Brian",
                Icon = Icon.User,
                Leaf = true
            });
        node1.Children.Add(new Ext.Net.Node()
            {
                Text = "Jon",
                Icon = Icon.User,
                Leaf = true
            });
        node1.Children.Add(new Ext.Net.Node()
            {
                Text = "Tim",
                Icon = Icon.User,
                Leaf = true
            });
        node1.Children.Add(new Ext.Net.Node()
            {
                Text = "Brent",
                Icon = Icon.User,
                Leaf = true
            });
        node1.Children.Add(new Ext.Net.Node()
            {
                Text = "Fred",
                Icon = Icon.User,
                Leaf = true
            });
        node1.Children.Add(new Ext.Net.Node()
            {
                Text = "Bob",
                Icon = Icon.User,
                Leaf = true
            });

        root.Children.Add(node1);

        Ext.Net.Node node2 = new Ext.Net.Node();
        node2.Text = "Family";
        node2.Expanded = true;

        node2.Children.Add(new Ext.Net.Node()
            {
                Text = "Kelly",
                Icon = Icon.UserFemale,
                Leaf = true
            });
        node2.Children.Add(new Ext.Net.Node()
            {
                Text = "Sara",
                Icon = Icon.UserFemale,
                Leaf = true
            });
        node2.Children.Add(new Ext.Net.Node()
            {
                Text = "Zack",
                Icon = Icon.UserFemale,
                Leaf = true
            });
        node2.Children.Add(new Ext.Net.Node()
            {
                Text = "John",
                Icon = Icon.UserFemale,
                Leaf = true
            });

        root.Children.Add(node2);

        Ext.Net.Panel panel1 = new Ext.Net.Panel("Settings");
        Ext.Net.Panel panel2 = new Ext.Net.Panel("Even More Stuff");
        Ext.Net.Panel panel3 = new Ext.Net.Panel("My Stuff");

        Toolbar toolbar = new Toolbar();

        Ext.Net.Button button1 = new Ext.Net.Button();
        button1.Icon = Icon.Connect;

        ToolTip tooltip = new ToolTip();
        tooltip.Title = "Rich ToolTips";
        tooltip.Html = "Let your users know what they can do!";

        button1.ToolTips.Add(tooltip);

        Ext.Net.Button button2 = new Ext.Net.Button();
        button2.Icon = Icon.UserAdd;

        Ext.Net.Button button3 = new Ext.Net.Button();
        button3.Icon = Icon.UserDelete;

        toolbar.Items.Add(button1);
        toolbar.Items.Add(button2);
        toolbar.Items.Add(button3);

        Window window = new Window();

        window.Title = "Accordion Window";
        window.Width = Unit.Pixel(250);
        window.Height = Unit.Pixel(400);
        window.Maximizable = true;
        window.Icon = Icon.ApplicationTileVertical;
        window.BodyBorder = 0;
        window.Layout = "Accordion";

        window.TopBar.Add(toolbar);

        window.Items.Add(tree);
        window.Items.Add(panel1);
        window.Items.Add(panel2);
        window.Items.Add(panel3);

        this.PlaceHolder1.Controls.Add(window);
    }
</script>

<!DOCTYPE html>

<html>
<head runat="server">
    <title>AccordionLayout in Code-Behind - Ext.NET Examples</title>
    <link href="/resources/css/examples.css" rel="stylesheet" />
</head>
<body>
    <ext:ResourceManager runat="server" />

    <h1>Accordion Layout in Code-Behind</h1>

    <asp:PlaceHolder ID="PlaceHolder1" runat="server" />
</body>
</html>