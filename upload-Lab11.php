<?php

//UPLOAD FILE
if ($_FILES["file_upload"]["error"] > 0) {
    echo '<script>alert("ERROR:' . $_FILES["file_upload"]["error"] . '")</script>';
}
else if (file_exists("upload/" . $_POST["inputName"])) {
    echo '<script>alert("' . $_POST["inputName"] . ' has been existed and recovered")</script>';
}
else {
    move_uploaded_file($_FILES["file_upload"]["tmp_name"], "upload/" . $_POST["inputName"]);
    echo '<script>alert("File saved at: upload/' . $_POST["inputName"] . '")</script>';
}

//CREATE LRC FILE
$name = str_replace(".mp3", ".lrc", $_POST["inputName"]);
$lrc = fopen("upload/" . $name, "w") or die("Fail to create .lrc file");
fwrite($lrc, $_POST["edit_lyric"]);
fclose($lrc);

//GO BACK TO LAB11.PHP
echo '<script>window.location.href="Lab11.php"</script>';

?>
