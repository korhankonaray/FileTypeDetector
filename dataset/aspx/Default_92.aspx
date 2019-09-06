<%@ Page Language="C#" %>

<%@ Import Namespace="System.Collections.Generic" %>

<script runat="server">
    protected void Page_Load(object sender, EventArgs e)
    {
        if (!X.IsAjaxRequest)
        {
            List<object> data = new List<object>(26);

            for (char letter = 'A'; letter < 'Z'; letter++)
            {
                List<object> customers = new List<object>(10);

                for (int i = 1; i <= 10; i++)
                {
                    customers.Add(new
                      {
                          CustomerID = letter.ToString() + i,
                          CompanyName = "Company of " + (letter.ToString() + i),
                          ContactName = letter.ToString() + i,
                          Email = (letter.ToString() + i)+"@test.com",
                          Address = "Address of " + (letter.ToString() + i),
                          City = "City of " + (letter.ToString() + i),
                          PostalCode = "PostalCode of " + (letter.ToString() + i),
                          Country = "Country of " + (letter.ToString() + i)
                      });
                }

                data.Add(new { Letter = letter.ToString(), Customers = customers });
            }

            this.dsReport.DataSource = data;
            this.dsReport.DataBind();
        }
    }
</script>

<!DOCTYPE html>

<html>
<head runat="server">
    <title>Report DataView - Ext.NET Examples</title>

    <style>
        body  {
            font : normal 11px tahoma, arial, helvetica, sans-serif;
        }

        #customers-ct table { width : 100% !important; }

        #customers-ct th {
            background  : #F0F4F5 url(/extjs/packages/theme_classic/build/resources/images/toolbar/toolbar-default-bg-gif/ext.axd) repeat-x scroll left top;
            font-weight : bold;
            padding     : 8px 5px;
        }

        #customers-ct td {
            padding : 5px;
        }

        #customers-ct .letter-row {
            padding-top : 15px;
            border : none;
        }

        #customers-ct .letter-row h2 { font-size : 2em; }

        #customers-ct .header { padding : 10px 0px 10px 5px; }

        #customers-ct .header p { font-size : 2em; }

        #customers-ct .header a { margin-bottom : 10px; }

        .cust-name-over {
            cursor : pointer;
            background-color : #efefef;
        }

        #customers-ct .letter-row div {
            border-bottom : 2px solid #99bbe8;
            cursor        : pointer;
            background    : transparent url(/extjs/packages/theme_classic/build/resources/images/grid/group-expand-sprite-gif/ext.axd) no-repeat 0px -42px;
            margin-bottom : 5px;
        }

        #customers-ct .letter-row div h2  { padding-left : 18px; }

        #customers-ct .letter-row div.collapsed { background-position : 0px 8px; }

        #customers-ct .customer-record { border-bottom : 1px solid silver; }

        #customers-ct table.collapsed { display : none; }

        .customer-label {
            font-weight : bold;
            font-size:12px;
            padding     : 0px 0px 0px 32px;
            width       : 150px;
        }
    </style>

    <ext:XScript runat="server">
        <script>
            var itemClick = function (view, record, item, index, e) {
                var group = e.getTarget("h2.letter-selector");

                if (group) {
                    Ext.get(group)
                        .up("div")
                        .toggleCls("collapsed")
                        .up("td")
                        .select("table")
                        .toggleCls("collapsed");
                }

                var row = e.getTarget("tr.customer-record-row"),
                    nd = row && Ext.get(row).child("td.cust-name");

                if (nd) {
                    #{DataViewContextMenu}.node = {
                        id    : nd.getAttribute("custID"),
                        name  : nd.getAttribute("custName"),
                        email : nd.getAttribute("email"),
                        contact : nd.dom.innerHTML
                    };

                    #{DataViewContextMenu}.showAt(e.getXY());
                }
            };
        </script>
    </ext:XScript>
</head>
<body>
    <ext:ResourceManager runat="server" />

    <ext:Menu ID="DataViewContextMenu" runat="server">
        <Items>
            <ext:Label ID="CustomerLabel" runat="server" Cls="customer-label" />
            <ext:MenuItem runat="server" Text="Send Mail" Icon="Mail">
                <Listeners>
                    <Click Handler="if (Ext.isEmpty(this.parentMenu.node.email, false)) { Ext.Msg.alert('Error', 'Customer has no email');} else { parent.location = 'mailto:'+this.parentMenu.node.email; }" />
                </Listeners>
            </ext:MenuItem>
            <ext:MenuItem runat="server" Text="Show Details" Icon="ApplicationFormEdit">
                <Listeners>
                    <Click Handler="Ext.Msg.alert('Details', Ext.encode(this.parentMenu.node));" />
                </Listeners>
            </ext:MenuItem>
        </Items>
       <Listeners>
            <BeforeShow Handler="#{CustomerLabel}.setText(this.node.contact);" />
        </Listeners>
    </ext:Menu>

    <ext:Toolbar runat="server">
        <Items>
            <ext:Button
                runat="server"
                Text="Print"
                Icon="Printer"
                OnClientClick="window.print();"
                />
        </Items>
    </ext:Toolbar>

    <ext:DataView
        runat="server"
        DisableSelection="true"
        ItemSelector="td.letter-row"
        EmptyText="No customers to display">
        <Store>
            <ext:Store ID="dsReport" runat="server">
                <Model>
                    <ext:Model runat="server">
                        <Fields>
                            <ext:ModelField Name="Letter" />
                            <ext:ModelField Name="Customers" Type="Object" />
                        </Fields>
                    </ext:Model>
                </Model>
            </ext:Store>
        </Store>
        <Tpl ID="Template1" runat="server">
            <Html>
                <div id="customers-ct">
                    <div class="header">
                        <p>Customer Address Book</p>
                    </div>
                    <table>
                        <tr>
                            <th style="width:10%">Contact Name</th>
                            <th style="width:18%">Address</th>
                            <th style="width:18%">City</th>
                            <th style="width:18%">State/Province</th>
                            <th style="width:18%">Zip/Postal Code</th>
                            <th style="width:18%">Country/Region</th>
                        </tr>

                        <tpl for=".">
                                <tr>
                                    <td class="letter-row" colspan="6">
                                        <div><h2 class="letter-selector">{Letter}</h2></div>
                                        <tpl for="Customers">
                                            <table class="customer-record">
                                                <tr class="customer-record-row">
                                                    <td class="cust-name" custID="{CustomerID}" custName="{CompanyName}" email="{Email}" style="width:10%">{ContactName}</td>
                                                    <td style="width:18%">&nbsp;{Address}</td>
                                                    <td style="width:18%">&nbsp;{City}</td>
                                                    <td style="width:18%">&nbsp;{Region}</td>
                                                    <td style="width:18%">&nbsp;{PostalCode}</td>
                                                    <td style="width:18%">&nbsp;{Country}</td>
                                                </tr>
                                            </table>
                                        </tpl>
                                    </td>
                                </tr>
                        </tpl>
                    </table>
                </div>
            </html>        </Tpl>
        <Listeners>
            <ItemClick Fn="itemClick" />
            <Refresh Handler="this.el.select('table.customer-record', true).addClsOnOver('cust-name-over');" Delay="100" />
        </Listeners>
    </ext:DataView>
</body>
</html>