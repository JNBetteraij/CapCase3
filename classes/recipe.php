<?php declare(strict_types = 1);

include_once("../classes/storable.php");
class Recipe implements Storable{
    private string $id;
    private string $date;
    private string $name;
    private string $description;
    private int $prepTime;
    private string $instructions;
    private array $ingredients;

    function __construct(string $id, string $date, string $name, string $descirption, int $prepTime, string $instructions, array $ingredients){
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
        $this->description = $descirption;
        $this->prepTime = $prepTime;
        $this->instructions = $instructions;
        $this->ingredients = $ingredients;
    }
    
    public function getID(): string{
        return $this->id;
    }

    public function setID($id): string{
        $this->id = $id;
    }

    public function getDate(): string{
        return $this->date;
    }

    public function setDate($date): string{
        $this->date = $date;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function setDescription($description): string{
        $this->description = $description;
    }

    public function getName(): string{
        return $this->name;
    }

    public function setName($name): string{
        $this->name = $name;
    }

    public function getInstructions(): string{
        return $this->instructions;
    }

    public function setInstructions($instructions): string{
        $this->instructions = $instructions;
    }

    public function convertToDatabaseFormat(){
        return get_object_vars($this);
    }
}