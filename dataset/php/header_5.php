<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Archon Admin Template</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Loading Bootstrap -->
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">

	<!-- Loading Stylesheets -->    
	<link href="css/archon.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<!-- Loading Custom Stylesheets -->    
	<link href="css/custom.css" rel="stylesheet">

	<!-- Loading Custom Stylesheets -->    
	<link href="css/custom.css" rel="stylesheet">

	<link rel="shortcut icon" href="images/favicon.ico">

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<![endif]-->
</head>
<body>
	<div class="frame">
		<div class="sidebar">
			<div class="wrapper">

				<!-- Replace the src of the image with your logo -->
				<a href="index.html" class="logo"><img src="images/logo.png" alt="Archon Admin" /></a>
				<ul class="nav  nav-list">

					<!-- sidebar input search box -->
					<li class="nav-search">
						<div class="form-group">
							<input type="text" class="form-control nav-search" placeholder="Search through site" />
							<span class="input-icon fui-search"></span>
						</div>
					</li>

						<!-- Sidebar header @add class nav-header for sidebar header -->
						<li class="nav-header">Overview</li>
						<li><a href="index.html"><i class="fa fa-dashboard"></i>Dashboard </a></li>
						<li><a href="index.html"><i class="fa fa-dashboard"></i>Dashboard </a></li>
					<li>
						<a class="dropdown" href="#"><i class="fa fa-tint"></i> UI Features <span class="label">3</span></a>
						<ul>
							<li><a href="buttons.html"><i class="fa fa-bullhorn"></i> Buttons &amp; Notifications</a></li>
							<li><a href="slidersnprogress.html"><i class="fa fa-minus"></i>Sliders &amp; Progress </a></li>
							<li><a href="nestable.html"><i class="fa fa-list"></i>Nestable </a></li>
						</ul>	
					</li>
						<li><a href="widgets.html"><i class="fa fa-group"></i>Widgets</a></li>

						<!-- Sidebar header @add class nav-header for sidebar header -->
						<li class="nav-header">Pages</li>
						<li><a href="calendar.html"><i class="fa fa-calendar"></i>Calendar</a></li>
						<li><a href="gallery.html"><i class="fa fa-picture-o"></i>Gallery</a></li>
					<li><a href="mail.html"><i class="fa fa-envelope"></i>Mail</a></li>
					<li><a href="login.html"><i class="fa fa-sign-in"></i>Login</a></li>
						<li><a href="login.html"><i class="fa fa-sign-in"></i>Login</a></li>
						<li> <!-- Example for second level menu -->
						<a class="dropdown" href="#"><i class="fa fa-user"></i> Profile <span class="label">2</span></a>
						<ul>
							<li><a href="profile.html"><i class="fa fa-user"></i> Model One</a></li>
							<li><a href="profileTwo.html"><i class="fa fa-user"></i> Model Two</a></li>
						</ul>	
					</li>
						<li> <!-- Example for second level menu -->
							<a class="dropdown" href="#"><i class="fa fa-folder"></i> Dropdown menu <span class="label">3</span></a>
							<ul>
								<li><a href="#"><i class="fa fa-hdd"></i> Submenu item</a></li>
								<li><a href="#"><i class="fa fa-coffee"></i>Submenu item</a></li>
								<li><a href="#"><i class="fa fa-crop"></i> Submenu item</a></li>
							</ul>	
						</li>

						<!-- Sidebar header @add class nav-header for sidebar header -->
						<li class="nav-header">Components</li>
							<li><a href="tables.html"><i class="fa fa-table"></i>Tables</a></li>
					<li><a href="grid.html"><i class="fa fa-th-large"></i>Grid</a></li>
						<li> <!-- Example for second level menu -->
							<a class="dropdown" href="#"><i class="fa fa-folder"></i> Charts <span class="label">3</span></a>
							<ul>
								<li><a href="nvd.html"><i class="fa fa-hdd"></i> NVD</a></li>
								<li><a href="flot.html"><i class="fa fa-coffee"></i>Flot</a></li>
								<li><a href="knobs"><i class="fa fa-coffee"></i>Knobs</a></li>
							</ul>	
						</li>
						<li><a href="typography.html"><i class="fa fa-text-width"></i>Typography</a></li>
						<li>
								<a class="dropdown" href="forms.html"><i class="fa fa-list-alt"></i>Forms  <span class="label">4</span></a>
							<ul>
								<li><a href="form-elements.html"><i class="fa fa-indent"></i> Form Elements</a></li>
								<li ><a href="forms.html"><i class="fa fa-indent"></i>Forms</a></li>
								<li><a href="form-wizard.html"><i class="fa fa-coffee"></i>Form wizard</a></li>
								<li><a href="file-uploads.html"><i class="fa fa-indent"></i> File Upload</a></li>
							</ul>	
							
						</li>
						<li><a href="icons.html"><i class="fa fa-truck"></i>Icons</a></li>
					</ul>

			</div><!-- /Wrapper -->
		</div><!-- /Sidebar -->

		<!-- Main content starts here-->
		<div class="content">
			<div class="navbar">
				<a href="#" onclick="return false;" class="btn pull-left toggle-sidebar "><i class="fa fa-list"></i></a>
				<a class="navbar-brand" href="index.html">Archon</a>

				<!-- Top right user menu -->
				<ul class="nav navbar-nav user-menu pull-right">
					<!-- First nav user item -->
					<li class="dropdown hidden-xs">
						<a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i></a>
						<ul class="dropdown-menu right inbox">
							<li class="dropdown-menu-title">
								INBOX <span>(25)</span>
							</li>
							<li>
								<img src="images/theme/avatarTwo.png" alt="" class="avatar">
								<div class="message">
									<span class="username">Anusha</span> 
									<span class="mini-details">(6) <i class="fa fa-paper-clip"></i></span>
									<span class="time pull-right"> 06:58 PM</span>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's ... </p>
								</div>
							</li>
							<li>
								<img src="images/theme/avatarFive.png" alt="" class="avatar">
								<div class="message">
									<span class="username">Veeru</span> 
									<span class="mini-details">(2) <i class="fa fa-paper-clip"></i></span>
									<span class="time pull-right"> 09:58 AM</span>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's ... </p>
								</div>
							</li>
							<li>
								<img src="images/theme/avatarSix.png" alt="" class="avatar">
								<div class="message">
									<span class="username">Nag</span> 
									<span class="mini-details">(6) <i class="fa fa-paper-clip"></i></span>
									<span class="time pull-right">Yesterday</span>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's ... </p>
								</div>
							</li>
							<li>
								<img src="images/theme/avatarSeven.png" alt="" class="avatar">
								<div class="message">
									<span class="username">Harish</span> 
									<span class="mini-details"> <i class="fa fa-picture-o"></i></span>
									<span class="time pull-right">14/12/2013</span>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's ... </p>
								</div>
							</li>
							<li class="dropdown-menu-footer">
								<a href="#">View All Messages</a>
							</li>
						</ul>
					</li><!-- /dropdown -->

					<!-- Second nav user item -->
					<li class="dropdown hidden-xs">
						<a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i></a>
						<ul class="dropdown-menu right notifications">
							<li class="dropdown-menu-title">
								Notifications
							</li>
							<li>
								<i class="fa fa-cog avatar text-success"></i>
								<div class="message">
									<span class="username text-success">New settings activated</span> 
									<span class="time pull-right"> 06:58 PM</span>
								</div>
							</li>
							<li>
								<i class="fa fa-shopping-cart avatar text-danger"></i>
								<div class="message">
									<span class="username text-danger">You have 2 returns</span> 
									<span class="time pull-right"> 04:29 PM</span>
								</div>
							</li>
							<li>
								<i class="fa fa-user avatar text-success"></i>
								<div class="message">
									<span class="username text-success">New User registered</span> 
									<span class="time pull-right"> Yesterday</span>
								</div>
							</li>
							<li>
								<i class="fa fa-comment avatar text-info"></i>
								<div class="message">
									<span class="username text-info">New Comment received</span> 
									<span class="time pull-right"> Yesterday</span>
								</div>
							</li>
							<li>
								<i class="fa fa-cog avatar text-warning"></i>
								<div class="message">
									<span class="username text-warning">User deleted</span> 
									<span class="time pull-right"> 2 days ago</span>
								</div>
							</li>
							<li>
								<i class="fa fa-dollar avatar"></i>
								<div class="message">
									<span class="username">Earned 200 points</span> 
									<span class="time pull-right">3 days ago</span>
								</div>
							</li>
							<li>
								<i class="fa fa-hdd avatar text-danger"></i>
								<div class="message">
									<span class="username text-danger">Memory size exceeded </span> 
									<span class="time pull-right"> 1 week ago</span>
								</div>
							</li>

							<li class="dropdown-menu-footer">
								<a href="#">View All Notifications</a>
							</li>
						</ul>
					</li><!-- / dropdown -->

					<li class="dropdown user-name">
						<a class="dropdown-toggle" data-toggle="dropdown"><img src="images/theme/avatarSeven.png" class="user-avatar" alt="" />Vijay Kumar</a>
							<ul class="dropdown-menu right inbox user">
								<li class="user-avatar">
									<img src="images/theme/avatarSeven.png" class="user-avatar" alt="" />
									Vijay Kumar
								</li>
							<li>
								<i class="fa fa-user avatar"></i>
								<div class="message">
									<span class="username">Profile</span> 
								</div>
							</li>
							<li>
								<i class="fa fa-cogs avatar"></i>
								<div class="message">
									<span class="username">Settings </span> 
								</div>
							</li>
							<li>
								<i class="fa fa-book avatar"></i>
								<div class="message">
									<span class="username">Help </span> 
								</div>
							</li>
							<li><a href="#">Logout</a></li>
						</ul>
					</li><!-- / dropdown -->				
				</ul><!-- / Top right user menu -->

			</div><!-- / Navbar-->

			<div id="main-content">