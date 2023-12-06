<?php 
include_once '../dev/tableElement/TableElement.php';

class EchoQuery{
    public static function asTable(mixed $fetchedArray): void {
        if(!$fetchedArray){
           echo "fetch returned as failed";
           return;
        }
        if(!is_array($fetchedArray)){
            echo "fetch is not structured as an array";
           return;
        }
        if(!is_array($fetchedArray[0])){
            echo "fetch is not structured as a multidimensional array";
           return;
        }

        $headers = array_keys($fetchedArray[0]);

        $rows = [];
        foreach ($fetchedArray as $row) {
            array_push($rows,array_values($row));
        }

        $table = new TableElement();
        $table->echoElement($headers,$rows);
        return;
    }
}
?>

