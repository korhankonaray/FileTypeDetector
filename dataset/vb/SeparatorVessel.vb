﻿Imports DWSIM.Drawing.SkiaSharp.GraphicObjects
Imports DWSIM.Interfaces.Enums.GraphicObjects

Namespace GraphicObjects.Shapes

    Public Class VesselGraphic

        Inherits ShapeGraphic

#Region "Constructors"

        Public Sub New()
            Me.ObjectType = DWSIM.Interfaces.Enums.GraphicObjects.ObjectType.Vessel
            Me.Description = "Vapor-Liquid Separator"
        End Sub

        Public Sub New(ByVal graphicPosition As SKPoint)
            Me.New()
            Me.SetPosition(graphicPosition)
        End Sub

        Public Sub New(ByVal posX As Integer, ByVal posY As Integer)
            Me.New(New SKPoint(posX, posY))
        End Sub

        Public Sub New(ByVal graphicPosition As SKPoint, ByVal graphicSize As SKSize)
            Me.New(graphicPosition)
            Me.SetSize(graphicSize)
        End Sub

        Public Sub New(ByVal posX As Integer, ByVal posY As Integer, ByVal graphicSize As SKSize)
            Me.New(New SKPoint(posX, posY), graphicSize)
        End Sub

        Public Sub New(ByVal posX As Integer, ByVal posY As Integer, ByVal width As Integer, ByVal height As Integer)
            Me.New(New SKPoint(posX, posY), New SKSize(width, height))
        End Sub

#End Region

        Public Overrides Sub CreateConnectors(InCount As Integer, OutCount As Integer)

            Dim myIC1 As New ConnectionPoint
            myIC1.Position = New Point(X + 0.25 * Width, Y + 1 / 7 * Height)
            myIC1.Type = ConType.ConIn

            Dim myIC2 As New ConnectionPoint
            myIC2.Position = New Point(X + 0.25 * Width, Y + 2 / 7 * Height)
            myIC2.Type = ConType.ConIn

            Dim myIC3 As New ConnectionPoint
            myIC3.Position = New Point(X + 0.25 * Width, Y + 3 / 7 * Height)
            myIC3.Type = ConType.ConIn

            Dim myIC4 As New ConnectionPoint
            myIC4.Position = New Point(X + 0.25 * Width, Y + 4 / 7 * Height)
            myIC4.Type = ConType.ConIn

            Dim myIC5 As New ConnectionPoint
            myIC5.Position = New Point(X + 0.25 * Width, Y + 5 / 7 * Height)
            myIC5.Type = ConType.ConIn

            Dim myIC6 As New ConnectionPoint
            myIC6.Position = New Point(X + 0.25 * Width, Y + 6 / 7 * Height)
            myIC6.Type = ConType.ConIn

            Dim myOC1 As New ConnectionPoint
            myOC1.Position = New Point(X + 0.827 * Width, Y + (1 / 7) * Height)
            myOC1.Type = ConType.ConOut

            Dim myOC2 As New ConnectionPoint
            myOC2.Position = New Point(X + 0.827 * Width, Y + (6 / 7) * Height)
            myOC2.Type = ConType.ConOut

            Dim myOC3 As New ConnectionPoint
            myOC3.Position = New Point(X + 0.5 * Width, Y + Height)
            myOC3.Type = ConType.ConOut
            myOC3.Direction = ConDir.Down

            Dim myIC7 As New ConnectionPoint
            myIC7.Position = New Point(X + 0.25 * Width, Y + 1 * Height)
            myIC7.Type = ConType.ConEn
            myIC7.Direction = ConDir.Up

            With InputConnectors

                If .Count <> 0 Then
                    If .Count = 1 Then
                        .Add(myIC2)
                        .Add(myIC3)
                        .Add(myIC4)
                        .Add(myIC5)
                        .Add(myIC6)
                        .Add(myIC7)
                    End If
                    If .Count = 6 Then
                        .Add(myIC7)
                    End If
                    If Not Me.FlippedH Then
                        .Item(0).Position = New Point(X + 0.25 * Width, Y + 1 / 7 * Height)
                        .Item(1).Position = New Point(X + 0.25 * Width, Y + 2 / 7 * Height)
                        .Item(2).Position = New Point(X + 0.25 * Width, Y + 3 / 7 * Height)
                        .Item(3).Position = New Point(X + 0.25 * Width, Y + 4 / 7 * Height)
                        .Item(4).Position = New Point(X + 0.25 * Width, Y + 5 / 7 * Height)
                        .Item(5).Position = New Point(X + 0.25 * Width, Y + 6 / 7 * Height)
                        .Item(6).Position = New Point(X + 0.25 * Width, Y + 1 * Height)
                    Else
                        .Item(0).Position = New Point(X + (1 - 0.25) * Width, Y + 1 / 7 * Height)
                        .Item(1).Position = New Point(X + (1 - 0.25) * Width, Y + 2 / 7 * Height)
                        .Item(2).Position = New Point(X + (1 - 0.25) * Width, Y + 3 / 7 * Height)
                        .Item(3).Position = New Point(X + (1 - 0.25) * Width, Y + 4 / 7 * Height)
                        .Item(4).Position = New Point(X + (1 - 0.25) * Width, Y + 5 / 7 * Height)
                        .Item(5).Position = New Point(X + (1 - 0.25) * Width, Y + 6 / 7 * Height)
                        .Item(6).Position = New Point(X + (1 - 0.25) * Width, Y + 1 * Height)
                    End If
                Else
                    .Add(myIC1)
                    .Add(myIC2)
                    .Add(myIC3)
                    .Add(myIC4)
                    .Add(myIC5)
                    .Add(myIC6)
                    .Add(myIC7)
                End If

            End With

            For Each c In InputConnectors
                c.ConnectorName = "Inlet Stream #" & InputConnectors.IndexOf(c)
                If c.Type = ConType.ConEn Then c.ConnectorName = "Energy Stream"
            Next

            With OutputConnectors

                If .Count = 2 Then .Add(myOC3)

                If .Count <> 0 Then
                    If Me.FlippedH Then
                        .Item(0).Position = New Point(X + 0.3 * Width, Y + 1 / 7 * Height)
                        .Item(1).Position = New Point(X + 0.3 * Width, Y + 6 / 7 * Height)
                        .Item(2).Position = New Point(X + 0.5 * Width, Y + Height)
                    Else
                        .Item(0).Position = New Point(X + 0.827 * Width, Y + 1 / 7 * Height)
                        .Item(1).Position = New Point(X + 0.827 * Width, Y + 6 / 7 * Height)
                        .Item(2).Position = New Point(X + 0.5 * Width, Y + Height)
                    End If
                Else
                    .Add(myOC1)
                    .Add(myOC2)
                    .Add(myOC3)
                End If

                .Item(0).ConnectorName = "Vapor Outlet"
                .Item(1).ConnectorName = "Light Liquid Outlet"
                .Item(2).ConnectorName = "Heavy Liquid Outlet"

            End With

            Me.EnergyConnector.Active = False

        End Sub

        Public Overrides Sub Draw(ByVal g As Object)

            Dim canvas As SKCanvas = DirectCast(g, SKCanvas)

            CreateConnectors(0, 0)
            UpdateStatus()

            MyBase.Draw(g)

         
            Dim myPen As New SKPaint()
            With myPen
                .Color = LineColor
                .StrokeWidth = LineWidth
                .IsStroke = Not Fill
                .IsAntialias = GlobalSettings.Settings.DrawingAntiAlias
            End With

            Dim rect3 As New SKRect(X + 0.7 * Width, Y + 0.1 * Height, X + 0.827 * Width, Y + 0.227 * Height)
            Dim rect4 As New SKRect(X + 0.7 * Width, Y + 0.773 * Height, X + 0.827 * Width, Y + (0.773 + 0.127) * Height)
            If Me.FlippedH = True Then
                rect3 = New SKRect(X + 0.3 * Width, Y + 0.1 * Height, X + 0.427 * Width, Y + 0.227 * Height)
                rect4 = New SKRect(X + 0.3 * Width, Y + 0.773 * Height, X + 0.427 * Width, Y + (0.773 + 0.127) * Height)
            End If

            canvas.DrawRoundRect(rect3, 2, 2, myPen)
            canvas.DrawRoundRect(rect4, 2, 2, myPen)

            Dim radius As Integer = 2

            Dim gp As New SKPath()

            gp.MoveTo(X + radius, Y)

            gp.LineTo(X + Width - radius, Y)
            gp.AddArc(New SKRect(X + Width - radius, Y, X + Width, Y + radius), 270, 90)
            gp.LineTo(X + Width, Y + Height - radius)
            gp.AddArc(New SKRect(X + Width - radius, Y + Height - radius, X + Width, Y + radius), 0, 90)
            gp.LineTo(X + radius, Y + Height)
            gp.AddArc(New SKRect(X, Y + Height - radius, X + Width, Y + radius), 90, 90)
            gp.LineTo(X, Y + radius)
            gp.AddArc(New SKRect(X, Y, X + radius, Y + radius), 180, 90)

            gp.Close()

            If Me.FlippedH = True Then
                canvas.DrawRoundRect(New SKRect(X + 0.4 * Width, Y, X + 0.85 * Width, Y + Height), 6, 6, myPen)
            Else
                canvas.DrawRoundRect(New SKRect(X + 0.25 * Width, Y, X + 0.7 * Width, Y + Height), 6, 6, myPen)
            End If
          
        End Sub

    End Class

End Namespace