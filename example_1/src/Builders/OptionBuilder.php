<?php


namespace App\Builders;


use App\Entity\Rule;
use App\Entity\Option;
use App\Interfaces\OptionBuilderInterface;
use App\Interfaces\RuleInterface;

class OptionBuilder implements OptionBuilderInterface
{

    /**
     * @var bool
     */
    private $checkAge = false;

    /**
     * @var bool
     */
    private $checkKids = false;

    /**
     * @var bool
     */
    private $checkCar = false;

    /**
     * @var array
     */
    private $rules = [];

    /**
     * @return $this
     */
    public function checkCar()
    {

        $this->checkCar = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCheckCar():bool
    {
        return $this->checkCar;
    }

    /**
     * @return $this
     */
    public function checkAge()
    {

        $this->checkAge = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCheckAge():bool
    {
        return $this->checkAge;
    }

    /**
     * @return $this
     */
    public function checkKids()
    {

        $this->checkKids = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCheckKids():bool
    {
        return $this->checkKids;
    }

    /**
     * @param RuleInterface $rule
     * @return $this
     */
    public function addRule(RuleInterface $rule)
    {
        if (!in_array($rule->getType(),array_keys($this->rules))){
            $this->rules[$rule->getType()] = [];
        }

        $this->rules[$rule->getType()][] = $rule;

        return $this;
    }

    /**
     * @return Rule[]
     */
    public function getRules():array
    {
        return $this->rules;
    }

    /**
     * @return Option
     */
    public function build()
    {
        return new Option($this);
    }
}