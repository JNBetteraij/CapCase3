<?php declare(strict_types = 1);

$exampleArray = [1,2,3,4,5,6,7];
include 'displayComponents/displayRecipeList.php';

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Receptenboek</title>   
</title>
</head>
<body>
    <header>
        <h1>
            Ons lekkere kookboek
        </h1>
    </header>
    <main>
        <?php displayRecipeList();?>
    </main>
</body>
</html>