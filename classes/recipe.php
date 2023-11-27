<?php declare(strict_types = 1);

include_once("../classes/storable.php");
class Recipe implements Storable{
    private int $id;
    private string $date;
    private string $name;
    private string $description;
    private int $prepTime;
    private string $instructions;
    private array $ingredients;

    function __construct(int $id, string $date, string $name, string $description, int $prepTime, string $instructions, array $ingredients){
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
        $this->description = $description;
        $this->prepTime = $prepTime;
        $this->instructions = $instructions;
        $this->ingredients = $ingredients;
    }
    
    public function getID(): int{
        return $this->id;
    }

    public function setID($id): void{
        $this->id = $id;
    }

    public function getDate(): string{
        return $this->date;
    }

    public function setDate($date): void{
        $this->date = $date;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function setDescription($description): void{
        $this->description = $description;
    }

    public function getName(): string{
        return $this->name;
    }

    public function setName($name): void{
        $this->name = $name;
    }

    public function getPrepTime(): int{
        return $this->prepTime;
        
    }

    public function setPrepTime(int $prepTime){
        $this->prepTime = $prepTime;
    } 

    public function getInstructions(): string{
        return $this->instructions;
    }

    public function setInstructions(string|array $instructions): void{
        $instructions = [...$instructions];
        $this->instructions = $instructions;
    }

    public function getIngredients(): array{
        return $this->ingredients;
    }

    public function setIngredients($ingredients): void{
        $this->ingredients = $ingredients;
    }

    public function convertToDatabaseFormat(): array{
        return get_object_vars($this);
    }

    public function getRecipeTableValues(): object {
        $tableData = new stdClass();
        $tableData->headers = ["recipe_name", "brief_description", "preparation_time", "instructions"];
        $tableData->values = [ 
            $this->inQuotes($this->name),
            $this->inQuotes($this->description),
            $this->prepTime,
            $this->inQuotes($this->instructions)
        ];
        return $tableData;
    }

    private function inQuotes($text): string{
        return "'" . trim($text) . "'";
    }
}