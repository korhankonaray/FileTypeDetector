<%@ Page Language="C#" %>

<!DOCTYPE html>

<html>
<head runat="server">
    <title>Rotate Image - Ext.NET Examples</title>
    <link href="/resources/css/examples.css" rel="stylesheet" />

    <script>
        var fxApplied = false;
        var onMouseOver = function (me, event, eventOpts) {
            if (me.sprite.id.match(/^btn[12]outline$/)) {
                var desiredSprite = "btn" + me.sprite.id.substr(3, 1) + "arrow";
                var spriteToHiLit = App.dc1.getSprite(desiredSprite);

                spriteToHiLit.getAnimation().stop();
                spriteToHiLit.setAttributes({ fill: '#fc0', duration: 300 });
            }
        };

        var onMouseOut = function (me, event, eventOpts) {
            if (me.sprite.id.match(/^btn[12]outline$/)) {
                var desiredSprite = "btn" + me.sprite.id.substr(3, 1) + "arrow";
                var spriteToDeHiLit = App.dc1.getSprite(desiredSprite);

                spriteToDeHiLit.getAnimation().stop();
                spriteToDeHiLit.setAttributes({ fill: '#000' });
            }
        };

        var onClick = function (me, event, eventOpts) {
            if (me.sprite.id.match(/^btn[12]/)) {
                me.sprite.getAnimation().stop();
                var spriteToRotate = App.dc1.getSprite("img");
                if (!fxApplied) {
                    spriteToRotate.setAttributes({ duration: 1000, easing: "easeInOut" });
                    fxApplied = true;
                }

                var degreesToGo = 45;
                if (me.sprite.id[3] == 1) degreesToGo *= -1;
                spriteToRotate.rotateDegrees(degreesToGo);
            }
        };

        // There's not DrawContainer.getSprite() method. This re-implements it
        Ext.override(Ext.draw.Container, {
            getSprite: function (id) {
                me = this;
                var spriteList = this.items.items[0].getItems();
                for (var i = 0; i < spriteList.length; i++)
                    if (spriteList[i].id == id) return spriteList[i];
                return null;
            }
        });

        Ext.override(Ext.draw.sprite.Sprite, {
            // set attribute and repaint the sprite at one shot
            updateAttributes: function (attr, bypassNorm, avoidCopy) {
                this.setAttributes(attr, bypassNorm, avoidCopy);
                this.repaint();
            },
            // gets current rotation and add the specified angle in degrees
            rotateDegrees: function (angle) {
                this.updateAttributes({ rotationRads: this.attr.rotationRads + Ext.draw.Draw.rad(angle) });
            }
        });
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
                <ext:DrawContainer runat="server" ID="dc1"
                    Width="640"
                    Height="480">
                    <Items>
                        <ext:CircleSprite
                            CX="320"
                            CY="240"
                            Radius="200"
                            FillStyle="#000"
                            FillOpacity="0.5"
                            LineWidth="5" />

                        <ext:ImageSprite SpriteID="img"
                            Src="bd.jpg"
                            X="160"
                            Y="120"
                            Width="320"
                            Height="240" />

                        <ext:PathSprite SpriteID="btn1arrow"
                            Path="M12.582 9.551C3.251 16.237 0.921 29.021 7.08 38.564l-2.36 1.689l4.893 2.262l4.893 2.262l-0.568-5.36l-0.567-5.359l-2.365 1.694c-4.657-7.375-2.83-17.185 4.352-22.33c7.451-5.338 17.817-3.625 23.156 3.824c5.337 7.449 3.625 17.813-3.821 23.152l2.857 3.988c9.617-6.893 11.827-20.277 4.935-29.896C35.591 4.87 22.204 2.658 12.582 9.551z"
                            StrokeStyle="none"
                            FillStyle="#000"
                            TranslationX="10"
                            TranslationY="181" />

                        <ext:CircleSprite SpriteID="btn1outline"
                            CX="25"
                            CY="27"
                            Radius="27"
                            StrokeStyle="#ccc"
                            FillStyle="#fff"
                            FillOpacity="0"
                            LineWidth="2"
                            TranslationX="10"
                            TranslationY="181" />

                        <ext:PathSprite SpriteID="btn2arrow"
                            Path="M37.566 9.551c9.331 6.686 11.661 19.471 5.502 29.014l2.36 1.689l-4.893 2.262l-4.893 2.262l0.568-5.36l0.567-5.359l2.365 1.694c4.657-7.375 2.83-17.185-4.352-22.33c-7.451-5.338-17.817-3.625-23.156 3.824C6.3 24.695 8.012 35.06 15.458 40.398l-2.857 3.988C2.983 37.494 0.773 24.109 7.666 14.49C14.558 4.87 27.944 2.658 37.566 9.551z"
                            StrokeStyle="none"
                            FillStyle="#000"
                            TranslationX="10"
                            TranslationY="245" />

                        <ext:CircleSprite SpriteID="btn2outline"
                            CX="25"
                            CY="27"
                            Radius="27"
                            StrokeStyle="#ccc"
                            FillStyle="#fff"
                            FillOpacity="0"
                            LineWidth="2"
                            TranslationX="10"
                            TranslationY="245" />
                    </Items>
                    <Plugins>
                        <ext:SpriteEvents runat="server" />
                    </Plugins>
                    <Listeners>
                        <SpriteMouseOver Fn="onMouseOver" />
                        <SpriteMouseOut Fn="onMouseOut" />
                        <SpriteClick Fn="onClick" />
                    </Listeners>
                </ext:DrawContainer>
            </Items>
        </ext:Viewport>
    </form>
</body>
</html>
