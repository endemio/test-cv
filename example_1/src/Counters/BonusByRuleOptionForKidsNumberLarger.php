<?php


namespace App\Counters;


use App\Interfaces\EmployerInterface;
use App\Interfaces\RuleInterface;
use App\Interfaces\TaxInterface;

class BonusByRuleOptionForKidsNumberLarger  extends AbstractCountBonusByRuleOption
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


    public function count()
    {
        $bonus = 0.0;


        $deltaKids = $this->employer->getKids() + 1;
        $indexKids = -1;

        /* @var $rule RuleInterface*/
        foreach ($this->rules as $index => $rule) {

            // Search for nearest bonus/deduction for kids, if there are several with same kids - takes last one
            if ($this->ifValueGreaterThen($this->employer->getKids(), $rule->getKids())) {
                if ($deltaKids >= $this->employer->getKids() - $rule->getKids()) {
                    $deltaKids = $this->employer->getKids() - $rule->getKids();
                    $indexKids = $index;
                }
            }
        }

        if ($indexKids > -1) {
            $rule = $this->rules[$indexKids];
            $bonus = $this->recountBonusByRule($rule,$this->tax->getCountryTax(),$this->employer->getSalary());
        }

        return $bonus;
    }

}