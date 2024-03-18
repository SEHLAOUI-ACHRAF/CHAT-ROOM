<?php

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        exit('POST request method required');
    }
    
    if (empty($_FILES)) {
        exit('$_FILES is empty - is file_uploads set to "On" in php.ini?');
    }
    
    // Use fileinfo to get the mime type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($_FILES["cv"]["tmp_name"]);
    
    // Check if the uploaded file is a PDF
    if ($mime_type !== "application/pdf") {
        exit("Invalid type de fichier importer un fichier pdf svp !.");
    }
    
    // Replace any characters not \w- in the original filename
    $pathinfo = pathinfo($_FILES["cv"]["name"]);
    
    $base = $pathinfo["filename"];
    
    $base = preg_replace("/[^\w-]/", "_", $base);
    
    $filename = $base . "." . $pathinfo["extension"];
    
    $destination = __DIR__ . "/CVpdf/" . $filename;
    
    // Add a numeric suffix if the file already exists
    $i = 1;
    
    while (file_exists($destination)) {
    
        $filename = $base . "($i)." . $pathinfo["extension"];
        $destination = __DIR__ . "/CVpdf/" . $filename;
    
        $i++;
    }
    
    if (!move_uploaded_file($_FILES["cv"]["tmp_name"], $destination)) {
    
        exit("Can't move uploaded file");
    
    }
    
    echo "File uploaded successfully.";
    
?>