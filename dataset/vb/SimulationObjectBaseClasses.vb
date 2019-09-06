'    Flowsheet Object Base Classes 
'    Copyright 2008-2014 Daniel Wagner O. de Medeiros
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

Imports System.Runtime.Serialization.Formatters.Binary
Imports System.Runtime.Serialization
Imports System.IO
Imports System.Linq
Imports CapeOpen
Imports System.Runtime.Serialization.Formatters
Imports System.Runtime.InteropServices.Marshal
Imports System.Runtime.InteropServices
Imports System.Text
Imports DWSIM.Interfaces.Enums.GraphicObjects
Imports DWSIM.Interfaces.Enums
Imports System.Windows.Forms

Namespace UnitOperations

    <System.Serializable()> <ComVisible(True)> Public MustInherit Class BaseClass

        Implements ICloneable, IDisposable, Interfaces.ICustomXMLSerialization

        Implements Interfaces.ISimulationObject

        Public Const ClassId As String = ""

        <System.NonSerialized()> Protected Friend m_flowsheet As Interfaces.IFlowsheet

#Region "    Constructors"

        Public Sub New()

        End Sub

        Sub CreateNew()

        End Sub

#End Region

        Public Overridable Property ComponentDescription() As String = ""

        Public Overridable Property ComponentName() As String = ""

#Region "    ISimulationObject"

        Public Overridable Function GetVersion() As Version Implements ISimulationObject.GetVersion
            Return Me.GetType.Assembly.GetName.Version
        End Function

        Public MustOverride Function GetDisplayName() As String Implements ISimulationObject.GetDisplayName

        Public MustOverride Function GetDisplayDescription() As String Implements ISimulationObject.GetDisplayDescription

        Public MustOverride Function GetIconBitmap() As Object Implements ISimulationObject.GetIconBitmap

        <NonSerialized> Private _AttachedUtilities As New List(Of IAttachedUtility)

        Public Property AttachedUtilities As List(Of IAttachedUtility) Implements ISimulationObject.AttachedUtilities
            Get
                If _AttachedUtilities Is Nothing Then _AttachedUtilities = New List(Of IAttachedUtility)
                Return _AttachedUtilities
            End Get
            Set(value As List(Of IAttachedUtility))
                _AttachedUtilities = value
            End Set
        End Property

        Public Property PreferredFlashAlgorithmTag As String = "" Implements ISimulationObject.PreferredFlashAlgorithmTag
        Public Property Calculated As Boolean = False Implements Interfaces.ISimulationObject.Calculated

        Public Property DebugMode As Boolean = False Implements Interfaces.ISimulationObject.DebugMode

        Public Property DebugText As String = "" Implements Interfaces.ISimulationObject.DebugText

        <Xml.Serialization.XmlIgnore> Public Property LastUpdated As New Date Implements Interfaces.ISimulationObject.LastUpdated

        ''' <summary>
        ''' Calculates the object.
        ''' </summary>
        ''' <param name="args"></param>
        ''' <remarks>Use 'Solve()' to calculate the object instead.</remarks>
        Public Overridable Sub Calculate(Optional ByVal args As Object = Nothing) Implements ISimulationObject.Calculate
            Throw New NotImplementedException
        End Sub

        Public Sub DeCalculate(Optional args As Object = Nothing) Implements ISimulationObject.DeCalculate
            Throw New NotImplementedException
        End Sub

        Public MustOverride Sub DisplayEditForm() Implements ISimulationObject.DisplayEditForm

        Public MustOverride Sub UpdateEditForm() Implements ISimulationObject.UpdateEditForm


        ''' <summary>
        ''' Energy Flow property. Only implemented for Energy Streams.
        ''' </summary>
        ''' <value></value>
        ''' <returns></returns>
        ''' <remarks></remarks>
        <Xml.Serialization.XmlIgnore()> Overridable Property EnergyFlow() As Nullable(Of Double)
            Get
                Throw New NotImplementedException()
            End Get
            Set(ByVal value As Nullable(Of Double))
                Throw New NotImplementedException()
            End Set
        End Property

        ''' <summary>
        ''' Phase collection, only implemented for Material Streams.
        ''' </summary>
        ''' <value></value>
        ''' <returns></returns>
        ''' <remarks></remarks>
        <Xml.Serialization.XmlIgnore()> Public Overridable ReadOnly Property Phases() As Dictionary(Of Integer, Interfaces.IPhase)
            Get
                Throw New NotImplementedException
            End Get
        End Property

        ''' <summary>
        ''' Validates the object, checking its connections and other parameters.
        ''' </summary>
        ''' <remarks></remarks>
        Public Overridable Sub Validate() Implements Interfaces.ISimulationObject.Validate

            Dim vForm As Interfaces.IFlowsheet = FlowSheet
            Dim vCon As Interfaces.IConnectionPoint

            'Validate input connections.
            For Each vCon In Me.GraphicObject.InputConnectors
                If Not vCon.IsAttached Then
                    Throw New Exception(Me.FlowSheet.GetTranslatedString("Verifiqueasconexesdo"))
                End If
            Next

            'Validate output connections.
            For Each vCon In Me.GraphicObject.OutputConnectors
                If Not vCon.IsAttached Then
                    Throw New Exception(Me.FlowSheet.GetTranslatedString("Verifiqueasconexesdo"))
                End If
            Next

        End Sub

        Public Overridable Function GetDebugReport() As String Implements Interfaces.ISimulationObject.GetDebugReport
            Return "Error - function not implemented"
        End Function

        Public Sub AppendDebugLine(text As String) Implements Interfaces.ISimulationObject.AppendDebugLine
            DebugText += text & vbCrLf & vbCrLf
        End Sub

        ''' <summary>
        ''' Gets or sets the error message regarding the last calculation attempt.
        ''' </summary>
        ''' <value></value>
        ''' <returns></returns>
        ''' <remarks></remarks>
        Public Property ErrorMessage() As String Implements Interfaces.ISimulationObject.ErrorMessage

        ''' <summary>
        ''' Checks if a value is valid.
        ''' </summary>
        ''' <param name="val">Value to be checked.</param>
        ''' <param name="onlypositive">Value should be a positive double or not.</param>
        ''' <param name="paramname">Name of the parameter (ex. P, T, W, H etc.)</param>
        ''' <remarks></remarks>
        Public Sub CheckSpec(val As Double, onlypositive As Boolean, paramname As String) Implements Interfaces.ISimulationObject.CheckSpec

            If Not val.IsValid Then Throw New ArgumentException(Me.FlowSheet.GetTranslatedString("ErrorInvalidUOSpecValue") & " (name: " & paramname & ", value: " & val & ")")
            If onlypositive Then If val.IsNegative Then Throw New ArgumentException(Me.FlowSheet.GetTranslatedString("ErrorInvalidUOSpecValue") & " (name: " & paramname & ", value: " & val & ")")

        End Sub

        Public Property Annotation() As String = "" Implements Interfaces.ISimulationObject.Annotation

        ''' <summary>
        ''' Checks if an Adjust operation is attached to this object.
        ''' </summary>
        ''' <value></value>
        ''' <returns></returns>
        ''' <remarks></remarks>
        Public Property IsAdjustAttached() As Boolean = False Implements Interfaces.ISimulationObject.IsAdjustAttached

        ''' <summary>
        ''' If an Adjust object is attached to this object, returns its ID.
        ''' </summary>
        ''' <value></value>
        ''' <returns></returns>
        ''' <remarks></remarks>
        Public Property AttachedAdjustId() As String = "" Implements Interfaces.ISimulationObject.AttachedAdjustId

        ''' <summary>
        ''' If an Adjust object is attached to this object, returns a variable describing how this object is used by it (manipulated, controlled or reference).
        ''' </summary>
        ''' <value></value>
        ''' <returns></returns>
        ''' <remarks></remarks>
        Public Property AdjustVarType() As Interfaces.Enums.AdjustVarType Implements Interfaces.ISimulationObject.AdjustVarType

        ''' <summary>
        ''' Checks if an Specification operation is attached to this object.
        ''' </summary>
        ''' <value></value>
        ''' <returns></returns>
        ''' <remarks></remarks>
        Public Property IsSpecAttached() As Boolean = False Implements Interfaces.ISimulationObject.IsSpecAttached

        ''' <summary>
        ''' If an Specification object is attached to this object, returns its ID.
        ''' </summary>
        ''' <value></value>
        ''' <returns></returns>
        ''' <remarks></remarks>
        Public Property AttachedSpecId() As String = "" Implements Interfaces.ISimulationObject.AttachedSpecId

        ''' <summary>
        ''' If an Specification object is attached to this object, returns a variable describing how this object is used by it (target or source).
        ''' </summary>
        ''' <value></value>
        ''' <returns></returns>
        ''' <remarks></remarks>
        Public Property SpecVarType() As Interfaces.Enums.SpecVarType Implements Interfaces.ISimulationObject.SpecVarType

        ''' <summary>
        ''' Gets or sets the graphic object representation of this object in the flowsheet.
        ''' </summary>
        ''' <value></value>
        ''' <returns></returns>
        ''' <remarks></remarks>
        <Xml.Serialization.XmlIgnore> Public Property GraphicObject() As Interfaces.IGraphicObject Implements Interfaces.ISimulationObject.GraphicObject

        ''' <summary>
        ''' Object's Unique ID (Name)
        ''' </summary>
        ''' <value></value>
        ''' <returns></returns>
        ''' <remarks>This property is the same as the graphic object 'Name' property.</remarks>
        Public Property Name() As String Implements Interfaces.ISimulationObject.Name
            Get
                Return ComponentName
            End Get
            Set(value As String)
                ComponentName = value
            End Set
        End Property

        Public Overridable Function GetProperties(proptype As PropertyType) As String() Implements Interfaces.ISimulationObject.GetProperties

            Dim proplist As New List(Of String)

            For Each item In AttachedUtilities
                proplist.AddRange(item.GetPropertyList().ConvertAll(New Converter(Of String, String)(Function(s As String)
                                                                                                         Return item.Name & ": " & s
                                                                                                     End Function)))
            Next

            Return proplist.ToArray

        End Function

        Public Overridable Function GetPropertyUnit(prop As String, Optional su As Interfaces.IUnitsOfMeasure = Nothing) As String Implements Interfaces.ISimulationObject.GetPropertyUnit

            For Each item In AttachedUtilities
                If prop.StartsWith(item.Name) Then
                    For Each prop1 In item.GetPropertyList()
                        If prop.Contains(prop1) Then Return item.GetPropertyUnits(prop.Split(": ")(1).Trim)
                    Next
                End If
            Next

            Return "NF"

        End Function

        Public Overridable Function GetPropertyValue(prop As String, Optional su As Interfaces.IUnitsOfMeasure = Nothing) As Object Implements Interfaces.ISimulationObject.GetPropertyValue

            For Each item In AttachedUtilities
                If prop.StartsWith(item.Name) Then
                    For Each prop1 In item.GetPropertyList()
                        If prop.Contains(prop1) Then Return item.GetPropertyValue(prop.Split(": ")(1).Trim)
                    Next
                End If

            Next

            Return Nothing

        End Function

        Public Overridable Function SetPropertyValue(prop As String, propval As Object, Optional su As Interfaces.IUnitsOfMeasure = Nothing) As Boolean Implements Interfaces.ISimulationObject.SetPropertyValue

            For Each item In AttachedUtilities
                If prop.StartsWith(item.Name) Then
                    For Each prop1 In item.GetPropertyList()
                        If prop.Contains(prop1) Then
                            item.SetPropertyValue(prop.Split(": ")(1).Trim, propval)
                            Return True
                        End If
                    Next
                End If
            Next

            Return False

        End Function

        Public Overridable Function GetDefaultProperties() As String() Implements ISimulationObject.GetDefaultProperties
            Return GetProperties(PropertyType.ALL)
        End Function

        Public Overridable Property PropertyPackage As IPropertyPackage Implements ISimulationObject.PropertyPackage

        Public Function GetFlowsheet() As IFlowsheet Implements ISimulationObject.GetFlowsheet
            Return FlowSheet
        End Function

        Public MustOverride Sub CloseEditForm() Implements ISimulationObject.CloseEditForm

        Public MustOverride Function CloneXML() As Object Implements ISimulationObject.CloneXML

        Public MustOverride Function CloneJSON() As Object Implements ISimulationObject.CloneJSON

        Public MustOverride ReadOnly Property MobileCompatible As Boolean Implements ISimulationObject.MobileCompatible

#End Region

#Region "    ICloneable"

        ''' <summary>
        ''' Clones the current object, returning a new one with identical properties.
        ''' </summary>
        ''' <returns>An object of the same type with the same properties.</returns>
        ''' <remarks>Properties and fields marked with the 'NonSerializable' attribute aren't cloned.</remarks>
        Public Overridable Function Clone() As Object Implements System.ICloneable.Clone

            Return ObjectCopy(Me)

        End Function

        Function ObjectCopy(ByVal obj As UnitOperations.BaseClass) As Object

            If GlobalSettings.Settings.AutomationMode Then
                Return Me.CloneXML
            Else
                Using objMemStream As New MemoryStream()
                    Dim objBinaryFormatter As New BinaryFormatter(Nothing, New StreamingContext(StreamingContextStates.Clone))
                    objBinaryFormatter.Serialize(objMemStream, Me)
                    objMemStream.Seek(0, SeekOrigin.Begin)
                    objBinaryFormatter.AssemblyFormat = Formatters.FormatterAssemblyStyle.Simple
                    Return objBinaryFormatter.Deserialize(objMemStream)
                End Using
            End If

        End Function

#End Region

#Region "    IDisposable Support "

        Public disposedValue As Boolean = False        ' To detect redundant calls

        Protected Overridable Sub Dispose(ByVal disposing As Boolean)
            Me.disposedValue = True
        End Sub

        ' This code added by Visual Basic to correctly implement the disposable pattern.
        Public Sub Dispose() Implements IDisposable.Dispose

            ' Do not change this code.  Put cleanup code in Dispose(ByVal disposing As Boolean) above.
            Dispose(True)
            GC.SuppressFinalize(Me)

        End Sub
#End Region

#Region "    IXMLSerialization"

        ''' <summary>
        ''' Loads object data stored in a collection of XML elements.
        ''' </summary>
        ''' <param name="data"></param>
        ''' <returns></returns>
        ''' <remarks></remarks>
        Public Overridable Function LoadData(data As System.Collections.Generic.List(Of System.Xml.Linq.XElement)) As Boolean Implements Interfaces.ICustomXMLSerialization.LoadData

            XMLSerializer.XMLSerializer.Deserialize(Me, data)

            Dim xel_u = (From xel2 As XElement In data Select xel2 Where xel2.Name = "AttachedUtilities")

            If Not xel_u Is Nothing Then
                Dim dataUtilities As List(Of XElement) = xel_u.Elements.ToList
                For Each xel As XElement In dataUtilities
                    Try
                        Dim u = FlowSheet.GetUtility(xel.Element("UtilityType").Value)
                        u.ID = xel.Element("ID").Value
                        u.Name = xel.Element("Name").Value
                        u.AttachedTo = Me
                        u.Initialize()
                        u.LoadData(Newtonsoft.Json.JsonConvert.DeserializeObject(Of Dictionary(Of String, Object))(xel.Element("Data").Value))
                        Me.AttachedUtilities.Add(u)
                    Catch ex As Exception
                        FlowSheet.ShowMessage("Error restoring attached utility to " & Me.Name & ": " & ex.Message.ToString, IFlowsheet.MessageType.GeneralError)
                    End Try
                Next
            End If

            If Me.Annotation = "DWSIM.DWSIM.Outros.Annotation" Then Me.Annotation = ""

            Return True

        End Function

        ''' <summary>
        ''' Saves object data in a collection of XML elements.
        ''' </summary>
        ''' <returns>A List of XML elements containing object data.</returns>
        ''' <remarks></remarks>
        Public Overridable Function SaveData() As System.Collections.Generic.List(Of System.Xml.Linq.XElement) Implements Interfaces.ICustomXMLSerialization.SaveData

            Dim elements As System.Collections.Generic.List(Of System.Xml.Linq.XElement) = XMLSerializer.XMLSerializer.Serialize(Me)

            With elements
                .Add(New XElement("AttachedUtilities"))
                For Each util In AttachedUtilities
                    .Item(.Count - 1).Add(New XElement("AttachedUtility", {New XElement("ID", util.ID),
                                                                           New XElement("Name", util.Name),
                                                                           New XElement("UtilityType", Convert.ToInt32(util.GetUtilityType)),
                                                                           New XElement("Data", Newtonsoft.Json.JsonConvert.SerializeObject(util.SaveData))}))
                Next
            End With

            Return elements

        End Function

#End Region

#Region "    Extras"

        ''' <summary>
        ''' Copies the object properties to the Clipboard.
        ''' </summary>
        ''' <param name="su">Units system to use.</param>
        ''' <param name="nf">Number format to use.</param>
        ''' <remarks></remarks>
        Public Sub CopyDataToClipboard(su As SystemsOfUnits.Units, nf As String)

            Dim DT As New DataTable
            DT.Columns.Clear()
            DT.Columns.Add(("Propriedade"), GetType(System.String))
            DT.Columns.Add(("Valor"), GetType(System.String))
            DT.Columns.Add(("Unidade"), GetType(System.String))
            DT.Rows.Clear()

            Dim baseobj As BaseClass
            Dim properties() As String
            Dim description As String
            Dim objtype As ObjectType
            Dim propidx, r1, r2, r3, r4, r5, r6 As Integer
            r1 = 5
            r2 = 12
            r3 = 30
            r4 = 48
            r5 = 66
            r6 = 84

            baseobj = Me
            properties = baseobj.GetProperties(Interfaces.Enums.PropertyType.ALL)
            objtype = baseobj.GraphicObject.ObjectType
            description = Me.FlowSheet.GetTranslatedString(baseobj.GraphicObject.Description)
            If objtype = ObjectType.MaterialStream Then
                Dim value As String
                For propidx = 0 To r1 - 1
                    value = baseobj.GetPropertyValue(properties(propidx), su)
                    If Double.TryParse(value, New Double) Then
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), Format(Double.Parse(value), nf), baseobj.GetPropertyUnit(properties(propidx), su)})
                    Else
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), value, baseobj.GetPropertyUnit(properties(propidx), su)})
                    End If
                Next
                For propidx = r1 To r2 - 1
                    value = baseobj.GetPropertyValue(properties(propidx), su)
                    If Double.TryParse(value, New Double) Then
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), Format(Double.Parse(value), nf), baseobj.GetPropertyUnit(properties(propidx), su)})
                    Else
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), value, baseobj.GetPropertyUnit(properties(propidx), su)})
                    End If
                Next
                DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString("FraomolarnaMistura"), "", ""})
                For Each subst As Interfaces.ICompound In CType(Me, Interfaces.IMaterialStream).Phases(0).Compounds.Values
                    DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(subst.Name), Format(subst.MoleFraction.GetValueOrDefault, nf), ""})
                Next
                For propidx = r2 To r3 - 1
                    value = baseobj.GetPropertyValue(properties(propidx), su)
                    If Double.TryParse(value, New Double) Then
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), Format(Double.Parse(value), nf), baseobj.GetPropertyUnit(properties(propidx), su)})
                    Else
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), value, baseobj.GetPropertyUnit(properties(propidx), su)})
                    End If
                Next
                DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString("FraomolarnaPhaseVapor"), "", ""})
                For Each subst As Interfaces.ICompound In CType(Me, Interfaces.IMaterialStream).Phases(2).Compounds.Values
                    DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(subst.Name), Format(subst.MoleFraction.GetValueOrDefault, nf), ""})
                Next
                For propidx = r3 To r4 - 1
                    value = baseobj.GetPropertyValue(properties(propidx), su)
                    If Double.TryParse(value, New Double) Then
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), Format(Double.Parse(value), nf), baseobj.GetPropertyUnit(properties(propidx), su)})
                    Else
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), value, baseobj.GetPropertyUnit(properties(propidx), su)})
                    End If
                Next
                DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString("FraomolarnaPhaseLquid"), "", ""})
                For Each subst As Interfaces.ICompound In CType(Me, Interfaces.IMaterialStream).Phases(1).Compounds.Values
                    DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(subst.Name), Format(subst.MoleFraction.GetValueOrDefault, nf), ""})
                Next
                For propidx = r4 To r5 - 1
                    value = baseobj.GetPropertyValue(properties(propidx), su)
                    If Double.TryParse(value, New Double) Then
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), Format(Double.Parse(value), nf), baseobj.GetPropertyUnit(properties(propidx), su)})
                    Else
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), value, baseobj.GetPropertyUnit(properties(propidx), su)})
                    End If
                Next
                DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString("FraomolarnaPhaseLquid"), "", ""})
                For Each subst As Interfaces.ICompound In CType(Me, Interfaces.IMaterialStream).Phases(3).Compounds.Values
                    DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(subst.Name), Format(subst.MoleFraction.GetValueOrDefault, nf), ""})
                Next
                For propidx = r5 To r6 - 1
                    value = baseobj.GetPropertyValue(properties(propidx), su)
                    If Double.TryParse(value, New Double) Then
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), Format(Double.Parse(value), nf), baseobj.GetPropertyUnit(properties(propidx), su)})
                    Else
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), value, baseobj.GetPropertyUnit(properties(propidx), su)})
                    End If
                Next
                DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString("FraomolarnaPhaseLquid"), "", ""})
                For Each subst As Interfaces.ICompound In CType(Me, Interfaces.IMaterialStream).Phases(4).Compounds.Values
                    DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(subst.Name), Format(subst.MoleFraction.GetValueOrDefault, nf), ""})
                Next
                For propidx = r6 To 101
                    value = baseobj.GetPropertyValue(properties(propidx), su)
                    If Double.TryParse(value, New Double) Then
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), Format(Double.Parse(value), nf), baseobj.GetPropertyUnit(properties(propidx), su)})
                    Else
                        DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(properties(propidx)), value, baseobj.GetPropertyUnit(properties(propidx), su)})
                    End If
                Next
                DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString("FraomolarnaPhaseLquid"), "", ""})
                For Each subst As Interfaces.ICompound In CType(Me, Interfaces.IMaterialStream).Phases(6).Compounds.Values
                    DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(subst.Name), Format(subst.MoleFraction.GetValueOrDefault, nf), ""})
                Next
            Else
                For Each prop As String In properties
                    DT.Rows.Add(New String() {Me.FlowSheet.GetTranslatedString(prop), Format(baseobj.GetPropertyValue(prop, su), nf), baseobj.GetPropertyUnit(prop, su)})
                Next
            End If

            Dim st As New StringBuilder(Me.FlowSheet.GetTranslatedString(Me.ComponentDescription) & ": " & Me.GraphicObject.Tag & vbCrLf)
            For Each r As DataRow In DT.Rows
                Dim l As String = ""
                For Each o As Object In r.ItemArray
                    l += o.ToString() & vbTab
                Next
                st.AppendLine(l)
            Next

            Clipboard.SetText(st.ToString())

            DT.Clear()
            DT.Dispose()
            DT = Nothing

        End Sub

        ''' <summary>
        ''' Formats a property string, adding its units in parenthesis.
        ''' </summary>
        ''' <param name="prop">Property string</param>
        ''' <param name="unit">Property units</param>
        ''' <returns></returns>
        ''' <remarks></remarks>
        Public Function FT(ByRef prop As String, ByVal unit As String)
            Return prop & " (" & unit & ")"
        End Function

        ''' <summary>
        ''' Sets the Flowsheet to which this object belongs to.
        ''' </summary>
        ''' <param name="flowsheet">Flowsheet instance.</param>
        ''' <remarks></remarks>
        Public Sub SetFlowsheet(ByVal flowsheet As Object) Implements Interfaces.ISimulationObject.SetFlowsheet
            m_flowsheet = flowsheet
        End Sub

        ''' <summary>
        ''' Gets the current flowsheet where this object is.
        ''' </summary>
        ''' <value></value>
        ''' <returns>Flowsheet instance.</returns>
        ''' <remarks></remarks>
        Public Overridable ReadOnly Property FlowSheet() As Interfaces.IFlowsheet
            Get
                If Not m_flowsheet Is Nothing Then
                    Return m_flowsheet
                Else
                    Return Nothing
                End If
            End Get
        End Property

#End Region

    End Class

End Namespace
