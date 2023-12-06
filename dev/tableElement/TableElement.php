<?php 
class TableElement{
    public function echoElement(Array $headers, Array $rows): void {
        //echo "<br>display table element here<br>";
        $replace = ["{headers}","{content}"];
        $values = [
            $this->getHeaderRowElement($headers),
            implode("",$this->getRowElements($rows))];
    
        $template = file_get_contents("../dev/tableElement/table.html");
        echo str_replace($replace, $values, $template);

        return;
    }

    function getHeaderRowElement(Array $headers): string {
        //echo "running getHeaderRowElement()<br>";
        $content = [];
        foreach ($headers as $header) {
            //echo "<br>adding header: ".$header;
            array_push($content,$this->getHeaderElement($header));
        }

        $replace = ["{rowContent}"];
        $values = [implode("",$content)];
    
        $template = file_get_contents("../dev/tableElement/tableRow.html");
        return str_replace($replace, $values, $template);
    }

    function getHeaderElement(string $header): string {
        $replace = ["{header}"];
        $values = ["$header"];
    
        $template = file_get_contents("../dev/tableElement/tableHeader.html");
        return str_replace($replace, $values, $template);
    }

    function getRowElements(Array $rows): array {
        //echo "running getRowElements<br>";
        $rowElements = [];
        foreach ($rows as $key => $row) {
            array_push($rowElements, $this->getRowElement($row));
        }
        return $rowElements;
    }

    function getRowElement(Array $row): string {
        $content = [];
        foreach ($row as $data) {
            array_push($content,$this->getDataElement($data));
        }

        $replace = ["{rowContent}"];
        $values = [implode("",$content)];

        $template = file_get_contents("../dev/tableElement/tableRow.html");
        return str_replace($replace, $values, $template);
    }

    function getDataElement(string $data): string {
        $replace = ["{data}"];
        $values = ["$data"];
    
        $template = file_get_contents("../dev/tableElement/tableData.html");
        return str_replace($replace, $values, $template);
    }
}
?>