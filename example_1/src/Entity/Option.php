<?php


namespace App\Entity;

use App\Interfaces\OptionBuilderInterface;
use App\Interfaces\OptionInterface;

class Option implements OptionInterface
{

    /**
     * @var Rule[]
     */
    protected $rules = [];

    /**
     * @var bool
     */
    protected $checkKids = false;

    /**
     * @var bool
     */
    protected $checkAge = false;

    /**
     * @var bool
     */
    protected $checkCar = false;

    public function __construct(OptionBuilderInterface $bonusCheckBuilder)
    {
        $this->checkCar = $bonusCheckBuilder->getCheckCar();

        $this->checkAge = $bonusCheckBuilder->getCheckAge();

        $this->checkKids = $bonusCheckBuilder->getCheckKids();

        $this->rules = $bonusCheckBuilder->getRules();

    }

    /**
     * @return Rule[]
     */
    public function getRules():array
    {
        return $this->rules;

    }

    /**
     * @return bool
     */
    public function getCheckAge():bool
    {
        return $this->checkAge;
    }

    /**
     * @return bool
     */
    public function getCheckKids():bool
    {
        return $this->checkKids;
    }

    /**
     * @return bool
     */
    public function getCheckCar():bool
    {
        return $this->checkCar;
    }

}