<?php

function generatePage($body, $title="Project3") {
    $page = <<<EOPAGE
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>$title</title>	
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </head>
    
    <body>
            $body
    </body>
</html>
EOPAGE;

    return $page;
}

?>