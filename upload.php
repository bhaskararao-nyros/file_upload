<?php
if(isset($_POST['submit'])){

	$filename = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileError = $_FILES['file']['error'];

	$fileExt = explode('.', $filename);
	$fileActualExt = strtolower(end($fileExt));

	$allowedExt = array('jpg','gif','doc','txt','pdf');

	if(in_array($fileActualExt, $allowedExt)){
		if($fileError === 0){
			if($fileSize < 50000){

				$fileNameNew = uniqid('',true).".".$fileActualExt;
				$fileDestination = 'uploads/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				echo "<img src='".$fileDestination ."'>";

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

