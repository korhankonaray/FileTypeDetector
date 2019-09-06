<%@ Page Trace="False" Language="vb" aspcompat="false" debug="true" validateRequest="false"%> 
<%@ Import Namespace=System.Drawing %>
<%@ Import Namespace=System.Drawing.Imaging %>
<%@ Import Namespace=System %>
<%@ Import Namespace=System.Web %>
<SCRIPT LANGUAGE="VBScript" runat="server">
const Lx = 200	' max width for thumbnails
const Ly = 240	' max height for thumbnails
const upload_dir = "/upload_resize_test/"	' directory to upload file
const upload_original = "sample"	' filename to save original as (suffix added by script)
const upload_thumb = "thumb"	' filename to save thumbnail as (suffix added by script)
const upload_max_size = 25	' max size of the upload (KB) note: this doesn't override any server upload limits
dim fileExt	' used to store the file extension (saves finding it mulitple times)
dim newWidth, newHeight as integer ' new width/height for the thumbnail
dim l2	' temp variable used when calculating new size
dim fileFld as HTTPPostedFile	' used to grab the file upload from the form
Dim originalimg As System.Drawing.Image	' used to hold the original image
dim msg	' display results
dim upload_ok as boolean	' did the upload work ?
</script>
<%
randomize() ' used to help the cache-busting on the preview images
upload_ok = false
if lcase(Request.ServerVariables("REQUEST_METHOD"))="post" then

	fileFld = request.files(0)	' get the first file uploaded from the form (note:- you can use this to itterate through more than one image)
	if fileFld.ContentLength > upload_max_size * 1024 then
		msg = "Sorry, the image must be less than " & upload_max_size & "Kb"
	else
		try
			originalImg = System.Drawing.Image.FromStream(fileFld.InputStream)
			' work out the width/height for the thumbnail. Preserve aspect ratio and honour max width/height
			' Note: if the original is smaller than the thumbnail size it will be scaled up
			If (originalImg.Width/Lx) > (originalImg.Width/Ly) Then
				L2 = originalImg.Width
				newWidth = Lx
				newHeight = originalImg.Height * (Lx / L2)
				if newHeight > Ly then
					newWidth = newWidth * (Ly / newHeight)
					newHeight = Ly
				end if
			Else
				L2 = originalImg.Height
				newHeight = Ly
				newWidth = originalImg.Width * (Ly / L2)
				if newWidth > Lx then
					newHeight = newHeight * (Lx / newWidth)
					newWidth = Lx
				end if
			End If

            Dim thumb As New Bitmap(newWidth, newHeight)

            'Create a graphics object           
            Dim gr_dest As Graphics = Graphics.FromImage(thumb)

			' just in case it's a transparent GIF force the bg to white 
			dim sb = new SolidBrush(System.Drawing.Color.White)
			gr_dest.FillRectangle(sb, 0, 0, thumb.Width, thumb.Height)

            'Re-draw the image to the specified height and width
			gr_dest.DrawImage(originalImg, 0, 0, thumb.Width, thumb.Height)

			try
				fileExt = System.IO.Path.GetExtension(fileFld.FileName).ToLower()
				originalImg.save(Server.MapPath(upload_dir) & upload_original & fileExt, originalImg.rawformat)
				thumb.save(Server.MapPath(upload_dir & upload_thumb & fileExt), originalImg.rawformat)
				msg = "Uploaded " & fileFld.FileName & " to " & Server.MapPath(upload_dir & upload_original & fileExt)
				upload_ok = true
			catch
				msg = "Sorry, there was a problem saving the image." & Err.description
				' Note: the usual cause for this is permissions on the IIS server
			end try
			' Housekeeping for the generated thumbnail
			if not thumb is nothing then
				thumb.Dispose()
				thumb = nothing
			end if
		catch
			msg = "Sorry, that was not an image we could process."
		end try
	end if

	' House Keeping !
	if not originalImg is nothing then
		originalImg.Dispose()
		originalImg = nothing
	end if

else
	if request.querystring("showimg")="gif" or request.querystring("showimg")="jpg" or request.querystring("showimg")="png" then	' fake so it shows the images
		upload_ok = true
		fileExt = "." & request.querystring("showimg")
	end if

end if
%>
<html>
<head>
<title>ASP.NET File Upload and Resize Sample</title>
<META NAME="Description" CONTENT="ASP.NET File Upload and Resize Sample (Hybrid VB.NET) - and it's free!">
<META NAME="Keywords" CONTENT="ASP.NET, ASP, NET, VB, VBScript, Image, Upload, Resize, Thumbnail, Constrain, Filesize, File, Size, Free">
<META NAME="Copyright" CONTENT="Rufan-Redi Pty Ltd 2005">
<META NAME="Author" CONTENT="System developed by Jeremy at http://www.Rufan-Redi.com / http://offbeatmammal.com">
<style type="text/css">
body {
	padding-bottom: 5px;
	border-bottom: 1px dotted #999;
}
p, td {
	font-family: Lucida Grande, Geneva, Verdana, Arial, sans-serif;
	font-size: 12px;
	color: #000000;
}
.content {
	left:5%;
	width: 70%
}
.copyright, .copyright a {
	color: #999;
	font-size: 9px;
}
</style>
</head>
<body>

<div class="content">

<p><b>Hybrid ASP.NET File Upload and Resize Sample (VB.NET)</b>
<br>Upload and resize a GIP/JPG/PNG images, ensuring filesizes are optimum by an <a href="http://blog.offbeatmammal.com">Offbeatmammal</a>.</p>

<form enctype="multipart/form-data" method="post" runat="server">
<table>
<tr><td>Select the file to upload:</td><td><input type="file" name="upload_file"></td></tr>
<tr><td colspan=2>Max upload size <%=upload_max_size%>Kb, gif/jpg/png only</td></tr>
<tr><td colspan=2><input type="submit" value="Upload"></td></tr>
</table>
</form>

<%
if upload_ok then
%>
<table>
<tr>
<td valign=top><img src="<%=upload_dir & upload_original & fileExt & "?" & rnd()%>"></td>
<td valign=top><img src="<%=upload_dir & upload_thumb & fileExt & "?" & rnd()%>"></td>
</tr>
</table>
<%
else
	response.write(msg)
end if
%>

</div>

<p class="copyright">&copy 2005 <a href="http://rufan-redi.com">Rufan-Redi</a>, The work of an <a href="http://offbeatmammal.com/">OffBeatMammal</a>.</p>

</body>
</html>