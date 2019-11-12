<?php


namespace App\Project\Domain\Basket\Entity\Weight;


use App\Project\Domain\Basket\Exceptions\Weight\WeightLessZeroException;

class Weight
{
    private $weight;

    public function __construct(int $value = 0)
    {
        if ($value < 0)
            throw new WeightLessZeroException();

        $this->weight = $value;
    }

    public function __toString(): string
    {
        return strval($this->weight);
    }

    public function add(Weight $weight): Weight
    {
        $newWeight = $this->weight() + $weight->weight();
//        echo '$newWeight' . $newWeight . "\n";
        return new Weight($newWeight);
    }

    public function deduct(Weight $weight): Weight
    {
        if ($this->weight() < $weight->weight())
            throw new WeightLessZeroException();

        return new Weight($this->weight() - $weight->weight());
    }

    public function weight(): int
    {
        return $this->weight;
    }
}
