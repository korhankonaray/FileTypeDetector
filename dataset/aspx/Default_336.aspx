<%@ Page Language="C#" %>

<!DOCTYPE html>

<script runat="server">
    protected void Page_Load(object sender, EventArgs e)
    {
        if (X.IsAjaxRequest)
        {
            //We do not need to DataBind on an DirectEvent
            return;
        }

        this.Store1.DataSource = new object[]
        {
            new object[] { "3m Co", 71.72, 0.02, 0.03, "9/1 12:00am", "Manufacturing"},
            new object[] { "Alcoa Inc", 29.01, 0.42, 1.47, "9/1 12:00am", "Manufacturing"},
            new object[] { "Altria Group Inc", 83.81, 0.28, 0.34, "9/1 12:00am", "Manufacturing"},
            new object[] { "American Express Company", 52.55, 0.01, 0.02, "9/1 12:00am", "Finance"},
            new object[] { "American International Group, Inc.", 64.13, 0.31, 0.49, "9/1 12:00am", "Services"},
            new object[] { "AT&T Inc.", 31.61, -0.48, -1.54, "9/1 12:00am", "Services"},
            new object[] { "Boeing Co.", 75.43, 0.53, 0.71, "9/1 12:00am", "Manufacturing"},
            new object[] { "Caterpillar Inc.", 67.27, 0.92, 1.39, "9/1 12:00am", "Services"},
            new object[] { "Citigroup, Inc.", 49.37, 0.02, 0.04, "9/1 12:00am", "Finance"},
            new object[] { "E.I. du Pont de Nemours and Company", 40.48, 0.51, 1.28, "9/1 12:00am", "Manufacturing"},
            new object[] { "Exxon Mobil Corp", 68.1, -0.43, -0.64, "9/1 12:00am", "Manufacturing"},
            new object[] { "General Electric Company", 34.14, -0.08, -0.23, "9/1 12:00am", "Manufacturing"},
            new object[] { "General Motors Corporation", 30.27, 1.09, 3.74, "9/1 12:00am", "Automotive"},
            new object[] { "Hewlett-Packard Co.", 36.53, -0.03, -0.08, "9/1 12:00am", "Computer"},
            new object[] { "Honeywell Intl Inc", 38.77, 0.05, 0.13, "9/1 12:00am", "Manufacturing"},
            new object[] { "Intel Corporation", 19.88, 0.31, 1.58, "9/1 12:00am", "Computer"},
            new object[] { "International Business Machines", 81.41, 0.44, 0.54, "9/1 12:00am", "Computer"},
            new object[] { "Johnson & Johnson", 64.72, 0.06, 0.09, "9/1 12:00am", "Medical"},
            new object[] { "JP Morgan & Chase & Co", 45.73, 0.07, 0.15, "9/1 12:00am", "Finance"},
            new object[] { "McDonald\"s Corporation", 36.76, 0.86, 2.40, "9/1 12:00am", "Food"},
            new object[] { "Merck & Co., Inc.", 40.96, 0.41, 1.01, "9/1 12:00am", "Medical"},
            new object[] { "Microsoft Corporation", 25.84, 0.14, 0.54, "9/1 12:00am", "Computer"},
            new object[] { "Pfizer Inc", 27.96, 0.4, 1.45, "9/1 12:00am", "Medical"},
            new object[] { "The Coca-Cola Company", 45.07, 0.26, 0.58, "9/1 12:00am", "Food"},
            new object[] { "The Home Depot, Inc.", 34.64, 0.35, 1.02, "9/1 12:00am", "Retail"},
            new object[] { "The Procter & Gamble Company", 61.91, 0.01, 0.02, "9/1 12:00am", "Manufacturing"},
            new object[] { "United Technologies Corporation", 63.26, 0.55, 0.88, "9/1 12:00am", "Computer"},
            new object[] { "Verizon Communications", 35.57, 0.39, 1.11, "9/1 12:00am", "Services"},
            new object[] { "Wal-Mart Stores, Inc.", 45.45, 0.73, 1.63, "9/1 12:00am", "Retail"}
        };
    }

    [DirectMethod]
    public static object GetData(Dictionary<string, string> parameters)
    {
        return new
        {
            company = parameters["company"],
            index = parameters["index"],
            time = DateTime.Now.ToLongTimeString()
        };
    }
</script>

<html>
<head runat="server">
    <title>RowExpander plugin with server side data - Ext.NET Examples</title>
    <link href="/resources/css/examples.css" rel="stylesheet" />

    <style>
        .template {
            color: #fff;
            background-color: gray;
        }
    </style>

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

        <h1>RowExpander plugin with server side data</h1>

        <ext:GridPanel
            runat="server"
            Title="RowExpander plugin with server side data"
            Collapsible="true"
            AnimCollapse="true"
            Icon="Table"
            Width="600"
            Height="300">
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
                                <ext:ModelField Name="industry" />
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
            <Plugins>
                <ext:RowExpander runat="server">
                    <Loader runat="server" Mode="Data" DirectMethod="#{DirectMethods}.GetData">
                        <LoadMask ShowMask="true" />
                        <Params>
                            <ext:Parameter Name="company" Value="this.record.data['company']" Mode="Raw" />
                            <ext:Parameter Name="index" Value="this.grid.store.indexOf(this.record)" Mode="Raw" />
                        </Params>
                    </Loader>
                    <Template runat="server">
                        <Html>
                            <span class="template">
                                Company: {company}, Row #: {index}, Server Date: {time}
                            </span>
                        </Html>
                    </Template>
                </ext:RowExpander>
            </Plugins>
        </ext:GridPanel>
    </form>
</body>
</html>
