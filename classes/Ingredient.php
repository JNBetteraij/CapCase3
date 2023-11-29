<?php declare(strict_types = 1);

include_once "../classes/storable.php";

class Ingredient implements Storable{
    private int $id;
    private string $name;
    private string $description;
    private int $amount;
    private string $units;

    function __construct(int|null $id, string $name, string $description, int $amount, string $units){
        if(!is_null($id)){
            $this->setID($id);
        }
        $this->setName($name);
        $this->setDescription($description);
        $this->setAmount($amount);
        $this->setUnits($units);
    }
    
#region get/set
    public function getID(): int|null{
        return $this->id;
    }

    public function setID($id): void{
        $this->id = $id;
    }

    public function getName(): string{
        return $this->name;
    }

    public function setName($name): void{
        $this->name = $name;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function setDescription($description): void{
        $this->description = $description;
    }

    public function getAmount(): int{
        return $this->amount;
    }

    public function setAmount($amount): void{
        $this->amount = $amount;
    }

    public function getUnits(): string{
        return $this->units;
    }

    public function setUnits($units): void{
        $this->units = $units;
    }
#end region

    public function convertToDatabaseFormat(): object{
        $tableData = new stdClass();
        $tableData->headers = ["ingredient_name", "brief_description"];
        $tableData->values = [ 
            $this->inQuotes($this->name),
            $this->inQuotes($this->description)
        ];
        return $tableData;
    }

    public function convertToJoinTableFormat(){
        $tableData = new stdClass();
        $tableData->headers = ["ingredient_id", "amount", "units "];
        $tableData->values = [
            $this->getID(),
            $this->getAmount(),
            $this->inQuotes($this->getUnits())
        ];
        return $tableData;
    }

    private function inQuotes($text): string{
        return "'" . trim($text) . "'";
    }
}