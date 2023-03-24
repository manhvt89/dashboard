<?php
if (isset($_FILES['myFile'])) {
    // Example:
	$question_id = 'q'.$_POST['question_id'];
	$path = "ckfinder/userfiles/images/".$question_id.'/';
	//$path = "ckfinder/userfiles/images/";
	if (!file_exists($path)) {
		mkdir($path, 0777, true);
	}
    move_uploaded_file($_FILES['myFile']['tmp_name'], $path . $_FILES['myFile']['name']);
    echo 'successful';
}
?>