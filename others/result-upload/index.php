<?php //include('../include/sidebar.php')?>
<?php
 include('../../../includes/database.php');
 if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0){
        $target_dir = "../../../resultroom/"; 
        $target_file = $target_dir . basename($_FILES['file']['name']);
        $file_type =  strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_type = array("pdf", "png", "jpeg", "gif");
        if(!in_array($file_type, $allowed_type)) {
            echo "Sorry pdfs and images only";
        }else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
                $student_id = $_REQUEST["student_id"];
                $filename = $_FILES["file"]["name"];
                $filesize = $_FILES["file"]["size"];
                $filetype = $_FILES["file"]["type"];
                include('../../../includes/database.php');
                if($conn->connect_error) {
                    die("connection failed" . $conn->connect_error);
                }

                $sql = "INSERT INTO results (student_id, filename, filesize, filetype) VALUES ('$student_id', '$filename', $filesize, '$filetype')";
                if($conn->query($sql) === TRUE){
                    echo header("location: index.php");
                    
                }else {
                    echo "Sorry there was an error while trying to upload the file" . $conn->error;
                }
                $conn->close();
            } else {
                echo "Oops, there was an error";
            }
        } 
    } else {
        echo "No file  was uploaded";
    }
 }
 ?>
<div class="container mt-5">
  <h2 style="font-size:25px; margin-top:25px; margin-bottom:25px;">Upload Student Results</h2>
  <form action="#" method="post" enctype="multipart/form-data">
    <div>
      <label for="Student Id" style="font-family:monospace; font-size: 15px; margin-bottom:15px;">Student ID</label>
      <input type="text" name="student_id">
      <br>
      <label for="file" class="form-label" style="font-family:monospace; font-size: 15px; margin-bottom:15px;">Select file</label>
      <input type="file" style="font-family:monospace; font-size: 15px; margin-bottom:15px;" name="file" id="file">
    </div>
    <button type="submit" class="btn btn-primary">Upload</button>
  </form>
</div>
<?php //include('../include/header.php')?>