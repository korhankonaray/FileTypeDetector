﻿'    Copyright 2008-2015 Daniel Wagner O. de Medeiros
'
'    This file is part of DWSIM.
'
'    DWSIM is free software: you can redistribute it and/or modify
'    it under the terms of the GNU General Public License as published by
'    the Free Software Foundation, either version 3 of the License, or
'    (at your option) any later version.
'
'    DWSIM is distributed in the hope that it will be useful,
'    but WITHOUT ANY WARRANTY; without even the implied warranty of
'    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
'    GNU General Public License for more details.
'
'    You should have received a copy of the GNU General Public License
'    along with DWSIM.  If not, see <http://www.gnu.org/licenses/>.

Imports DWSIM.Thermodynamics.BaseClasses
Imports System.Runtime.Serialization.Formatters.Binary
Imports System.Runtime.Serialization.Formatters
Imports System.Globalization
Imports System.Linq
Imports DWSIM.Interfaces.Enums

Public Class FormReacManager

    Inherits WeifenLuo.WinFormsUI.Docking.DockContent

    Protected frmchild As FormFlowsheet
    Public col As BaseClasses.ReactionsCollection

    Sub New()

        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        If DWSIM.App.IsRunningOnMono Then Me.ShowHint = WeifenLuo.WinFormsUI.Docking.DockState.Float

    End Sub

    Private Sub FormReacManager_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load

        frmchild = My.Application.ActiveSimulation

        With Me.GridRSets.Rows
            For Each rxnset As ReactionSet In frmchild.Options.ReactionSets.Values
                .Add(New Object() {rxnset.Name, rxnset.Description, rxnset.ID})
            Next
        End With

        With Me.GridRxns.Rows
            For Each rxn As Reaction In frmchild.Options.Reactions.Values
                .Add(New Object() {rxn.Name, rxn.ReactionType, rxn.Equation, rxn.ID})
            Next
        End With

        Me.TabText = Me.Text

        If Not Me.DockHandler Is Nothing OrElse Not Me.DockHandler.FloatPane Is Nothing Then
            ' set the bounds of this form's FloatWindow to our desired position and size
            If Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.Float Then
                Dim floatWin = Me.DockHandler.FloatPane.FloatWindow
                If Not floatWin Is Nothing Then
                    floatWin.SetBounds(floatWin.Location.X, floatWin.Location.Y, 440, 490)
                End If
            End If
        End If

    End Sub

    Private Sub KryptonButton8_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButton1.Click
        Dim rse As New FormReacSetEditor
        rse.ShowDialog()
        rse.Dispose()
        With Me.GridRSets.Rows
            .Clear()
            For Each rs1 As ReactionSet In frmchild.Options.ReactionSets.Values
                .Add(New Object() {rs1.Name, rs1.Description, rs1.ID})
            Next
        End With
    End Sub

    Private Sub KryptonContextMenuItem1_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles ConversaoToolStripMenuItem.Click
        Dim frc As New FormReacConv
        Dim result As MsgBoxResult = frc.ShowDialog()
        With Me.GridRxns.Rows
            .Clear()
            For Each rxn As Reaction In frmchild.Options.Reactions.Values
                .Add(New Object() {rxn.Name, rxn.ReactionType, rxn.Equation, rxn.ID})
            Next
        End With
        frc.Dispose()
    End Sub

    Private Sub KryptonContextMenuItem2_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles EquilibrioToolStripMenuItem.Click
        Dim fre As New FormReacEq
        fre.ShowDialog()
        fre.Dispose()
        With Me.GridRxns.Rows
            .Clear()
            For Each rxn As Reaction In frmchild.Options.Reactions.Values
                .Add(New Object() {rxn.Name, rxn.ReactionType, rxn.Equation, rxn.ID})
            Next
        End With
    End Sub

    Private Sub KryptonContextMenuItem3_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles CineticaToolStripMenuItem.Click
        Dim frk As New FormReacKinetic
        frk.ShowDialog()
        frk.Dispose()
        With Me.GridRxns.Rows
            .Clear()
            For Each rxn As Reaction In frmchild.Options.Reactions.Values
                .Add(New Object() {rxn.Name, rxn.ReactionType, rxn.Equation, rxn.ID})
            Next
        End With
    End Sub

    Private Sub KryptonButton4_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButton4.Click

        Dim myStream As System.IO.FileStream
        col = New ReactionsCollection
        col.Collection = New BaseClasses.Reaction(frmchild.Options.Reactions.Count - 1) {}
        frmchild.Options.Reactions.Values.CopyTo(col.Collection, 0)

        If Me.SaveFileDialog1.ShowDialog() = Windows.Forms.DialogResult.OK Then
            myStream = Me.SaveFileDialog1.OpenFile()
            If Not (myStream Is Nothing) Then
                Dim filename As String = myStream.Name
                Select Case Me.SaveFileDialog1.FilterIndex
                    Case 1
                        Dim mySerializer As Binary.BinaryFormatter = New Binary.BinaryFormatter(Nothing, New System.Runtime.Serialization.StreamingContext())
                        Try
                            mySerializer.Serialize(myStream, col)
                        Catch ex As System.Runtime.Serialization.SerializationException
                            MessageBox.Show(ex.Message, DWSIM.App.GetLocalString("Erro"), MessageBoxButtons.OK, MessageBoxIcon.Error)
                        Finally
                            myStream.Close()
                        End Try
                    Case 2
                        Try
                            Dim xdoc As New XDocument()
                            Dim xel As XElement
                            xdoc.Add(New XElement("DWSIM_Reaction_Data"))
                            xel = xdoc.Element("DWSIM_Reaction_Data")
                            For Each row As DataGridViewRow In GridRxns.SelectedRows
                                xel.Add(New XElement("Reaction", {DirectCast(frmchild.Options.Reactions(row.Cells(3).Value), Interfaces.ICustomXMLSerialization).SaveData().ToArray()}))
                            Next
                            For Each pp As KeyValuePair(Of String, Interfaces.IReaction) In frmchild.Options.Reactions
                            Next
                            xdoc.Save(myStream)
                        Catch ex As Exception
                            MessageBox.Show(ex.Message, DWSIM.App.GetLocalString("Erro"), MessageBoxButtons.OK, MessageBoxIcon.Error)
                        Finally
                            myStream.Close()
                        End Try
                End Select
            End If
        End If
    End Sub

    Private Sub KryptonButton5_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButton9.Click

        Dim myStream As System.IO.FileStream

        If Me.OpenFileDialog1.ShowDialog() = Windows.Forms.DialogResult.OK Then
            myStream = Me.OpenFileDialog1.OpenFile()
            If Not (myStream Is Nothing) Then
                Dim rxns As New ReactionsCollection
                Select Case IO.Path.GetExtension(myStream.Name).ToLower()
                    Case ".dwrxs"
                        Dim nome = myStream.Name
                        Dim myFileStream As IO.FileStream = New IO.FileStream(nome, IO.FileMode.Open)
                        Try
                            myStream.Close()
                            Dim mySerializer As Binary.BinaryFormatter = New Binary.BinaryFormatter(Nothing, New System.Runtime.Serialization.StreamingContext())
                            rxns = DirectCast(mySerializer.Deserialize(myFileStream), ReactionsCollection)
                        Catch ex As Exception
                            MessageBox.Show(ex.Message, DWSIM.App.GetLocalString("Erro"), MessageBoxButtons.OK, MessageBoxIcon.Error)
                        Finally
                            myFileStream.Close()
                        End Try
                    Case ".dwrxm"
                        Try
                            Dim ci As CultureInfo = CultureInfo.InvariantCulture
                            Dim xdoc As XDocument = XDocument.Load(myStream)
                            Dim data As List(Of XElement) = xdoc.Element("DWSIM_Reaction_Data").Elements.ToList
                            Dim rxarr As New ArrayList
                            For Each xel As XElement In data
                                Dim obj As New Reaction()
                                obj.LoadData(xel.Elements.ToList)
                                rxarr.Add(obj)
                            Next
                            rxns.Collection = New Reaction(rxarr.Count - 1) {}
                            rxarr.CopyTo(rxns.Collection, 0)
                        Catch ex As Exception
                            MessageBox.Show(ex.Message, DWSIM.App.GetLocalString("Erro"), MessageBoxButtons.OK, MessageBoxIcon.Error)
                        Finally
                            myStream.Close()
                        End Try
                End Select
                'verify Components
                Dim carray As New ArrayList
                For Each rxn As Reaction In rxns.Collection
                    For Each ssbase As ReactionStoichBase In rxn.Components.Values
                        If Not Me.frmchild.Options.SelectedComponents.ContainsKey(ssbase.CompName) Then
                            If Not carray.Contains(ssbase.CompName) Then carray.Add(ssbase.CompName)
                        End If
                    Next
                Next
                'warn user about missing Components
                If carray.Count > 0 Then
                    Dim str As String = DWSIM.App.GetLocalString("Vocedeveadicionar") & vbCrLf & vbCrLf
                    Dim str2 As String = ""
                    Dim str3 As String = vbCrLf & DWSIM.App.GetLocalString("Vocedeveadicionar1")
                    Dim i As Integer = 0, idx As Integer
                    Do
                        str2 += "- " & (CStr(carray(i))) & vbCrLf
                        i += 1
                    Loop Until i = carray.Count
                    Dim res As MsgBoxResult = MessageBox.Show(str + str2 + str3, DWSIM.App.GetLocalString("Aviso"), MessageBoxButtons.YesNo, MessageBoxIcon.Warning)
                    If res = MsgBoxResult.Yes Then
                        'add Components
                        Dim tmpcomp As New BaseClasses.ConstantProperties
                        i = 0
                        Do
                            If Not Me.frmchild.Options.SelectedComponents.ContainsKey(carray(i)) Then
                                If Not Me.frmchild.Options.NotSelectedComponents.ContainsKey(carray(i)) Then
                                    MessageBox.Show("Component " & carray(i) & " is absent from the list of available components.", "Error", MessageBoxButtons.OK, MessageBoxIcon.Error)
                                Else
                                    tmpcomp = Me.frmchild.Options.NotSelectedComponents(carray(i))
                                    For Each r As DataGridViewRow In Me.frmchild.FrmStSim1.ogc1.Rows
                                        If r.Cells(0).Value = tmpcomp.Name Then
                                            idx = r.Index
                                            Exit For
                                        End If
                                    Next
                                    Me.frmchild.FrmStSim1.AddCompToSimulation(idx)
                                End If
                            End If
                            i += 1
                        Loop Until i = carray.Count
                    End If
                End If
                'add reactions
                For Each rxn As Reaction In rxns.Collection
                    If Not frmchild.Options.Reactions.ContainsKey(rxn.ID) Then
                        Me.frmchild.Options.Reactions.Add(rxn.ID, rxn)
                        Me.GridRxns.Rows.Add(New Object() {rxn.Name, rxn.ReactionType, rxn.Equation, rxn.ID})
                        Me.frmchild.Options.ReactionSets("DefaultSet").Reactions.Add(rxn.ID, New ReactionSetBase(rxn.ID, 0, True))
                    End If
                Next
            End If
        End If

    End Sub

    Private Sub KryptonButton10_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButton7.Click
        If Not Me.GridRxns.SelectedRows.Count = 0 Then
            Dim rxn As Reaction = frmchild.Options.Reactions(Me.GridRxns.SelectedRows(0).Cells(3).Value)
            Dim rxn2 As Reaction = rxn.Clone()
            rxn2.Name = rxn.Name + "1"
            frmchild.Options.Reactions.Add(rxn2.ID, rxn2)
            Me.GridRxns.Rows.Add(New Object() {rxn2.Name, rxn2.ReactionType, rxn2.Equation, rxn2.ID})
        End If

    End Sub

    Private Sub KryptonButton9_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButton8.Click
        If Not Me.GridRxns.SelectedRows.Count = 0 Then
            frmchild.Options.Reactions.Remove(Me.GridRxns.SelectedRows(0).Cells(3).Value)
            UpdateRxnSets()
            With Me.GridRxns.Rows
                .Clear()
                For Each rxn1 As Reaction In frmchild.Options.Reactions.Values
                    .Add(New Object() {rxn1.Name, rxn1.ReactionType, rxn1.Equation, rxn1.ID})
                Next
            End With
        End If
    End Sub

    Private Sub KryptonButton1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButton6.Click
        If Not Me.GridRxns.SelectedRows.Count = 0 Then
            Dim rxn As Reaction = frmchild.Options.Reactions(Me.GridRxns.SelectedRows(0).Cells(3).Value)
            Select Case rxn.ReactionType
                Case ReactionType.Conversion
                    Dim frc As New FormReacConv
                    With frc
                        .mode = "Edit"
                        .rc = rxn
                    End With
                    frc.ShowDialog()
                    frc.Dispose()
                Case ReactionType.Equilibrium
                    Dim fre As New FormReacEq
                    With fre
                        .mode = "Edit"
                        .rc = rxn
                    End With
                    fre.ShowDialog()
                    fre.Dispose()
                Case ReactionType.Kinetic
                    Dim frk As New FormReacKinetic
                    With frk
                        .mode = "Edit"
                        .rc = rxn
                    End With
                    frk.ShowDialog()
                    frk.Dispose()
                Case ReactionType.Heterogeneous_Catalytic
                    Dim frk As New FormReacHeterog
                    With frk
                        .mode = "Edit"
                        .rc = rxn
                    End With
                    frk.ShowDialog()
                    frk.Dispose()
            End Select
            With Me.GridRxns.Rows
                .Clear()
                For Each rxn1 As Reaction In frmchild.Options.Reactions.Values
                    .Add(New Object() {rxn1.Name, rxn1.ReactionType, rxn1.Equation, rxn1.ID})
                Next
            End With

        End If
    End Sub

    Private Sub KryptonButton3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButton2.Click
        If Not Me.GridRSets.SelectedRows.Count = 0 Then
            Dim rxs As ReactionSet = frmchild.Options.ReactionSets(Me.GridRSets.SelectedRows(0).Cells(2).Value)
            If rxs.ID = "DefaultSet" Then
                MessageBox.Show(DWSIM.App.GetLocalString("Naopodeexcluirdefaultset"))
            Else
                frmchild.Options.ReactionSets.Remove(Me.GridRSets.SelectedRows(0).Cells(2).Value)
                Me.GridRSets.Rows.Remove(Me.GridRSets.SelectedRows(0))
            End If
        End If
    End Sub

    Private Sub KryptonButton2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButton5.Click
        If Not Me.GridRSets.SelectedRows.Count = 0 Then
            Dim rxs As ReactionSet = frmchild.Options.ReactionSets(Me.GridRSets.SelectedRows(0).Cells(2).Value)
            If rxs.ID = "DefaultSet" Then
                MessageBox.Show(DWSIM.App.GetLocalString("Naopodecopiardefaultset"))
            Else
                Dim rxs2 As ReactionSet = rxs.Clone()
                rxs2.Name = rxs.Name + "1"
                frmchild.Options.ReactionSets.Add(rxs2.ID, rxs2)
                Me.GridRSets.Rows.Add(New Object() {rxs2.Name, rxs2.Description, rxs2.ID})
            End If
        End If
    End Sub

    Private Sub KryptonButton6_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ToolStripButton3.Click
        If Not Me.GridRSets.SelectedRows.Count = 0 Then
            Dim rset As ReactionSet = frmchild.Options.ReactionSets(Me.GridRSets.SelectedRows(0).Cells(2).Value)
            Dim rse As New FormReacSetEditor
            With rse
                .mode = "Edit"
                .rs = rset
            End With
            rse.ShowDialog()
            rse.Dispose()
            With Me.GridRSets.Rows
                .Clear()
                For Each rs1 As ReactionSet In frmchild.Options.ReactionSets.Values
                    .Add(New Object() {rs1.Name, rs1.Description, rs1.ID})
                Next
            End With
        End If
    End Sub

    Public Sub UpdateRxnSets()

        'check the reactions present in the sets
        Dim remarray As New ArrayList
        For Each rxs As ReactionSet In frmchild.Options.ReactionSets.Values
            For Each rxnbase As ReactionSetBase In rxs.Reactions.Values
                If Not frmchild.Options.Reactions.ContainsKey(rxnbase.ReactionID) Then
                    If Not remarray.Contains(rxnbase.ReactionID) Then remarray.Add(rxnbase.ReactionID)
                End If
            Next
        Next

        'remove non-existent reactions
        If remarray.Count > 0 Then
            Dim i As Integer = 0
            Do
                For Each rxs As ReactionSet In frmchild.Options.ReactionSets.Values
                    If rxs.Reactions.ContainsKey(remarray(i)) Then rxs.Reactions.Remove(remarray(i))
                Next
                i += 1
            Loop Until i = remarray.Count
        End If

        remarray = Nothing

    End Sub

    Private Sub HeterogeneaCataliticaToolStripMenuItem_Click(sender As Object, e As EventArgs) Handles HeterogeneaCataliticaToolStripMenuItem.Click
        Dim frk As New FormReacHeterog
        frk.ShowDialog()
        frk.Dispose()
        With Me.GridRxns.Rows
            .Clear()
            For Each rxn As Reaction In frmchild.Options.Reactions.Values
                .Add(New Object() {rxn.Name, rxn.ReactionType, rxn.Equation, rxn.ID})
            Next
        End With
    End Sub

    Private Sub GridRxns_CellDoubleClick(sender As Object, e As DataGridViewCellEventArgs) Handles GridRxns.CellDoubleClick
        KryptonButton1_Click(sender, e)
    End Sub

    Private Sub GridRSets_CellDoubleClick(sender As Object, e As DataGridViewCellEventArgs) Handles GridRSets.CellDoubleClick
        KryptonButton6_Click(sender, e)
    End Sub

    Private Sub FloatToolStripMenuItem_Click(sender As Object, e As EventArgs) Handles FloatToolStripMenuItem.Click, DocumentToolStripMenuItem.Click,
                                                           DockLeftToolStripMenuItem.Click, DockLeftAutoHideToolStripMenuItem.Click,
                                                           DockRightAutoHideToolStripMenuItem.Click, DockRightToolStripMenuItem.Click,
                                                           DockTopAutoHideToolStripMenuItem.Click, DockTopToolStripMenuItem.Click,
                                                           DockBottomAutoHideToolStripMenuItem.Click, DockBottomToolStripMenuItem.Click

        For Each ts As ToolStripMenuItem In dckMenu.Items
            ts.Checked = False
        Next

        sender.Checked = True

        Select Case sender.Name
            Case "FloatToolStripMenuItem"
                Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.Float
            Case "DocumentToolStripMenuItem"
                Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.Document
            Case "DockLeftToolStripMenuItem"
                Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockLeft
            Case "DockLeftAutoHideToolStripMenuItem"
                Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockLeftAutoHide
            Case "DockRightAutoHideToolStripMenuItem"
                Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockRightAutoHide
            Case "DockRightToolStripMenuItem"
                Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockRight
            Case "DockBottomAutoHideToolStripMenuItem"
                Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockBottomAutoHide
            Case "DockBottomToolStripMenuItem"
                Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockBottom
            Case "DockTopAutoHideToolStripMenuItem"
                Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockTopAutoHide
            Case "DockTopToolStripMenuItem"
                Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockTop
            Case "HiddenToolStripMenuItem"
                Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.Hidden
        End Select

    End Sub


    Private Sub tsbClose_Click(sender As Object, e As EventArgs) Handles tsbClose.Click
        Me.Close()
    End Sub

    Public Sub DockingHandler(sender As Object, e As EventArgs) Handles tsbDockingLeft.Click, tsbDockingBottom.Click, tsbDockingDocument.Click,
                                                                        tsbDockingFloat.Click, tsbDockingLeftAutoHide.Click, tsbDockingRight.Click,
                                                                        tsbDockingRightAutoHide.Click, tsbDockingTop.Click

        If sender Is tsbDockingLeft Then
            Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockLeft
        ElseIf sender Is tsbDockingLeftAutoHide Then
            Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockLeftAutoHide
        ElseIf sender Is tsbDockingRight Then
            Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockRight
        ElseIf sender Is tsbDockingRightAutoHide Then
            Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockRightAutoHide
        ElseIf sender Is tsbDockingTop Then
            Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockTop
        ElseIf sender Is tsbDockingBottom Then
            Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.DockBottom
        ElseIf sender Is tsbDockingDocument Then
            Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.Document
        ElseIf sender Is tsbDockingFloat Then
            Me.DockState = WeifenLuo.WinFormsUI.Docking.DockState.Float
        End If

    End Sub

End Class