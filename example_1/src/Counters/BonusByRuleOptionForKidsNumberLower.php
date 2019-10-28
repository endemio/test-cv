<?php


namespace App\Counters;


use App\Interfaces\EmployerInterface;
use App\Interfaces\TaxInterface;

class BonusByRuleOptionForKidsNumberLower  extends AbstractCountBonusByRuleOption
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

        //todo: create

        return $bonus;
    }

}