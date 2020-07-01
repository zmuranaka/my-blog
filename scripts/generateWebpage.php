<?php

/*
File: generateWebpage.php
Zachary Muranaka
Dynamically creates a webpage with the posted content and writes a link to it into index.html
*/

if(isset($_POST['post']))
{
    extract($_POST, EXTR_PREFIX_ALL, 'new_post');
    $fixedTitle = removeFiller($new_post_title); // Stores the title without filler characters like _ or -

    if($_FILES) uploadImages(array_filter($_FILES));
    
    // Dynamically create a new HTML file
    $dynamic_page = fopen("../$new_post_title.html", 'w') or die("$new_post_title.html could not be created");
    
    // Create the beginning of the dynamic HTML
    $dynamic_html = <<<HTML
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1'>

HTML;

    $dynamic_html .= "\t<title>$fixedTitle</title>"; // Append the HTML title using the fixed title
    
    // Append a link to the stylesheet, end the head tag, and begin the body tag
    $dynamic_html .= <<<HTML

    <link href='styles/blogStyles.css' rel='stylesheet'>
</head>

<body>

HTML;

    // Append an h1 with the fixed title, the content of the post, and the beginning of the footer
    $dynamic_html .= "<h1>$fixedTitle</h1>\r\n$new_post_content\r\n<footer>- Zachary Muranaka<br>";
    
    $dynamic_html .= date("F d, Y h:i A"); // Append the date in the format Month DD, YYYY HH:MM AM
    
    // Finish the dynamic HTML document by ending the footer and closing the body and html tags
    $dynamic_html .= <<<HTML

<br>
<a href='mailto:zacharymuranaka@mail.weber.edu'><img src='images/mailLogo.png' alt='Mail'/></a>
<a href='https://github.com/zmuranaka'><img src='images/githubLogo.png' alt='GitHub'/></a>
<a href='https://zmuranaka.github.io/'><img src='images/linkLogo.png' alt='My Portfolio'/></a>
<br>
<a href='index.html'>Home</a>
</footer>
</body>

</html>
HTML;

    // Write the html to the file and close the file
    fwrite($dynamic_page, $dynamic_html);
    fclose($dynamic_page);

    // Write a new link for the new blog post
    $new_link = "\r\n\t<a href='$new_post_title.html' class='blogPostLink'>$fixedTitle</a><hr>";

    // Edit index.html by writing the new link into it
    $indexPage = fopen("../index.html", 'r+') or die("index.html could not be opened");
    fseek($indexPage, 428, SEEK_SET);
    while(!feof($indexPage)) $old_html .= fread($indexPage, 1); // Read all HTML from position 428 to EOF
    fseek($indexPage, 428, SEEK_SET);
    fwrite($indexPage, $new_link . $old_html) or die("index.html could not be written to");
    fclose($indexPage);

    header("Location: ../index.html"); // Redirect to index.html
}

// Removes filler characters from the title
function removeFiller($title)
{
    for($i = 0; $i < strlen($title); $i++)
    {
        if($title[$i] === '_' || $title[$i] === '-') $title[$i] = ' ';
    }
    return $title;
}

// Uploads the images submitted through the form to the web server
function uploadImages($filesArray)
{
    for($i = 0; $i < count($filesArray['files']['name']); $i++)
    {
        $fileIsImage = FALSE;
        
        switch($filesArray['files']['type'][$i])
        {
            case 'image/jpeg':
            case 'image/gif':
            case 'image/png':
            case 'image/tiff': $fileIsImage = TRUE;
        }

        if($fileIsImage) // We only upload the file if it is an image
        {
            // Get the file's path
            $tempPath = $filesArray['files']['tmp_name'][$i];

            // Setup our new file path
            $newPath = "../images/" . $filesArray['files']['name'][$i];
            
            move_uploaded_file($tempPath, $newPath); // Move the file onto the web server
        }
    }
}
