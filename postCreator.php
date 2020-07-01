<?php

/*
File: postCreator.php
Zachary Muranaka
Allows me to make a new blog post
*/

require_once('scripts/login.php');
if(informationEntered()) // Function from login.php
{
    if(informationIsCorrect()) // Function from login.php
    {
        // Show the webpage
        echo <<<HTML
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1'>
    <title>Make a New Post</title>
    <link href='styles/blogStyles.css' rel='stylesheet'>
    <style>
        .helperBtn {
            display: inline-block;
            width: 8%;
            margin: 1vh auto;
            border-width: 2px;
            border-style: outset;
            border-image: initial;
            cursor: pointer;
            text-align: center;
            text-indent: 0;
            user-select: none; /* Prevents the default of highlighting the text when double or triple-clicked */
        }
        .helperBtn:hover {
            background: gray;
            color: white;
        }
        .helperBtn:active {
            background: black;
            color: white;
        }
    </style>
</head>

<body>
    <h1>New Post</h1>
    <form method='post' action='scripts/generateWebpage.php' enctype='multipart/form-data'>
        <input name='title' type='text' placeholder='Type the name of the post here'>
        <textarea name='content' rows='8' placeholder='Type the text of the post here' required></textarea>
        <input type='file' name='files[]' multiple>
        <input type='submit' name='post' value='Post'>
    </form>
    <div class='helperBtn' id='aBtn'>a</div>
    <div class='helperBtn' id='codeBtn'>code</div>
    <div class='helperBtn' id='divBtn'>div</div>
    <div class='helperBtn' id='h2Btn'>h2</div>
    <div class='helperBtn' id='h3Btn'>h3</div>
    <div class='helperBtn' id='hrBtn'>hr</div>
    <div class='helperBtn' id='imgBtn'>img</div>
    <div class='helperBtn' id='pBtn'>p</div>
    <div class='helperBtn' id='sectionBtn'>section</div>
    <div class='helperBtn' id='strongBtn'>strong</div>
    <script>
        var text = document.getElementsByTagName('textarea')[0];

        // The divs add HTML to the textarea when clicked
        document.getElementById('aBtn').onclick = function(e){ text.value += '<a href=""></a>'; };
        document.getElementById('codeBtn').onclick = function(e){ text.value += '<code></code>'; };
        document.getElementById('divBtn').onclick = function(e){ text.value += '<div></div>'; };
        document.getElementById('h2Btn').onclick = function(e){ text.value += '<h2></h2>'; };
        document.getElementById('h3Btn').onclick = function(e){ text.value += '<h3></h3>'; };
        document.getElementById('hrBtn').onclick = function(e){ text.value += '<hr>'; };
        document.getElementById('imgBtn').onclick = function(e){ text.value += '<img src="images/" alt="">'; };
        document.getElementById('pBtn').onclick = function(e){ text.value += '<p></p>'; };
        document.getElementById('sectionBtn').onclick = function(e){ text.value += '<section></section>'; };
        document.getElementById('strongBtn').onclick = function(e){ text.value += '<strong></strong>'; };
    </script>
    <br>
    <a href='index.html'>Home</a>
</body>
</html>
HTML;
    }
    else // The username and/or password was incorrect
    {
        // HTML that tells the user that the information they entered was invalid
        $dieText = <<<HTML
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <title>Try Again</title>
    <link href='styles/blogStyles.css' rel='stylesheet'>
    <style>
        div {
            text-align: center;
            text-indent: 0;
        }
    </style>
</head>

<body>
    <div>Invalid username / password combination</div>
    <br>
    <a href='index.html'>Home</a>
</body>

</html>
HTML;
        die($dieText); // Kill the program
    }
}
else // The username and password have not been entered
{
    // Restrict the HTML unless the correct username and password are entered
    header('WWW-Authenticate: Basic realm="Restricted Section"');
    header('HTTP/1.0 401 Unauthorized');
    
    // HTML that tells the user that they need to enter the correct information
    $dieText = <<<HTML
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <title>Error</title>
    <link href='styles/blogStyles.css' rel='stylesheet'>
    <style>
        div {
            text-align: center;
            text-indent: 0;
        }
    </style>
</head>

<body>
    <div>Please enter your username and password</div>
    <br>
    <a href='index.html'>Home</a>
</body>

</html>
HTML;
    die($dieText); // Kill the program
}
