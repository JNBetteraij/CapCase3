<?php declare(strict_types = 1);

class Recipe{
    private int $id;
    private string $date;
    private string $name;
    private string $description;
    private int $prepTime;
    private string $instructions;
    private array $ingredients;

    function __construct(int $id, string $date, string $name, string $descirption, int $prepTime, string $instructions, array $ingredients){
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
        $this->description = $descirption;
        $this->prepTime = $prepTime;
        $this->instructions = $instructions;
        $this->ingredients = $ingredients;
    }
    
    public function getID(): int{
        return $this->id;
    }

    public function setID($id): int{
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
}