<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoloader</title>
</head>
<body>
    <?php
        require_once "vendor/autoload.php";

        $file_request_load = new Controller\AutoloadFilesRequest();
        $file_request_load->checkCorrectnessOfRequest();

    ?>
</body>
</html>