<?php
namespace App\Models;

class TemperatureModel
{
    protected float $value;

    protected string $details;

    public function __construct(float $value, string $details = '')
    {
        $this->value = $value;
        $this->details = $details;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getDetails(): string
    {
        return $this->details;
    }
}