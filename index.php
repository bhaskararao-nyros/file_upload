<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="File Uploading">
    <meta name="keywords" content="HTML,CSS,Bootstrap,PHP">
    <meta name="author" content="Bhaskararao Gummidi">
	<title>PHP File Upload</title>
</head>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
<body>
<div class="panel panel-default homepanel">
  <div class="panel-heading"><h4 class="text-center"><b>UPLOAD A PHOTO OR FILE</b></h4></div>
   <div class="row">
	<div class="col-md-6 guidelinescolumn">
		<div class="well guidelineswell">
			<h4><b>Guidelines for uploading photo :</b></h4>
			<ul>
				<li>Photo/file should be less than <code>200kb</code></li>
				<li><code>.jpg</code>, <code>.gif</code> extensions images are acceptable</li>
				<li><code>.doc</code>, <code>.pdf</code> and <code>.txt</code> extensions files are acceptable</li>
				<li>Photo/file should be clear and neat background</li>
			</ul>
			<form action="" method="POST" enctype="multipart/form-data">
				<input type="file" name="file">
				<center><button class="btn btn-danger btn-sm" name="submit">Upload</button></center> 
			</form>
		</div>   <!-- guidelineswell closing -->
	</div>    <!-- guidelinescolumn closing -->
	<div class="col-md-6 scriptcolumn">
		<div class="well scriptwell">
		  <div class="panel panel-default imagepanel">
			<?php 		// Fileuploading script for images
			if(isset($_POST['submit'])){

				$filename = $_FILES['file']['name'];
				$fileTmpName = $_FILES['file']['tmp_name'];
				$fileError = $_FILES['file']['error'];

				$fileExt = explode('.', $filename);
				$fileActualExt = strtolower(end($fileExt));

				$allowedExt = array('jpg','gif');
				$allowedFileExt = array('doc','txt','pdf');

				if(in_array($fileActualExt, $allowedExt)){
					if($fileError === 0){
						if($fileSize < 500000){

							$fileNameNew = uniqid('',true).".".$fileActualExt;
							$fileDestination = 'uploads/'.$fileNameNew;
							move_uploaded_file($fileTmpName, $fileDestination);
							echo "<img src='".$fileDestination ."'height='350px' width='300px'>";
						}else{
							echo "Your file size is too big...!";
						}

					}else{
						echo "There was an error uploading your file!";
					}
												// Fileuploading script for files
				}elseif (in_array($fileActualExt, $allowedFileExt)){
					if($fileError === 0){
						if($fileSize < 500000){

							$fileNameNew = uniqid('',true).".".$fileActualExt;
							$fileDestination = 'uploads/'.$fileNameNew;
							move_uploaded_file($fileTmpName, $fileDestination);
							echo "<iframe src='".$fileDestination ."'height='350px' width='300px'></iframe>";
						}else{
							echo "Your file size is too big...!";
						}

					}else{
						echo "There was an error uploading your file!";
					}

				}else{
					echo "You cannot upload files of this type";
				}
			}
			?>
		  </div>  <!-- imagepanel closing -->
		</div>   <!-- scriptwell closing -->
	</div>   <!-- col-md-6 scriptcolumn ending -->
   </div>   <!-- row ending -->
  </div>  <!-- homepanel ending -->
</body>
</html>
