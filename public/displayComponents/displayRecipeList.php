<?php declare(strict_types = 1);

$exampleArray = [19,1,3,4,35,66,7];

function displayRecipeList(){
    $replace = ["{thumbnails}"];
    $values = [getListElement()];
    $template = file_get_contents("displayComponents/recipeList.html");
    echo str_replace($replace, $values, $template);
}

function getListElement(){
    global $exampleArray;

    $recipies = $exampleArray;
    $thumbnails = [];

    for ($i = 0; $i < count($recipies); $i++){
        $value = $recipies[$i];
        // echo $recipies[$i];
        // echo $i;
        array_push($thumbnails, getThumbnailElement($value));
    }
    
    return implode("", $thumbnails);
    //return implode("",["<li>",implode("</li> <li>", $thumbnails),"</li>"]);
}

function getThumbnailElement(int $id): string{

    $replace = ["{id}"];
    $values = ["$id"];

    $template = file_get_contents("displayComponents/recipeThumbnail.html");
    return str_replace($replace, $values, $template);
}
?>