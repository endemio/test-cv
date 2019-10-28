<?php


namespace App\Entity;


use App\Interfaces\RuleInterface;
use App\Builders\RuleBuilder;

class Rule implements RuleInterface
{

    /**
     * @var float
     */
    protected $age = 0;

    /**
     * @var int
     */
    protected $kids = 0;

    /**
     * @var bool
     */
    protected $car = false;

    /**
     * @var bool
     */
    protected $salary = false;

    /**
     * @var bool
     */
    protected $tax = false;

    /**
     * @var int
     */
    protected $percent = 0;

    /**
     * @var int
     */
    protected $money = 0;

    /**
     * @var int
     */
    protected $sign = 0;

    /**
     * @var string
     */
    protected $rule_type='';

    public function __construct(RuleBuilder $RuleBuilder)
    {
        $this->age = $RuleBuilder->age;
        $this->kids = $RuleBuilder->kids;
        $this->car = $RuleBuilder->car;
        $this->salary = $RuleBuilder->salary;
        $this->tax = $RuleBuilder->tax;
        $this->percent = $RuleBuilder->percent;
        $this->money = $RuleBuilder->money;
        $this->sign = $RuleBuilder->sign;
        $this->rule_type = $RuleBuilder->getType();
    }


    /**
     * @return float
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @return int
     */
    public function getKids()
    {
        return $this->kids;
    }

    /**
     * @return bool
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @return bool
     */
    public function isSalary()
    {
        return $this->salary;
    }

    /**
     * @return bool
     */
    public function isTax()
    {
        return $this->tax;
    }

    /**
     * @return int
     */
    public function byPercent()
    {
        return $this->percent;
    }

    /**
     * @return int
     */
    public function byMoney()
    {
        return $this->money;
    }

    /**
     * @return int
     */
    public function sign()
    {
        return $this->sign;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->rule_type;
    }

}