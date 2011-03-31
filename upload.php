<?php

$errors = array();
$data = "";
$success = "true";

function return_result($success,$errors,$data) {
	echo("<?xml version=\"1.0\" encoding=\"utf-8\"?>");	
	?>
	<results>
	<success> <?php echo($success); ?> </success>
	<?php echo($data);?>
	<?php echo_errors($errors);?>
	</results>
	<?php
}

function echo_errors($errors) {

	for($i=0;$i<count($errors);$i++) {
		?>
		<error><?php echo($errors[$i]);?></error>
		<?php
	}
}

switch($_REQUEST['action']) {

    case "upload":

    $file_temp = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];

    //$file_path = $_SERVER['DOCUMENT_ROOT']."/uploads";
	 $file_path = "uploads";

    //checks for duplicate files
    if(!file_exists($file_path."/".$file_name)) {

         //complete upload
         $filestatus = move_uploaded_file($file_temp,$file_path."/".$file_name);

         if(!$filestatus) {
         $success = "false";
         array_push($errors,"Upload failed. Please try again. ".$file_path."/".$file_name);
         }

    }
    else {
    $success = "false";
    array_push($errors,"File already exists on server.");
    }

    break;

    default:
    $success = "false";
    array_push($errors,"No action was requested.");

}

return_result($success,$errors,$data);

?>