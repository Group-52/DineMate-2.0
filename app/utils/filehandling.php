<?php 

// Generates a unique name for the file using timestamp
function getFileName($name,$file){
    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $name = str_replace(' ', '', $name);
    $date = new DateTime();
    $n = $date->format('H:i:s');
    $n = str_replace(array("-"," ",":"), "_", $n);
    return $name.$n.".".$ext;
}

//Check if the file is of an image type
function checkforImage($file){
    $target_file = basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" )
    return false;
    else
    return true;
}

// Check if the file size is not too large
//Input file size in bytes
function checkforSize($file,$size){
    if ($file["size"] > $size) {
        return false;
    }
    else
    return true;
}

// Check if the file is an actual image
function checkforActualImage($file){
    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
        return true;
    } else {
        return false;
    }
}