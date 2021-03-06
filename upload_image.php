<?php
include $_SERVER['DOCUMENT_ROOT'] . '/thepurplebooth/includes/links.php';
require_once "database/image_info.php";
ini_set('memory_limit', '-1');
ob_start();
?>

<html>
	<head>
		<title>Upload Picture</title>
		<link href='/thepurplebooth/css/upload_image.css' rel='stylesheet' type='text/css'>
		
		<script type="text/javascript">
			
		</script>
	</head>
	<body>
			<?php
				include $_SERVER['DOCUMENT_ROOT'] . '/thepurplebooth/includes/masterpage.php';
			?>
			<?php
				if(!isset($_SESSION['thepurplebooth_user_name'])){
	      	?>
	      	<div id="upload-signup" class="container-fluid">
				<div class="offset1" style="margin-top: 100px;">
					<h2 style="color: #525252;">This is where you upload the raw pics!</h2>
	      			<p>... but before you do, we need you to <a href="http://localhost:8888/thepurplebooth/socialauth/index.php">sign-in or sign-up</a>.</p>
				</div>
			</div>
		   	<?php } else { ?>
		   	<div id="upload" class="container-fluid">
		        <div class="offset1" style="margin-top: 100px;"> 
		        	<h2 style="color: #525252;">This is where you upload the raw pics!</h2>
			        <form method="post" enctype="multipart/form-data">
				     	<div id="image-title">
				     		<p>Choose a title for the image</p>
				     		<textarea id="title" name="title" class="enterComment" placeholder="Title" required></textarea>
				     	</div>
			
			     	<div>
						<p>Choose a category for the image</p>			
						<select name="category">
						    <?php include $_SERVER['DOCUMENT_ROOT'] . '/thepurplebooth/includes/categories.php'; ?>
						</select>
						<!--<div class="btn-group">
							<button id="catergory" name='category' type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								Categories
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<?php include $_SERVER['DOCUMENT_ROOT'] . '/thepurplebooth/includes/categories.php'; ?>
							</ul>
						</div>	-->
					</div>
					
					<div>
			     		<p>What kind of work would you like to be done on your image?</p>
			     		<textarea id="description" name="description" class="enterComment" placeholder="Description" required></textarea>
			     	</div>
					
					<div>
				     	<p>Click below to select the pic you want to upload</p>
						<p>
						
							<input name="userfile" type="file" id="userfile" class="btn">
							<button class="btn btn-inverse btn-small" id="upload" name="upload" type="submit">
								<i class="icon-camera icon-white"> </i> Upload </button>			
						</p>
					</div>
					</form>
				</div>
			</div>
		<!-- 	End Container -->
			<?php } ?>
			<?php
				include $_SERVER['DOCUMENT_ROOT'] . '/thepurplebooth/includes/footer.php';
			?>
	</body>
</html>
<?php
if (isset($_POST['upload']) && $_FILES['userfile']['size'] > 0) {
	try {
		$file_name = $_FILES['userfile']['name'];
		$tmp_name = $_FILES['userfile']['tmp_name'];
		$file_size = $_FILES['userfile']['size'];
		$file_type = $_FILES['userfile']['type'];
		$title = $_POST['title'];
		$description = $_POST['description'];
		$category = $_POST['category'];
		$success = FALSE;
		
		$success = upload_image($_SESSION['thepurplebooth_user_id'],$file_name,$tmp_name,$file_size,$file_type,$title,$description,$category);

		include $_SERVER['DOCUMENT_ROOT'] . '/thepurplebooth/includes/statuspopup.php';
		
	} catch(Exception $e) {
		error_log($e);
	}
}

if (isset($_POST['uploadmany']) && $_FILES['uploadedfiles']['size'] > 0) {
	try {
		for($i=0;$i<sizeof($_FILES["uploadedfiles"]["name"]);$i++) {
			$file_name =$_FILES["uploadedfiles"]['name'][$i];
			$tmp_name = $_FILES["uploadedfiles"]['tmp_name'][$i];
			$file_size = $_FILES["uploadedfiles"]['size'][$i];
			$file_type = $_FILES["uploadedfiles"]['type'][$i];
			
			$success = upload_image($_SESSION['thepurplebooth_user_id'],$file_name,$tmp_name,$file_size,$file_type);
		}
		
		if ($success === TRUE){?>			
		<script type="text/javascript">
			jSuccess(
				    'Upload Images Sucessful!',
				    {
				      autoHide : true,
				      TimeShown : 2000,
				      HorizontalPosition : 'center',
				      ShowOverlay : false
				    }
				   );
		</script>	
		<?php }
		else {?>
		<script type="text/javascript">
			jError(
				   'Upload Images Failed!',
				   {
				     autoHide : true,
				     TimeShown : 2000,
				     HorizontalPosition : 'center',
				     ShowOverlay : false
				   }
				  );
		</script>	
		<?php }
	} catch(Exception $e) {
		error_log($e);
	}
}
?>
<?php ob_end_flush(); ?>