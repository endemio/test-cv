<?php


namespace App\Counters;


use App\Interfaces\EmployerInterface;
use App\Interfaces\RuleInterface;
use App\Interfaces\TaxInterface;

class BonusByRuleOptionForUsingCompanyCar  extends AbstractCountBonusByRuleOption
{

    /**
     * @var array
     */
    private $rules;

    /**
     * @var EmployerInterface
     */
    private $employer;

    /**
     * @var TaxInterface
     */
    private $tax;

    public function __construct(EmployerInterface $employer, TaxInterface $tax, array $rules)
    {
        $this->employer = $employer;

        $this->rules = $rules;

        $this->tax = $tax;
    }


    /**
     * @return float
     */
    public function count()
    {
        $bonus = 0.0;

        $indexCar = -1;

        /* @var $rule RuleInterface*/
        foreach ($this->rules as $index => $rule) {

            // Search for latest bonus/deduction for using company car
            if ($this->employer->getCar()) {
                $indexCar = $index;
            }
        }

        if ($indexCar > -1) {
            $rule = $this->rules[$indexCar];
            $bonus = $this->recountBonusByRule($rule,$this->tax->getCountryTax(),$this->employer->getSalary());
        }

        return $bonus;
    }

}