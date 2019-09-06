﻿Imports System.Windows.Forms
Imports DWSIM.Interfaces.Enums.GraphicObjects
Imports DWSIM.SharedClasses.UnitOperations
Imports su = DWSIM.SharedClasses.SystemsOfUnits
Imports WeifenLuo.WinFormsUI.Docking

Public Class EditingForm_Valve

    Inherits WeifenLuo.WinFormsUI.Docking.DockContent

    Public Property SimObject As UnitOperations.Valve

    Public Loaded As Boolean = False

    Dim units As SharedClasses.SystemsOfUnits.Units
    Dim nf As String

    Private Sub EditingForm_HeaterCooler_Load(sender As Object, e As EventArgs) Handles MyBase.Load

        UpdateInfo()

    End Sub

    Sub UpdateInfo()

        units = SimObject.FlowSheet.FlowsheetOptions.SelectedUnitSystem
        nf = SimObject.FlowSheet.FlowsheetOptions.NumberFormat

        Loaded = False

        With SimObject

            'first block

            chkActive.Checked = .GraphicObject.Active

            Me.Text = .GetDisplayName() & ": " & .GraphicObject.Tag

            lblTag.Text = .GraphicObject.Tag
            If .Calculated Then
                lblStatus.Text = .FlowSheet.GetTranslatedString("Calculado") & " (" & .LastUpdated.ToString & ")"
                lblStatus.ForeColor = Drawing.Color.Blue
            Else
                If Not .GraphicObject.Active Then
                    lblStatus.Text = .FlowSheet.GetTranslatedString("Inativo")
                    lblStatus.ForeColor = Drawing.Color.Gray
                ElseIf .ErrorMessage <> "" Then
                    If .ErrorMessage.Length > 50 Then
                        lblStatus.Text = .FlowSheet.GetTranslatedString("Erro") & " (" & .ErrorMessage.Substring(50) & "...)"
                    Else
                        lblStatus.Text = .FlowSheet.GetTranslatedString("Erro") & " (" & .ErrorMessage & ")"
                    End If
                    lblStatus.ForeColor = Drawing.Color.Red
                Else
                    lblStatus.Text = .FlowSheet.GetTranslatedString("NoCalculado")
                    lblStatus.ForeColor = Drawing.Color.Black
                End If
            End If

            lblConnectedTo.Text = ""

            If .IsSpecAttached Then lblConnectedTo.Text = .FlowSheet.SimulationObjects(.AttachedSpecId).GraphicObject.Tag
            If .IsAdjustAttached Then lblConnectedTo.Text = .FlowSheet.SimulationObjects(.AttachedAdjustId).GraphicObject.Tag

            'connections

            Dim mslist As String() = .FlowSheet.GraphicObjects.Values.Where(Function(x) x.ObjectType = ObjectType.MaterialStream).Select(Function(m) m.Tag).ToArray

            cbInlet1.Items.Clear()
            cbInlet1.Items.AddRange(mslist)

            cbOutlet1.Items.Clear()
            cbOutlet1.Items.AddRange(mslist)

            If .GraphicObject.InputConnectors(0).IsAttached Then cbInlet1.SelectedItem = .GraphicObject.InputConnectors(0).AttachedConnector.AttachedFrom.Tag
            If .GraphicObject.OutputConnectors(0).IsAttached Then cbOutlet1.SelectedItem = .GraphicObject.OutputConnectors(0).AttachedConnector.AttachedTo.Tag

            'property package

            Dim proppacks As String() = .FlowSheet.PropertyPackages.Values.Select(Function(m) m.Tag).ToArray
            cbPropPack.Items.Clear()
            cbPropPack.Items.AddRange(proppacks)
            cbPropPack.SelectedItem = .PropertyPackage.Tag

            Dim flashalgos As String() = .FlowSheet.FlowsheetOptions.FlashAlgorithms.Select(Function(x) x.Tag).ToArray
            cbFlashAlg.Items.Clear()
            cbFlashAlg.Items.Add("Default")
            cbFlashAlg.Items.AddRange(flashalgos)
            If .PreferredFlashAlgorithmTag <> "" Then cbFlashAlg.SelectedItem = .PreferredFlashAlgorithmTag Else cbFlashAlg.SelectedIndex = 0

            'annotation

            Try
                rtbAnnotations.Rtf = .Annotation
            Catch ex As Exception

            End Try

            'parameters

            cbPress.Items.Clear()
            cbPress.Items.AddRange(units.GetUnitSet(Interfaces.Enums.UnitOfMeasure.pressure).ToArray)
            cbPress.SelectedItem = units.pressure

            cbPressureDropU.Items.Clear()
            cbPressureDropU.Items.AddRange(units.GetUnitSet(Interfaces.Enums.UnitOfMeasure.deltaP).ToArray)
            cbPressureDropU.SelectedItem = units.deltaP

            cbTemp.Items.Clear()
            cbTemp.Items.AddRange(units.GetUnitSet(Interfaces.Enums.UnitOfMeasure.temperature).ToArray)
            cbTemp.SelectedItem = units.temperature

            cbDeltaT.Items.Clear()
            cbDeltaT.Items.AddRange(units.GetUnitSet(Interfaces.Enums.UnitOfMeasure.deltaT).ToArray)
            cbDeltaT.SelectedItem = units.deltaT

            Dim uobj = SimObject

            Select Case uobj.CalcMode
                Case UnitOperations.Valve.CalculationMode.OutletPressure
                    cbCalcMode.SelectedIndex = 0
                Case UnitOperations.Valve.CalculationMode.DeltaP
                    cbCalcMode.SelectedIndex = 1
            End Select

            tbOutletPressure.Text = su.Converter.ConvertFromSI(units.pressure, uobj.OutletPressure.GetValueOrDefault).ToString(nf)
            tbPressureDrop.Text = su.Converter.ConvertFromSI(units.deltaP, uobj.DeltaP.GetValueOrDefault).ToString(nf)
            tbTemp.Text = su.Converter.ConvertFromSI(units.temperature, uobj.OutletTemperature).ToString(nf)
            tbDeltaT.Text = su.Converter.ConvertFromSI(units.deltaT, uobj.DeltaT.GetValueOrDefault).ToString(nf)

        End With

        Loaded = True

    End Sub

    Private Sub btnConfigurePP_Click(sender As Object, e As EventArgs) Handles btnConfigurePP.Click
        SimObject.FlowSheet.PropertyPackages.Values.Where(Function(x) x.Tag = cbPropPack.SelectedItem.ToString).SingleOrDefault.DisplayEditingForm()
    End Sub

    Private Sub btnConfigureFlashAlg_Click(sender As Object, e As EventArgs) Handles btnConfigureFlashAlg.Click

        Thermodynamics.Calculator.ConfigureFlashInstance(SimObject, cbFlashAlg.SelectedItem.ToString)

    End Sub

    Private Sub lblTag_TextChanged(sender As Object, e As EventArgs) Handles lblTag.TextChanged
        If Loaded Then SimObject.GraphicObject.Tag = lblTag.Text
        Me.Text = SimObject.GetDisplayName() & ": " & SimObject.GraphicObject.Tag
        If Loaded Then SimObject.FlowSheet.UpdateOpenEditForms()
        DirectCast(SimObject.FlowSheet, Interfaces.IFlowsheetGUI).UpdateInterface()
        lblTag.Focus()
        lblTag.SelectionStart = Math.Max(0, lblTag.Text.Length)
        lblTag.SelectionLength = 0
    End Sub

    Private Sub btnDisconnect1_Click(sender As Object, e As EventArgs) Handles btnDisconnect1.Click
        If cbInlet1.SelectedItem IsNot Nothing Then
            SimObject.FlowSheet.DisconnectObjects(SimObject.GraphicObject.InputConnectors(0).AttachedConnector.AttachedFrom, SimObject.GraphicObject)
            cbInlet1.SelectedItem = Nothing
        End If
    End Sub

    Private Sub btnDisconnectOutlet1_Click(sender As Object, e As EventArgs) Handles btnDisconnectOutlet1.Click
        If cbOutlet1.SelectedItem IsNot Nothing Then
            SimObject.FlowSheet.DisconnectObjects(SimObject.GraphicObject, SimObject.GraphicObject.OutputConnectors(0).AttachedConnector.AttachedTo)
            cbOutlet1.SelectedItem = Nothing
        End If
    End Sub

    Private Sub cbCalcMode_SelectedIndexChanged(sender As Object, e As EventArgs) Handles cbCalcMode.SelectedIndexChanged

        'Pressão na Saída
        'Variação da Pressão
        Select Case cbCalcMode.SelectedIndex
            Case 0
                tbPressureDrop.Enabled = False
                tbOutletPressure.Enabled = True
                SimObject.CalcMode = UnitOperations.Valve.CalculationMode.OutletPressure
            Case 1
                tbPressureDrop.Enabled = True
                tbOutletPressure.Enabled = False
                SimObject.CalcMode = UnitOperations.Valve.CalculationMode.DeltaP
        End Select

    End Sub

    Private Sub cb_SelectedIndexChanged(sender As Object, e As EventArgs) Handles cbPressureDropU.SelectedIndexChanged,
                                                                                  cbPress.SelectedIndexChanged

        If Loaded Then
            Try
                If sender Is cbPress Then
                    tbOutletPressure.Text = su.Converter.Convert(cbPress.SelectedItem.ToString, units.pressure, Double.Parse(tbOutletPressure.Text)).ToString(nf)
                    cbPress.SelectedItem = units.pressure
                    UpdateProps(tbOutletPressure)
                ElseIf sender Is cbPressureDropU Then
                    tbPressureDrop.Text = su.Converter.Convert(cbPressureDropU.SelectedItem.ToString, units.deltaP, Double.Parse(tbPressureDrop.Text)).ToString(nf)
                    cbPressureDropU.SelectedItem = units.deltaP
                    UpdateProps(tbPressureDrop)
                End If
            Catch ex As Exception
                SimObject.FlowSheet.ShowMessage(ex.Message.ToString, Interfaces.IFlowsheet.MessageType.GeneralError)
            End Try
        End If

    End Sub

    Sub UpdateProps(sender As Object)

        'Pressão na Saída
        'Variação da Pressão

        Dim uobj = SimObject

        Select Case cbCalcMode.SelectedIndex
            Case 0
                uobj.CalcMode = UnitOperations.Valve.CalculationMode.OutletPressure
            Case 1
                uobj.CalcMode = UnitOperations.Valve.CalculationMode.DeltaP
        End Select

        If sender Is tbOutletPressure Then uobj.OutletPressure = su.Converter.ConvertToSI(cbPress.SelectedItem.ToString, tbOutletPressure.Text)
        If sender Is tbPressureDrop Then uobj.DeltaP = su.Converter.ConvertToSI(cbPressureDropU.SelectedItem.ToString, tbPressureDrop.Text)

        RequestCalc()

    End Sub

    Sub RequestCalc()

        SimObject.FlowSheet.RequestCalculation(SimObject)

    End Sub

    Private Sub tb_TextChanged(sender As Object, e As EventArgs) Handles tbPressureDrop.TextChanged, tbOutletPressure.TextChanged

        Dim tbox = DirectCast(sender, TextBox)

        If Double.TryParse(tbox.Text, New Double()) Then
            tbox.ForeColor = Drawing.Color.Blue
        Else
            tbox.ForeColor = Drawing.Color.Red
        End If

    End Sub

    Private Sub TextBoxKeyDown(sender As Object, e As KeyEventArgs) Handles tbPressureDrop.KeyDown, tbOutletPressure.KeyDown

        If e.KeyCode = Keys.Enter And Loaded And DirectCast(sender, TextBox).ForeColor = Drawing.Color.Blue Then

            UpdateProps(sender)

            DirectCast(sender, TextBox).SelectAll()

        End If

    End Sub

    Private Sub cbPropPack_SelectedIndexChanged(sender As Object, e As EventArgs) Handles cbPropPack.SelectedIndexChanged
        If Loaded Then
            SimObject.PropertyPackage = SimObject.FlowSheet.PropertyPackages.Values.Where(Function(x) x.Tag = cbPropPack.SelectedItem.ToString).SingleOrDefault
            RequestCalc()
        End If
    End Sub

    Private Sub cbFlashAlg_SelectedIndexChanged(sender As Object, e As EventArgs) Handles cbFlashAlg.SelectedIndexChanged
        If Loaded Then
            SimObject.PreferredFlashAlgorithmTag = cbFlashAlg.SelectedItem.ToString
            RequestCalc()
        End If
    End Sub

    Private Sub cbInlet1_SelectedIndexChanged(sender As Object, e As EventArgs) Handles cbInlet1.SelectedIndexChanged

        If Loaded Then

            Dim text As String = cbInlet1.Text

            If text <> "" Then

                Dim index As Integer = 0

                Dim gobj = SimObject.GraphicObject
                Dim flowsheet = SimObject.FlowSheet

                If flowsheet.GetFlowsheetSimulationObject(text).GraphicObject.OutputConnectors(0).IsAttached Then
                    MessageBox.Show(flowsheet.GetTranslatedString("Todasasconexespossve"), flowsheet.GetTranslatedString("Erro"), MessageBoxButtons.OK, MessageBoxIcon.Error)
                    Exit Sub
                End If
                If gobj.InputConnectors(index).IsAttached Then flowsheet.DisconnectObjects(gobj.InputConnectors(index).AttachedConnector.AttachedFrom, gobj)
                flowsheet.ConnectObjects(flowsheet.GetFlowsheetSimulationObject(text).GraphicObject, gobj, 0, index)

            End If

        End If

    End Sub

    Private Sub cbOutlet1_SelectedIndexChanged(sender As Object, e As EventArgs) Handles cbOutlet1.SelectedIndexChanged

        If Loaded Then

            Dim text As String = cbOutlet1.Text

            If text <> "" Then

                Dim index As Integer = 0

                Dim gobj = SimObject.GraphicObject
                Dim flowsheet = SimObject.FlowSheet

                If flowsheet.GetFlowsheetSimulationObject(text).GraphicObject.InputConnectors(0).IsAttached Then
                    MessageBox.Show(flowsheet.GetTranslatedString("Todasasconexespossve"), flowsheet.GetTranslatedString("Erro"), MessageBoxButtons.OK, MessageBoxIcon.Error)
                    Exit Sub
                End If
                If gobj.OutputConnectors(0).IsAttached Then flowsheet.DisconnectObjects(gobj, gobj.OutputConnectors(0).AttachedConnector.AttachedTo)
                flowsheet.ConnectObjects(gobj, flowsheet.GetFlowsheetSimulationObject(text).GraphicObject, 0, 0)

            End If

        End If

    End Sub

    Private Sub rtbAnnotations_RtfChanged(sender As Object, e As EventArgs) Handles rtbAnnotations.RtfChanged
        If Loaded Then SimObject.Annotation = rtbAnnotations.Rtf
    End Sub

    Private Sub chkActive_CheckedChanged(sender As Object, e As EventArgs) Handles chkActive.CheckedChanged
        If Loaded Then SimObject.GraphicObject.Active = chkActive.Checked
    End Sub

    Private Sub btnCreateAndConnectInlet1_Click(sender As Object, e As EventArgs) Handles btnCreateAndConnectInlet1.Click, btnCreateAndConnectOutlet1.Click

        Dim sgobj = SimObject.GraphicObject
        Dim fs = SimObject.FlowSheet

        Dim iidx As Integer = -1
        Dim oidx As Integer = -1

        If sender Is btnCreateAndConnectInlet1 Then

            iidx = 0

        ElseIf sender Is btnCreateAndConnectOutlet1 Then

            oidx = 0

        End If

        If iidx >= 0 Then

            Dim obj = fs.AddObject(ObjectType.MaterialStream, sgobj.InputConnectors(iidx).Position.X - 50, sgobj.InputConnectors(iidx).Position.Y, "")

            If sgobj.InputConnectors(iidx).IsAttached Then fs.DisconnectObjects(sgobj.InputConnectors(iidx).AttachedConnector.AttachedFrom, sgobj)
            fs.ConnectObjects(obj.GraphicObject, sgobj, 0, iidx)

        End If

        If oidx >= 0 Then

            Dim obj = fs.AddObject(ObjectType.MaterialStream, sgobj.OutputConnectors(oidx).Position.X + 30, sgobj.OutputConnectors(oidx).Position.Y, "")

            If sgobj.OutputConnectors(oidx).IsAttached Then fs.DisconnectObjects(sgobj, sgobj.OutputConnectors(oidx).AttachedConnector.AttachedTo)
            fs.ConnectObjects(sgobj, obj.GraphicObject, oidx, 0)

        End If

        UpdateInfo()
        RequestCalc()

    End Sub
    Private Sub btnUtils_Click(sender As Object, e As EventArgs) Handles btnUtils.Click
        UtilitiesCtxMenu.Show(btnUtils, New Drawing.Point(20, 0))
    End Sub

    Private Sub sizingtsmi_Click(sender As Object, e As EventArgs) Handles sizingtsmi.Click

        Dim utility As Interfaces.IAttachedUtility = SimObject.FlowSheet.GetUtility(Enums.FlowsheetUtility.PSVSizing)
        utility.Name = "PressureSafetyValveSizing" & (SimObject.AttachedUtilities.Where(Function(x) x.GetUtilityType = Interfaces.Enums.FlowsheetUtility.PSVSizing).Count + 1).ToString

        utility.AttachedTo = SimObject

        With DirectCast(utility, DockContent)
            .ShowHint = WeifenLuo.WinFormsUI.Docking.DockState.Float
        End With

        SimObject.AttachedUtilities.Add(utility)
        SimObject.FlowSheet.DisplayForm(utility)

        AddHandler DirectCast(utility, Form).FormClosed, Sub()
                                                             utility.AttachedTo = Nothing
                                                             SimObject.AttachedUtilities.Remove(utility)
                                                         End Sub
    End Sub

    Private Sub UtilitiesCtxMenu_Opening(sender As Object, e As System.ComponentModel.CancelEventArgs) Handles UtilitiesCtxMenu.Opening

        For Each item In SimObject.AttachedUtilities
            Dim ts As New ToolStripMenuItem(item.Name)
            AddHandler ts.Click, Sub()
                                     Dim f = DirectCast(item, DockContent)
                                     If f.Visible Then
                                         f.Select()
                                     Else
                                         SimObject.FlowSheet.DisplayForm(f)
                                     End If
                                 End Sub
            UtilitiesCtxMenu.Items.Add(ts)
            AddHandler UtilitiesCtxMenu.Closed, Sub() If UtilitiesCtxMenu.Items.Contains(ts) Then UtilitiesCtxMenu.Items.Remove(ts)
            AddHandler DirectCast(item, DockContent).FormClosed, Sub()
                                                                     SimObject.AttachedUtilities.Remove(item)
                                                                     item.AttachedTo = Nothing
                                                                 End Sub
        Next

    End Sub


End Class