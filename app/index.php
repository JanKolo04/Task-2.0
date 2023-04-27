<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoloader</title>
</head>
<body>
    <?php
        if($_SERVER['REQUEST_URI'] != '/') {
            include __DIR__.'/controllers/about.php';
        }
    
        echo $_SERVER['REQUEST_URI'];
        echo "Hi"; 
    ?>
</body>
</html>