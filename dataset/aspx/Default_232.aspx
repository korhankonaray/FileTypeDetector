<%@ Page Language="C#" %>

<%@ Import Namespace="Button=Ext.Net.Button" %>

<script runat="server">
    protected void Page_Load(object sender, EventArgs e)
    {
        if (!X.IsAjaxRequest)
        {
            this.Store1.DataSource = this.GetData();
            this.Store1.DataBind();
        }
    }

    protected void Button1_Click(object sender, DirectEventArgs e)
    {
        ((Button)sender).Disabled = true;

        Store store = this.Store1;
        GridPanel grid = this.GridPanel1;

        // Clear Collections to remove old Data and Models
        store.Reader.Clear();
        grid.SelectionModel.Clear();
        grid.ColumnModel.Columns.Clear();
        store.Model.Clear();

        // Reconfigure Store
        store.Model.Add(new Model
        {
            Fields =
            {
                new ModelField("name"),
                new ModelField("quote", ModelFieldType.Float),
                new ModelField("date", ModelFieldType.Date, "M/d hh:mmtt")
            }
        });

        store.DataSource = this.GetData2();
        store.DataBind();

        // Reconfigure GridPanel
        grid.SelectionModel.Add(new RowSelectionModel { Mode = SelectionMode.Single });

        grid.ColumnModel.Columns.Add(new ColumnBase[] {
            new Column
            {
                Text = "Name",
                DataIndex = "name",
                Flex = 1
            },
            new Column
            {
                Text = "Quote",
                DataIndex = "quote",
                Renderer = { Format = RendererFormat.UsMoney }
            },
            new DateColumn
            {
                Text = "Date",
                DataIndex = "date"
            }
        });

        // **Make sure to call .Render() on the GridPanel
        grid.Render();
    }

    private object[] GetData()
    {
        return new object[]
        {
            new object[] { "3m Co", 71.72, 0.02, 0.03, "9/1 12:00am" },
            new object[] { "Alcoa Inc", 29.01, 0.42, 1.47, "9/1 12:00am" },
            new object[] { "Altria Group Inc", 83.81, 0.28, 0.34, "9/1 12:00am" },
            new object[] { "American Express Company", 52.55, 0.01, 0.02, "9/1 12:00am" },
            new object[] { "American International Group, Inc.", 64.13, 0.31, 0.49, "9/1 12:00am" },
            new object[] { "AT&T Inc.", 31.61, -0.48, -1.54, "9/1 12:00am" },
            new object[] { "Boeing Co.", 75.43, 0.53, 0.71, "9/1 12:00am" },
            new object[] { "Caterpillar Inc.", 67.27, 0.92, 1.39, "9/1 12:00am" },
            new object[] { "Citigroup, Inc.", 49.37, 0.02, 0.04, "9/1 12:00am" },
            new object[] { "E.I. du Pont de Nemours and Company", 40.48, 0.51, 1.28, "9/1 12:00am" },
            new object[] { "Exxon Mobil Corp", 68.1, -0.43, -0.64, "9/1 12:00am" },
            new object[] { "General Electric Company", 34.14, -0.08, -0.23, "9/1 12:00am" },
            new object[] { "General Motors Corporation", 30.27, 1.09, 3.74, "9/1 12:00am" },
            new object[] { "Hewlett-Packard Co.", 36.53, -0.03, -0.08, "9/1 12:00am" },
            new object[] { "Honeywell Intl Inc", 38.77, 0.05, 0.13, "9/1 12:00am" },
            new object[] { "Intel Corporation", 19.88, 0.31, 1.58, "9/1 12:00am" }
        };
    }

    private object[] GetData2()
    {
        return new object[]
        {
            new object[] { "International Business Machines", 81.41, "9/1 12:00am" },
            new object[] { "Johnson & Johnson", 64.72, "9/1 12:00am" },
            new object[] { "JP Morgan & Chase & Co", 45.73, "9/1 12:00am" },
            new object[] { "McDonald\"s Corporation", 36.76, "9/1 12:00am" },
            new object[] { "Merck & Co., Inc.", 40.96, "9/1 12:00am" },
            new object[] { "Microsoft Corporation", 25.84, "9/1 12:00am" },
            new object[] { "Pfizer Inc", 27.96, "9/1 12:00am" },
            new object[] { "The Coca-Cola Company", 45.07, "9/1 12:00am" },
            new object[] { "The Home Depot, Inc.", 34.64, "9/1 12:00am" },
            new object[] { "The Procter & Gamble Company", 61.91, "9/1 12:00am" },
            new object[] { "United Technologies Corporation", 63.26, "9/1 12:00am" },
            new object[] { "Verizon Communications", 35.57, "9/1 12:00am" },
            new object[] { "Wal-Mart Stores, Inc.", 45.45, "9/1 12:00am" }
        };
    }
</script>

<!DOCTYPE html>

<html>
<head runat="server">
    <title>Simple Array Grid - Ext.NET Examples</title>
    <link href="/resources/css/examples.css" rel="stylesheet" />

    <script>
        var template = '<span style="color:{0};">{1}</span>';

        var change = function (value) {
            return Ext.String.format(template, (value > 0) ? "green" : "red", value);
        };

        var pctChange = function (value) {
            return Ext.String.format(template, (value > 0) ? "green" : "red", value + "%");
        };
    </script>
</head>
<body>
    <form runat="server">
        <ext:ResourceManager runat="server" />

        <h1>Change GridPanel Column and Selection Models during a DirectEvent</h1>

        <p>Demonstrates removing a GridPanels ColumnModel and SelectionModel during a DirectEvent, then reconfiguring with new Models and Store Data.</p>

        <p>Ensure to call .Render() on the GridPanel when finished reconfiguring the Components.</p>

        <ext:Window
            ID="Window1"
            runat="server"
            Title="Example"
            Closable="false"
            Layout="FitLayout"
            Height="350"
            Width="620">
            <TopBar>
                <ext:Toolbar runat="server">
                    <Items>
                        <ext:Button
                            runat="server"
                            Text="Reconfigure"
                            Icon="Accept">
                            <DirectEvents>
                                <Click OnEvent="Button1_Click">
                                    <EventMask
                                        ShowMask="true"
                                        Target="CustomTarget"
                                        CustomTarget="Window1"
                                        />
                                </Click>
                            </DirectEvents>
                        </ext:Button>
                    </Items>
                </ext:Toolbar>
            </TopBar>
            <Items>
                <ext:GridPanel
                    ID="GridPanel1"
                    runat="server"
                    Border="false">
                    <Store>
                        <ext:Store ID="Store1" runat="server">
                            <Model>
                                <ext:Model runat="server">
                                    <Fields>
                                        <ext:ModelField Name="company" />
                                        <ext:ModelField Name="price" Type="Float" />
                                        <ext:ModelField Name="change" Type="Float" />
                                        <ext:ModelField Name="pctChange" Type="Float" />
                                        <ext:ModelField Name="lastChange" Type="Date" DateFormat="M/d hh:mmtt" />
                                    </Fields>
                                </ext:Model>
                            </Model>
                        </ext:Store>
                    </Store>
                    <ColumnModel runat="server">
                        <Columns>
                            <ext:Column runat="server" Text="Company" DataIndex="company" Flex="1" />
                            <ext:Column runat="server" Text="Price" DataIndex="price">
                                <Renderer Format="UsMoney" />
                            </ext:Column>
                            <ext:Column runat="server" Text="Change" DataIndex="change">
                                <Renderer Fn="change" />
                            </ext:Column>
                            <ext:Column runat="server" Text="Change" DataIndex="pctChange">
                                <Renderer Fn="pctChange" />
                            </ext:Column>
                            <ext:DateColumn runat="server" Text="Last Updated" DataIndex="lastChange" />
                        </Columns>
                    </ColumnModel>
                    <View>
                        <ext:GridView runat="server" StripeRows="true" TrackOver="true" />
                    </View>
                </ext:GridPanel>
            </Items>
        </ext:Window>
    </form>
</body>
</html>