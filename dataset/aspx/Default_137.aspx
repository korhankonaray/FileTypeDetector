<%@ Page Language="C#" %>

<script runat="server">
    public System.Drawing.Color ColorFromHSL(double h, double sl, double l)
    {
        double v;
        double r, g, b;

        r = l;
        g = l;
        b = l;
        v = (l <= 0.5) ? (l * (1.0 + sl)) : (l + sl - l * sl);
        if (v > 0)
        {
            double m;
            double sv;
            int sextant;
            double fract, vsf, mid1, mid2;

            m = l + l - v;
            sv = (v - m) / v;
            h *= 6.0;
            sextant = (int)h;
            fract = h - sextant;
            vsf = v * sv * fract;
            mid1 = m + vsf;
            mid2 = v - vsf;
            switch (sextant)
            {
                case 0:
                    r = v;
                    g = mid1;
                    b = m;
                    break;
                case 1:
                    r = mid2;
                    g = v;
                    b = m;
                    break;
                case 2:
                    r = m;
                    g = v;
                    b = mid1;
                    break;
                case 3:
                    r = m;
                    g = mid2;
                    b = v;
                    break;
                case 4:
                    r = mid1;
                    g = m;
                    b = v;
                    break;
                case 5:
                    r = v;
                    g = m;
                    b = mid2;
                    break;
            }
        }
        return System.Drawing.Color.FromArgb(Convert.ToByte(r * 255.0f), Convert.ToByte(g * 255.0f), Convert.ToByte(b * 255.0f));
    }

    protected void Page_Load(object sender, EventArgs e)
    {
        List<Pair> data = new List<Pair>
        {
            new Pair("Ruby", 40),
            new Pair("JavaScript", 26),
            new Pair("Shell", 5),
            new Pair("Python", 5),
            new Pair("PHP", 4),
            new Pair("C", 4),
            new Pair("Perl", 3),
            new Pair("C++", 2),
            new Pair("Java", 2),
            new Pair("Objective-C", 2)
        };

        this.Draw(data);
    }

    private double angle = 0;
    private double start = 0;

    private void Draw(List<Pair> data)
    {
        DrawContainer draw = this.Draw1;
        draw.Width = 700;
        draw.Height = 700;

        this.angle = 0;
        this.start = 0;

        int total = 0;

        for (int i = 0; i < data.Count; i++)
        {
            total += (int)data[i].Second;
        }
        for (int i = 0; i < data.Count; i++)
        {
            this.Process(draw, i, data[i], total);
        }
    }

    private void Process(DrawContainer draw, int i, Pair item, int total)
    {
        int value = (int)item.Second;
        double angleplus = 360 * value * 1.0 / total;
        double popangle = this.angle + (angleplus / 2);
        System.Drawing.Color color = this.ColorFromHSL(this.start, 0.5, 0.5);
        int delta = 30;
        System.Drawing.Color bcolor = this.ColorFromHSL(this.start, 1, 0.5);
        int r = 200;
        double rad = Math.PI / 180;

        draw.Gradients.Add(new LinearGradient{
            Degrees = 90,
            GradientID = "Grd"+i,
            Stops = {
                new GradientStop{Offset = 0, Color = System.Drawing.ColorTranslator.ToHtml(bcolor)},
                new GradientStop{Offset = 100, Color = System.Drawing.ColorTranslator.ToHtml(color)}
            }
        });

        AbstractSprite sector = this.Sector(250, 250, r, this.angle, this.angle + angleplus);
        sector.FillStyle = "url(#Grd"+i+")";
        sector.StrokeStyle = "#fff";
        sector.LineWidth = 3;

        draw.Items.Add(sector);

        TextSprite text = new TextSprite
        {
            SpriteID = "text"+i,
            X = Convert.ToInt32(250 + (r + delta) * Math.Cos(-popangle * rad)),
            Y = Convert.ToInt32(250 + (r + delta) * Math.Sin(-popangle * rad)),
            Text = item.First.ToString(),
            FillStyle = System.Drawing.ColorTranslator.ToHtml(bcolor),
            StrokeStyle = "none",
            GlobalAlpha = 0,
            FontSize = "20"
        };

        draw.Items.Add(text);

        //sector.Listeners.MouseOver.Handler = string.Format("onMouseOver(this, {0});", i);
        //sector.Listeners.MouseOut.Handler = string.Format("onMouseOut(this, {0});", i);

        this.angle += angleplus;
        this.start += 0.1;
    }

    private AbstractSprite Sector(int cx, int cy, int r, double startAngle, double endAngle) {
        double rad = Math.PI / 180;

        string x1 = JSON.Serialize(cx + r * Math.Cos(-startAngle * rad));
        string x2 = JSON.Serialize(cx + r * Math.Cos(-endAngle * rad));
        string y1 = JSON.Serialize(cy + r * Math.Sin(-startAngle * rad));
        string y2 = JSON.Serialize(cy + r * Math.Sin(-endAngle * rad));

        return new PathSprite{
            Path = String.Join<string>(" ", new string[] { "M" + cx, cy.ToString(), "L" + x1, y1.ToString(), "A" + r, r.ToString(), "0", (endAngle - startAngle) > 180 ? "1" : "0", "0", x2, y2, "z" })
        };
    }
</script>

<!DOCTYPE html>

<html>
<head runat="server">
    <title>Pies Chart - Ext.NET Examples</title>
    <link href="/resources/css/examples.css" rel="stylesheet" />

    <script>
        var onMouseOver = function (sprite, i) {
            sprite.fx.stop();
            sprite.setAttributes({ scalingX: 1.1, scalingY: 1.1, cx: 350, cy: 350, duration: 500, easing: "backOut" });
            sprite.getSurface().get("text" + i).setAttributes({ globalAlpha: 1, duration: 500 });
            sprite.getSurface().renderFrame();
        }

        var onMouseOut = function (sprite, i) {
            sprite.fx.stop();
            sprite.setAttributes({ scalingX: 1, scalingY: 1, cx: 350, cy: 350, duration: 500, easing: "backIn" });
            sprite.getSurface().get("text" + i).setAttributes({ globalAlpha: 0, duration: 500 });
            sprite.getSurface().renderFrame();
        }
    </script>
</head>
<body>
    <form runat="server">
        <ext:ResourceManager runat="server" />

        <ext:Viewport runat="server">
            <LayoutConfig>
                <ext:VBoxLayoutConfig Align="Center" Pack="Center" />
            </LayoutConfig>
            <Items>
                <ext:DrawContainer ID="Draw1" runat="server" Border="false" />
            </Items>
        </ext:Viewport>
    </form>
</body>
</html>