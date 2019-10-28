<?php


namespace App\Counters;

use App\Interfaces\EmployerInterface;
use App\Interfaces\RuleInterface;
use App\Interfaces\TaxInterface;

class BonusByRuleOptionForAgeLowerRule extends AbstractCountBonusByRuleOption
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

        $deltaAge = -1000;
        $indexAge = -1;

        /* @var $rule RuleInterface*/
        foreach ($this->rules as $index => $rule) {

            // Search for nearest bonus/deduction for age, if there are several with same age - takes last one
            if ($this->ifValueGreaterThen($rule->getAge(),$this->employer->getAge())) {
                if ($deltaAge <= $this->employer->getAge() - $rule->getAge()) {
                    $deltaAge = $this->employer->getAge() - $rule->getAge();
                    $indexAge = $index;
                }
            }
        }

        if ($indexAge > -1) {
            $rule = $this->rules[$indexAge];
            $bonus = $this->recountBonusByRule($rule,$this->tax->getCountryTax(),$this->employer->getSalary());
        }

        return $bonus;

    }
}