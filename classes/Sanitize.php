<?php 
class Sanitize{
    public static function stringInput(string $data): string 
            {   
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);   
                return $data; 
            }
}
?>