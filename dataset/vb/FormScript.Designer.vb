﻿<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> Partial Class FormScript
    Inherits WeifenLuo.WinFormsUI.Docking.DockContent

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(FormScript))
        Me.ToolStrip1 = New System.Windows.Forms.ToolStrip()
        Me.NewToolStripButton = New System.Windows.Forms.ToolStripButton()
        Me.SaveToolStripButton = New System.Windows.Forms.ToolStripButton()
        Me.PrintToolStripButton = New System.Windows.Forms.ToolStripButton()
        Me.toolStripSeparator = New System.Windows.Forms.ToolStripSeparator()
        Me.CutToolStripButton = New System.Windows.Forms.ToolStripButton()
        Me.CopyToolStripButton = New System.Windows.Forms.ToolStripButton()
        Me.PasteToolStripButton = New System.Windows.Forms.ToolStripButton()
        Me.toolStripSeparator1 = New System.Windows.Forms.ToolStripSeparator()
        Me.btnUndo = New System.Windows.Forms.ToolStripButton()
        Me.btnRedo = New System.Windows.Forms.ToolStripButton()
        Me.btnComment = New System.Windows.Forms.ToolStripButton()
        Me.btnUncomment = New System.Windows.Forms.ToolStripButton()
        Me.ToolStripSeparator4 = New System.Windows.Forms.ToolStripSeparator()
        Me.btnIdent = New System.Windows.Forms.ToolStripButton()
        Me.btnIdentRemove = New System.Windows.Forms.ToolStripButton()
        Me.ToolStripSeparator6 = New System.Windows.Forms.ToolStripSeparator()
        Me.tscb1 = New System.Windows.Forms.ToolStripComboBox()
        Me.tscb2 = New System.Windows.Forms.ToolStripComboBox()
        Me.ToolStripSeparator2 = New System.Windows.Forms.ToolStripSeparator()
        Me.ToolStripButton1 = New System.Windows.Forms.ToolStripButton()
        Me.ToolStripButton2 = New System.Windows.Forms.ToolStripButton()
        Me.toolStripSeparator5 = New System.Windows.Forms.ToolStripSeparator()
        Me.HelpToolStripButton = New System.Windows.Forms.ToolStripButton()
        Me.APIHelptsbutton = New System.Windows.Forms.ToolStripButton()
        Me.ToolStripSeparator3 = New System.Windows.Forms.ToolStripSeparator()
        Me.ToolStripLabel1 = New System.Windows.Forms.ToolStripLabel()
        Me.tsTextBoxRename = New System.Windows.Forms.ToolStripTextBox()
        Me.ofd1 = New System.Windows.Forms.OpenFileDialog()
        Me.sfd1 = New System.Windows.Forms.SaveFileDialog()
        Me.TabStripScripts = New FarsiLibrary.Win.FATabStrip()
        Me.FaTabStripItem3 = New FarsiLibrary.Win.FATabStripItem()
        Me.imageList1 = New System.Windows.Forms.ImageList(Me.components)
        Me.FaTabStripItem5 = New FarsiLibrary.Win.FATabStripItem()
        Me.treeViewItems = New System.Windows.Forms.TreeView()
        Me.ofd2 = New System.Windows.Forms.OpenFileDialog()
        Me.pd1 = New System.Windows.Forms.PrintDialog()
        Me.ListBox1 = New System.Windows.Forms.ListBox()
        Me.FaTabStripItem4 = New FarsiLibrary.Win.FATabStripItem()
        Me.dckMenu = New System.Windows.Forms.ContextMenuStrip(Me.components)
        Me.FloatToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.DockLeftToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.DockRightToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.DockTopToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.DockBottomToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.DockLeftAutoHideToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.DockRightAutoHideToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.DockTopAutoHideToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.DockBottomAutoHideToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.DocumentToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem()
        Me.ToolStrip1.SuspendLayout()
        CType(Me.TabStripScripts, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.FaTabStripItem5.SuspendLayout()
        Me.FaTabStripItem4.SuspendLayout()
        Me.dckMenu.SuspendLayout()
        Me.SuspendLayout()
        '
        'ToolStrip1
        '
        Me.ToolStrip1.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.NewToolStripButton, Me.SaveToolStripButton, Me.PrintToolStripButton, Me.toolStripSeparator, Me.CutToolStripButton, Me.CopyToolStripButton, Me.PasteToolStripButton, Me.toolStripSeparator1, Me.btnUndo, Me.btnRedo, Me.btnComment, Me.btnUncomment, Me.ToolStripSeparator4, Me.btnIdent, Me.btnIdentRemove, Me.ToolStripSeparator6, Me.tscb1, Me.tscb2, Me.ToolStripSeparator2, Me.ToolStripButton1, Me.ToolStripButton2, Me.toolStripSeparator5, Me.HelpToolStripButton, Me.APIHelptsbutton, Me.ToolStripSeparator3, Me.ToolStripLabel1, Me.tsTextBoxRename})
        resources.ApplyResources(Me.ToolStrip1, "ToolStrip1")
        Me.ToolStrip1.Name = "ToolStrip1"
        '
        'NewToolStripButton
        '
        Me.NewToolStripButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        resources.ApplyResources(Me.NewToolStripButton, "NewToolStripButton")
        Me.NewToolStripButton.Name = "NewToolStripButton"
        '
        'SaveToolStripButton
        '
        Me.SaveToolStripButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.SaveToolStripButton.Image = Global.DWSIM.My.Resources.Resources.tick
        resources.ApplyResources(Me.SaveToolStripButton, "SaveToolStripButton")
        Me.SaveToolStripButton.Name = "SaveToolStripButton"
        '
        'PrintToolStripButton
        '
        Me.PrintToolStripButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        resources.ApplyResources(Me.PrintToolStripButton, "PrintToolStripButton")
        Me.PrintToolStripButton.Name = "PrintToolStripButton"
        '
        'toolStripSeparator
        '
        Me.toolStripSeparator.Name = "toolStripSeparator"
        resources.ApplyResources(Me.toolStripSeparator, "toolStripSeparator")
        '
        'CutToolStripButton
        '
        Me.CutToolStripButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        resources.ApplyResources(Me.CutToolStripButton, "CutToolStripButton")
        Me.CutToolStripButton.Name = "CutToolStripButton"
        '
        'CopyToolStripButton
        '
        Me.CopyToolStripButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        resources.ApplyResources(Me.CopyToolStripButton, "CopyToolStripButton")
        Me.CopyToolStripButton.Name = "CopyToolStripButton"
        '
        'PasteToolStripButton
        '
        Me.PasteToolStripButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        resources.ApplyResources(Me.PasteToolStripButton, "PasteToolStripButton")
        Me.PasteToolStripButton.Name = "PasteToolStripButton"
        '
        'toolStripSeparator1
        '
        Me.toolStripSeparator1.Name = "toolStripSeparator1"
        resources.ApplyResources(Me.toolStripSeparator1, "toolStripSeparator1")
        '
        'btnUndo
        '
        Me.btnUndo.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.btnUndo.Image = Global.DWSIM.My.Resources.Resources.turn_left
        resources.ApplyResources(Me.btnUndo, "btnUndo")
        Me.btnUndo.Name = "btnUndo"
        '
        'btnRedo
        '
        Me.btnRedo.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.btnRedo.Image = Global.DWSIM.My.Resources.Resources.turn_right
        resources.ApplyResources(Me.btnRedo, "btnRedo")
        Me.btnRedo.Name = "btnRedo"
        '
        'btnComment
        '
        Me.btnComment.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.btnComment.Image = Global.DWSIM.My.Resources.Resources.text_padding_left
        Me.btnComment.Name = "btnComment"
        resources.ApplyResources(Me.btnComment, "btnComment")
        '
        'btnUncomment
        '
        Me.btnUncomment.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.btnUncomment.Image = Global.DWSIM.My.Resources.Resources.text_padding_left1
        Me.btnUncomment.Name = "btnUncomment"
        resources.ApplyResources(Me.btnUncomment, "btnUncomment")
        '
        'ToolStripSeparator4
        '
        Me.ToolStripSeparator4.Name = "ToolStripSeparator4"
        resources.ApplyResources(Me.ToolStripSeparator4, "ToolStripSeparator4")
        '
        'btnIdent
        '
        Me.btnIdent.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.btnIdent.Image = Global.DWSIM.My.Resources.Resources.text_indent
        Me.btnIdent.Name = "btnIdent"
        resources.ApplyResources(Me.btnIdent, "btnIdent")
        '
        'btnIdentRemove
        '
        Me.btnIdentRemove.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.btnIdentRemove.Image = Global.DWSIM.My.Resources.Resources.text_indent_remove
        Me.btnIdentRemove.Name = "btnIdentRemove"
        resources.ApplyResources(Me.btnIdentRemove, "btnIdentRemove")
        '
        'ToolStripSeparator6
        '
        Me.ToolStripSeparator6.Name = "ToolStripSeparator6"
        resources.ApplyResources(Me.ToolStripSeparator6, "ToolStripSeparator6")
        '
        'tscb1
        '
        Me.tscb1.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.tscb1.Name = "tscb1"
        resources.ApplyResources(Me.tscb1, "tscb1")
        Me.tscb1.Sorted = True
        '
        'tscb2
        '
        resources.ApplyResources(Me.tscb2, "tscb2")
        Me.tscb2.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.tscb2.DropDownWidth = 35
        Me.tscb2.Name = "tscb2"
        '
        'ToolStripSeparator2
        '
        Me.ToolStripSeparator2.Name = "ToolStripSeparator2"
        resources.ApplyResources(Me.ToolStripSeparator2, "ToolStripSeparator2")
        '
        'ToolStripButton1
        '
        Me.ToolStripButton1.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripButton1.Image = Global.DWSIM.My.Resources.Resources.control_play
        resources.ApplyResources(Me.ToolStripButton1, "ToolStripButton1")
        Me.ToolStripButton1.Name = "ToolStripButton1"
        '
        'ToolStripButton2
        '
        Me.ToolStripButton2.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripButton2.Image = Global.DWSIM.My.Resources.Resources.control_stop
        resources.ApplyResources(Me.ToolStripButton2, "ToolStripButton2")
        Me.ToolStripButton2.Name = "ToolStripButton2"
        '
        'toolStripSeparator5
        '
        Me.toolStripSeparator5.Name = "toolStripSeparator5"
        resources.ApplyResources(Me.toolStripSeparator5, "toolStripSeparator5")
        '
        'HelpToolStripButton
        '
        Me.HelpToolStripButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        resources.ApplyResources(Me.HelpToolStripButton, "HelpToolStripButton")
        Me.HelpToolStripButton.Name = "HelpToolStripButton"
        '
        'APIHelptsbutton
        '
        Me.APIHelptsbutton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.APIHelptsbutton.Image = Global.DWSIM.My.Resources.Resources.script_code
        resources.ApplyResources(Me.APIHelptsbutton, "APIHelptsbutton")
        Me.APIHelptsbutton.Name = "APIHelptsbutton"
        '
        'ToolStripSeparator3
        '
        Me.ToolStripSeparator3.Name = "ToolStripSeparator3"
        resources.ApplyResources(Me.ToolStripSeparator3, "ToolStripSeparator3")
        '
        'ToolStripLabel1
        '
        Me.ToolStripLabel1.Name = "ToolStripLabel1"
        resources.ApplyResources(Me.ToolStripLabel1, "ToolStripLabel1")
        '
        'tsTextBoxRename
        '
        resources.ApplyResources(Me.tsTextBoxRename, "tsTextBoxRename")
        Me.tsTextBoxRename.Margin = New System.Windows.Forms.Padding(1, 2, 1, 0)
        Me.tsTextBoxRename.Name = "tsTextBoxRename"
        '
        'ofd1
        '
        Me.ofd1.FileName = "OpenFileDialog1"
        resources.ApplyResources(Me.ofd1, "ofd1")
        Me.ofd1.Multiselect = True
        Me.ofd1.SupportMultiDottedExtensions = True
        '
        'sfd1
        '
        resources.ApplyResources(Me.sfd1, "sfd1")
        Me.sfd1.SupportMultiDottedExtensions = True
        '
        'TabStripScripts
        '
        resources.ApplyResources(Me.TabStripScripts, "TabStripScripts")
        Me.TabStripScripts.Name = "TabStripScripts"
        Me.TabStripScripts.SelectedItem = Me.FaTabStripItem3
        '
        'FaTabStripItem3
        '
        Me.FaTabStripItem3.CanClose = False
        Me.FaTabStripItem3.IsDrawn = True
        Me.FaTabStripItem3.Name = "FaTabStripItem3"
        Me.FaTabStripItem3.Selected = True
        resources.ApplyResources(Me.FaTabStripItem3, "FaTabStripItem3")
        '
        'imageList1
        '
        Me.imageList1.ImageStream = CType(resources.GetObject("imageList1.ImageStream"), System.Windows.Forms.ImageListStreamer)
        Me.imageList1.TransparentColor = System.Drawing.Color.Lime
        Me.imageList1.Images.SetKeyName(0, "")
        Me.imageList1.Images.SetKeyName(1, "")
        Me.imageList1.Images.SetKeyName(2, "")
        Me.imageList1.Images.SetKeyName(3, "")
        Me.imageList1.Images.SetKeyName(4, "")
        '
        'FaTabStripItem5
        '
        Me.FaTabStripItem5.Controls.Add(Me.treeViewItems)
        Me.FaTabStripItem5.IsDrawn = True
        Me.FaTabStripItem5.Name = "FaTabStripItem5"
        Me.FaTabStripItem5.Selected = True
        resources.ApplyResources(Me.FaTabStripItem5, "FaTabStripItem5")
        '
        'treeViewItems
        '
        resources.ApplyResources(Me.treeViewItems, "treeViewItems")
        Me.treeViewItems.LineColor = System.Drawing.Color.Empty
        Me.treeViewItems.Name = "treeViewItems"
        Me.treeViewItems.PathSeparator = "."
        '
        'ofd2
        '
        resources.ApplyResources(Me.ofd2, "ofd2")
        Me.ofd2.Multiselect = True
        Me.ofd2.SupportMultiDottedExtensions = True
        '
        'pd1
        '
        Me.pd1.UseEXDialog = True
        '
        'ListBox1
        '
        Me.ListBox1.BorderStyle = System.Windows.Forms.BorderStyle.None
        resources.ApplyResources(Me.ListBox1, "ListBox1")
        Me.ListBox1.FormattingEnabled = True
        Me.ListBox1.Name = "ListBox1"
        Me.ListBox1.SelectionMode = System.Windows.Forms.SelectionMode.MultiExtended
        '
        'FaTabStripItem4
        '
        Me.FaTabStripItem4.CanClose = False
        Me.FaTabStripItem4.Controls.Add(Me.ListBox1)
        Me.FaTabStripItem4.IsDrawn = True
        Me.FaTabStripItem4.Name = "FaTabStripItem4"
        resources.ApplyResources(Me.FaTabStripItem4, "FaTabStripItem4")
        '
        'dckMenu
        '
        Me.dckMenu.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.FloatToolStripMenuItem, Me.DockLeftToolStripMenuItem, Me.DockRightToolStripMenuItem, Me.DockTopToolStripMenuItem, Me.DockBottomToolStripMenuItem, Me.DockLeftAutoHideToolStripMenuItem, Me.DockRightAutoHideToolStripMenuItem, Me.DockTopAutoHideToolStripMenuItem, Me.DockBottomAutoHideToolStripMenuItem, Me.DocumentToolStripMenuItem})
        Me.dckMenu.Name = "dckMenu"
        resources.ApplyResources(Me.dckMenu, "dckMenu")
        '
        'FloatToolStripMenuItem
        '
        Me.FloatToolStripMenuItem.Name = "FloatToolStripMenuItem"
        resources.ApplyResources(Me.FloatToolStripMenuItem, "FloatToolStripMenuItem")
        '
        'DockLeftToolStripMenuItem
        '
        Me.DockLeftToolStripMenuItem.Name = "DockLeftToolStripMenuItem"
        resources.ApplyResources(Me.DockLeftToolStripMenuItem, "DockLeftToolStripMenuItem")
        '
        'DockRightToolStripMenuItem
        '
        Me.DockRightToolStripMenuItem.Name = "DockRightToolStripMenuItem"
        resources.ApplyResources(Me.DockRightToolStripMenuItem, "DockRightToolStripMenuItem")
        '
        'DockTopToolStripMenuItem
        '
        Me.DockTopToolStripMenuItem.Name = "DockTopToolStripMenuItem"
        resources.ApplyResources(Me.DockTopToolStripMenuItem, "DockTopToolStripMenuItem")
        '
        'DockBottomToolStripMenuItem
        '
        Me.DockBottomToolStripMenuItem.Name = "DockBottomToolStripMenuItem"
        resources.ApplyResources(Me.DockBottomToolStripMenuItem, "DockBottomToolStripMenuItem")
        '
        'DockLeftAutoHideToolStripMenuItem
        '
        Me.DockLeftAutoHideToolStripMenuItem.Name = "DockLeftAutoHideToolStripMenuItem"
        resources.ApplyResources(Me.DockLeftAutoHideToolStripMenuItem, "DockLeftAutoHideToolStripMenuItem")
        '
        'DockRightAutoHideToolStripMenuItem
        '
        Me.DockRightAutoHideToolStripMenuItem.Name = "DockRightAutoHideToolStripMenuItem"
        resources.ApplyResources(Me.DockRightAutoHideToolStripMenuItem, "DockRightAutoHideToolStripMenuItem")
        '
        'DockTopAutoHideToolStripMenuItem
        '
        Me.DockTopAutoHideToolStripMenuItem.Name = "DockTopAutoHideToolStripMenuItem"
        resources.ApplyResources(Me.DockTopAutoHideToolStripMenuItem, "DockTopAutoHideToolStripMenuItem")
        '
        'DockBottomAutoHideToolStripMenuItem
        '
        Me.DockBottomAutoHideToolStripMenuItem.Name = "DockBottomAutoHideToolStripMenuItem"
        resources.ApplyResources(Me.DockBottomAutoHideToolStripMenuItem, "DockBottomAutoHideToolStripMenuItem")
        '
        'DocumentToolStripMenuItem
        '
        Me.DocumentToolStripMenuItem.Name = "DocumentToolStripMenuItem"
        resources.ApplyResources(Me.DocumentToolStripMenuItem, "DocumentToolStripMenuItem")
        '
        'FormScript
        '
        resources.ApplyResources(Me, "$this")
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.Controls.Add(Me.TabStripScripts)
        Me.Controls.Add(Me.ToolStrip1)
        Me.DoubleBuffered = True
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.SizableToolWindow
        Me.Name = "FormScript"
        Me.ShowHint = WeifenLuo.WinFormsUI.Docking.DockState.Document
        Me.TabPageContextMenuStrip = Me.dckMenu
        Me.ToolStrip1.ResumeLayout(False)
        Me.ToolStrip1.PerformLayout()
        CType(Me.TabStripScripts, System.ComponentModel.ISupportInitialize).EndInit()
        Me.FaTabStripItem5.ResumeLayout(False)
        Me.FaTabStripItem4.ResumeLayout(False)
        Me.dckMenu.ResumeLayout(False)
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Public WithEvents ToolStrip1 As System.Windows.Forms.ToolStrip
    Public WithEvents SaveToolStripButton As System.Windows.Forms.ToolStripButton
    Public WithEvents PrintToolStripButton As System.Windows.Forms.ToolStripButton
    Public WithEvents toolStripSeparator As System.Windows.Forms.ToolStripSeparator
    Public WithEvents CutToolStripButton As System.Windows.Forms.ToolStripButton
    Public WithEvents CopyToolStripButton As System.Windows.Forms.ToolStripButton
    Public WithEvents PasteToolStripButton As System.Windows.Forms.ToolStripButton
    Public WithEvents toolStripSeparator1 As System.Windows.Forms.ToolStripSeparator
    Public WithEvents ToolStripSeparator2 As System.Windows.Forms.ToolStripSeparator
    Public WithEvents ToolStripButton1 As System.Windows.Forms.ToolStripButton
    Public WithEvents ofd1 As System.Windows.Forms.OpenFileDialog
    Public WithEvents sfd1 As System.Windows.Forms.SaveFileDialog
    Public WithEvents TabStripScripts As FarsiLibrary.Win.FATabStrip
    Public WithEvents ofd2 As System.Windows.Forms.OpenFileDialog
    Public WithEvents pd1 As System.Windows.Forms.PrintDialog
    Public WithEvents tscb1 As System.Windows.Forms.ToolStripComboBox
    Public WithEvents tscb2 As System.Windows.Forms.ToolStripComboBox
    Public WithEvents imageList1 As System.Windows.Forms.ImageList
    Public WithEvents FaTabStripItem5 As FarsiLibrary.Win.FATabStripItem
    Public WithEvents treeViewItems As System.Windows.Forms.TreeView
    Public WithEvents FaTabStripItem3 As FarsiLibrary.Win.FATabStripItem
    Public WithEvents ListBox1 As System.Windows.Forms.ListBox
    Public WithEvents FaTabStripItem4 As FarsiLibrary.Win.FATabStripItem
    Friend WithEvents NewToolStripButton As System.Windows.Forms.ToolStripButton
    Friend WithEvents toolStripSeparator5 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents HelpToolStripButton As System.Windows.Forms.ToolStripButton
    Friend WithEvents ToolStripSeparator3 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents ToolStripLabel1 As System.Windows.Forms.ToolStripLabel
    Friend WithEvents tsTextBoxRename As System.Windows.Forms.ToolStripTextBox
    Friend WithEvents dckMenu As System.Windows.Forms.ContextMenuStrip
    Friend WithEvents FloatToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents DockLeftToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents DockRightToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents DockTopToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents DockBottomToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents DockLeftAutoHideToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents DockRightAutoHideToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents DockTopAutoHideToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents DockBottomAutoHideToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents DocumentToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents APIHelptsbutton As System.Windows.Forms.ToolStripButton
    Friend WithEvents btnUndo As System.Windows.Forms.ToolStripButton
    Friend WithEvents btnRedo As System.Windows.Forms.ToolStripButton
    Friend WithEvents ToolStripSeparator6 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents btnComment As System.Windows.Forms.ToolStripButton
    Friend WithEvents btnUncomment As System.Windows.Forms.ToolStripButton
    Friend WithEvents btnIdent As System.Windows.Forms.ToolStripButton
    Friend WithEvents btnIdentRemove As System.Windows.Forms.ToolStripButton
    Friend WithEvents ToolStripSeparator4 As System.Windows.Forms.ToolStripSeparator
    Public WithEvents ToolStripButton2 As System.Windows.Forms.ToolStripButton
End Class
