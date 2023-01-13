<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');


if (isset($_POST['upload'])) {

	# database connection file
	include 'db.conn.php';

	$images = $_FILES['images'];
	
	
	# Number of images
    $num_of_imgs = count($images['name']);

    for ($i=0; $i < $num_of_imgs; $i++) { 
    	
    	# get the image info and store them in var
    	$image_name = $images['name'][$i];
    	$tmp_name   = $images['tmp_name'][$i];
    	$error      = $images['error'][$i];

    	# if there is not error occurred while uploading
    	if ($error === 0) {
    		
    		# get image extension store it in var
    		$img_ex = pathinfo($image_name, PATHINFO_EXTENSION);

    		/** 
			convert the image extension into lower case 
			and store it in var 
			**/
			$img_ex_lc = strtolower($img_ex);
            
            /** 
			crating array that stores allowed
			to upload image extensions.
			**/
			$allowed_exs = array('jpg', 'jpeg', 'png');


			/** 
			check if the the image extension 
			is present in $allowed_exs array
			**/

			if (in_array($img_ex_lc, $allowed_exs)) {
				/** 
				 renaming the image name with 
				 with random string
							**/
			$gametitle = $_POST['gametitle'];
				$location = "../gameimages/".$gametitle;
				if(!is_dir($location)) {
					$makepath=mkdir($location,741);
					chmod($location, 0741);
				}
				else{ 
					$makepath=$location;
				}
				$new_img_name = uniqid($gametitle, true).'.'.$img_ex_lc;
				
				
				$location.='/'.$new_img_name;
				# inserting imge name into database
                $img_upload_path =$location;
                $createdate=time();
                $sql  = "INSERT INTO gameimages (file_name)
                         VALUES(?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$new_img_name]);
                // $mysqli = NEW MySQLi('localhost','root','','Company');
              
                // $insert= $mysqli->query("INSERT INTO gameimages(gametitle,createdate)VALUES('$gametitle','$createdate')");
                //          if($insert){
                //             $error .="<br><p><center>done!</p></center><br>";
                //             echo $error;
                         
                            
                //         }
                        
                //         else{
                //             echo $mysqli->error;
                //         }     
				// Compress image
				// function compressImage($source, $destination, $quality) {//gelecekte kullanılacak

				// 	$info = getimagesize($source);
				
				// 	if ($info['mime'] == 'image/jpeg') 
				// 	$image = imagecreatefromjpeg($source);
				
				// 	elseif ($info['mime'] == 'image/gif') 
				// 	$image = imagecreatefromgif($source);
				
				// 	elseif ($info['mime'] == 'image/png') 
				// 	$image = imagecreatefrompng($source);
				
				// 	imagejpeg($image, $destination, $quality);
				
				// }
				// ini_set('memory_limit', '512M'); //risk
				//compressImage($tmp_name,$img_upload_path,65);
				
                # move uploaded image to 'uploads' folder
                move_uploaded_file($tmp_name, $img_upload_path);

		    	# redirect to 'index.php'
	            
				echo "<script>setTimeout('window.close();',4000)</script> Done";
				echo "<p><center>Uploading! This page will close itself after validation. PLEASE DON'T THIS PAGE MANUALLY OR VALIDATION WILL FAIL</p></center>";
			 
			}else {
				# error message
    	     	$em = "You can't upload files of this type";

	    		/*
	           	redirect to 'index.php' and 
		    	passing the error message 
		        */

	            header("Location: new-post.php?error=$em");
			}

   
    	}else {
    		# error message
    		$em = "Unknown Error Occurred while uploading";

    		/*
	    	redirect to 'index.php' and 
	    	passing the error message
	        */

	        header("Location: new-post.php?error=$em");
    	}
    }	
}
?>