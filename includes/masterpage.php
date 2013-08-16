<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
?>

<script src="http://code.jquery.com/jquery-1.9.0.min.js"></script>
<script src="js/bootstrap.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		var pathname = window.location.pathname;
		if (pathname.search('index') !== -1) {
			$('li:nth-child(1)').addClass('active');
		} else if (pathname.search('contact') !== -1) {
			$('li:nth-child(2)').addClass('active');
		} else if (pathname.search('about') !== -1) {
			$('li:nth-child(3)').addClass('active');
		} else if (pathname.search('upload') !== -1) {
			$('li:nth-child(4)').addClass('active');
		} else if (pathname.search('gallery') !== -1) {
			$('li:nth-child(5)').addClass('active');
		} else {
			$('li:nth-child(0)').addClass('active');
		}
	})
</script>

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse"
			data-target=".nav-collapse"> <span class="icon-th-list"></span> </a><a href="/codenameDS/index.php" class="brand">codenameDS</a>

			<div class="nav-collapse collapse">
				<ul class="nav pull-right" id="codenameDSnavigationbar">
					<li>
						<a href="/codenameDS/index.php">Home</a>
					</li>
					<li>
						<a href="/codenameDS/contact.php">Contact</a>
					</li>
					<li>
						<a href="/codenameDS/about_us.php">About Us</a>
					</li>
					<li>
						<a href="/codenameDS/upload_image.php">Upload Image</a>
					</li>
					<li>
						<a href="/codenameDS/gallery.php">Gallery</a>
					</li>
					<li>
						<a href="#loginModal" data-toggle="modal">new Login</a>
					</li>
					<li>
						<?php 	
						
						if(!isset($_SESSION['codenameDS_user_name'])) {
							?> <a href="/codenameDS/socialauth/index.php">Login</a>	<?php
						}
						else{ 
						?>
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<?php echo $_SESSION['codenameDS_user_name']; ?>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li>
								</li>
								<li>
									<a href="/codenameDS/socialauth/index.php?action=logout">Logout</a>
								</li>
								<li>
									<a href="profile.php">Profile</a>
								</li>
							</ul>
						</div>						
						<?php }?>				
					</li>
				</ul>
			</div>

		</div>
	</div>
</div>





<div class="modal hide" id="loginModal" aria-hidden="true">
	<div class="modal-header">
		<h2>codenameDS Login</h2>
	</div>

	<div class="modal-body" style="overflow: hidden">
		<form method="POST" action="login.php">
			<div class="row-fluid">

				<div class="span12">
					<?php include $_SERVER["DOCUMENT_ROOT"].'/codenameDS/socialauth/index.php'?>
				</div>
			</div>
		</form>
	</div>

	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">
			Close
		</button>
	</div>
</div>