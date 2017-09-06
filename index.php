<?php ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);?>
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
				<li>Photo/file should be less than <code>500kb</code></li>
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
				$fileSize = $_FILES['file']['size'];

				$fileExt = explode('.', $filename);
				$fileActualExt = strtolower(end($fileExt));

				$allowedExt = array('jpg','gif');
				$allowedFileExt = array('doc','txt','pdf');

				if(in_array($fileActualExt, $allowedExt)){
					if($fileError === 0){
						if($fileSize < 500000){
							$fileDestination = 'uploads/'.$filename;
							move_uploaded_file($fileTmpName, $fileDestination);
							echo "<img src='".$fileDestination ."'height='350px' width='300px'>";
						}else{
							echo '<script language="javascript">';
							echo "alert('Your file size is too big...!')";
							echo '</script>';
						}

					}else{
						echo '<script language="javascript">';
						echo "alert('There was an error uploading your file!')";
						echo '</script>';
					}
												// Fileuploading script for files
				}elseif (in_array($fileActualExt, $allowedFileExt)){
					if($fileError === 0){
						if($fileSize < 500000){

							$fileDestination = 'uploads/'.$filename;
							move_uploaded_file($fileTmpName, $fileDestination);
							echo "<iframe src='".$fileDestination ."'height='350px' width='300px'></iframe>";
						}else{
							echo '<script language="javascript">';
							echo "alert('Your file size is too big...!')";
							echo '</script>';
						}

					}else{
						echo '<script language="javascript">';
						echo "alert('There was an error uploading your file!')";
						echo '</script>';
					}

				}else{
					echo '<script language="javascript">';
					echo "alert('You cannot upload files of this type')";
					echo '</script>';
				}
			} else {
				echo "<img src='./assets/images/no_image.png' height='350px' width='300px'>";
			}
			?>
		  </div>  <!-- imagepanel closing -->
		</div>   <!-- scriptwell closing -->
	</div>   <!-- col-md-6 scriptcolumn ending -->
   </div>   <!-- row ending -->
  </div>  <!-- homepanel ending -->
  <div class="container">  <!-- container to display images -->
  	<div class="row">
  	  <?php 
  	  			//display all images in the directory
  	  	$dir_path = "uploads/";
  	  	if (is_dir($dir_path)) 
  	  	{
  	  		$files = scandir($dir_path);
  	  		
  	  			//remove ./ and ../ folders 
  	  		$files = array_values(array_diff($files, array('.', '..')));

  	  		$per_page = 5;
  	  		$page = $per_page;
  	  		if(isset($_REQUEST['page']))
  	  		{
  	  			$page = $_REQUEST['page'] - 1;
  	  			
  	  			$from = $page * $per_page;
  	  			$to = $from + $per_page;	
  	  		}
  	  		else
  	  		{
  	  			$from = 0;
  	  			$to = $per_page;
  	  		}
  	  		for($i = 0 ; $i < count($files) ; $i++)
  	  		{
  				if($i >= $from && $i < $to)
  				{
  					$fileExt = explode('.', $files[$i]);
					$fileActualExt = strtolower(end($fileExt));
					$allowedImgExt = array('jpg','gif');
					$allowedFileExt = array('doc','txt','pdf');
					
					if(in_array($fileActualExt, $allowedImgExt)) {
	  	  				echo "<form method='post'><div class='col-md-2'><img src='$dir_path$files[$i]' style='width:150px;height:150px;' class='img-thumbnail'><br>";
	  	  				echo "<div id='images'><b>$files[$i]</b></div><br>";
	  	  				echo "<a class='btn-sm btn-danger delbtn' href='?delete=$i' >Delete</a></form></div>";

	  	  			}elseif (in_array($fileActualExt, $allowedFileExt)) {
	  	  				echo "<form method='post'><div class='col-md-2'><iframe src='$dir_path$files[$i]' style='width:150px;height:150px;'></iframe><br>";
	  	  				echo "<div id='images'><b>$files[$i]</b></div><br>";
	  	  				echo "<a class='btn-sm btn-danger delbtn' href='?delete=$i' >Delete</a></form></div>";
	  	  				}
	  	  			else {
	  	  				echo "Invalid file format";
	  	  			}
  	  			}
  	  		}
  	  	}
  	  			//delete images on click delete button
  	  	if(isset($_REQUEST['delete'])){
  	  		$del = $_REQUEST['delete'];
  	  		$file = "uploads/$files[$del]";
			if (!unlink($file))
			  {
			  echo ("Error deleting $file");
			  }
			else
			  {
			  header("location: index.php");
			  }
  	  	}
  	  ?>
  	</div>  <!-- row ending -->
  	<div id="pagination">
  		<?php 
  				//pagination
  			$files_per_page = 5;
  			$number_of_files = count($files);
  			$number_of_pages = ceil($number_of_files/$files_per_page);
  			for($page = 1; $page <= $number_of_pages; $page++)
  			{
  				echo '<a href="index.php?page='.$page.'">'.$page.'</a>';
  			}
  		 ?>
  	</div>
  </div><br>  <!-- container ending -->
</body>
</html>
