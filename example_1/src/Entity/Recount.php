<?php


namespace App\Entity;


use App\Counters\BonusByRuleOptionForAgeGreaterRule;
use App\Counters\BonusByRuleOptionForAgeLowerRule;
use App\Counters\BonusByRuleOptionForKidsNumberLarger;
use App\Counters\BonusByRuleOptionForKidsNumberLower;
use App\Counters\BonusByRuleOptionForUsingCompanyCar;
use App\Interfaces\OptionInterface;
use App\Interfaces\EmployerInterface;
use App\Interfaces\RuleTypeInterface;
use App\Interfaces\TaxInterface;


class Recount implements RuleTypeInterface
{

    /**
     * @var EmployerInterface
     */
    private $employer;

    /**
     * @var TaxInterface
     */
    private $tax;

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var bool
     */
    protected $checkAge = false;

    /**
     * @var bool
     */
    protected $checkKids = false;

    /**
     * @var bool
     */
    protected $checkCar = false;


    /**
     * @var float
     */
    private $bonus=0;


    public function __construct(EmployerInterface $employer, TaxInterface $tax, OptionInterface $bonusCheck)
    {

        $this->employer = $employer;

        $this->tax = $tax;

        $this->checkAge = $bonusCheck->getCheckAge();

        $this->checkCar = $bonusCheck->getCheckCar();

        $this->checkKids = $bonusCheck->getCheckKids();

        $this->rules = $bonusCheck->getRules();
    }

    /**
     * @return float
     */
    public function getSummary()
    {
        echo PHP_EOL. 'Start bonus is '.$this->bonus.' for '.$this->employer->getName().PHP_EOL;

        return $this->existsCheck()->bonus;
    }

    /**
     *  Builder for all exists bonus calculators
     */
    private function existsCheck(){

        echo '+'.str_pad( '', 20,'-',STR_PAD_BOTH) .'+'. str_pad( '', 10,'-',STR_PAD_BOTH )."+\n";

        echo '|'.str_pad( 'Rule type', 20,' ',STR_PAD_BOTH) .'|'. str_pad( 'Value', 10,' ',STR_PAD_BOTH )."|\n";

        echo '+'.str_pad( '', 20,'-',STR_PAD_BOTH) .'+'. str_pad( '', 10,'-',STR_PAD_BOTH )."+\n";

        $this
            ->recountBonusForAgeGreaterRule()
            ->recountBonusForAgeLowerRule()
            ->recountBonusForKidsNumberLargerRule()
            ->recountBonusForKidsNumberLowerRule()
            ->recountBonusForUsingCompanyCarRule();

        echo '+'.str_pad( '', 20,'-',STR_PAD_BOTH) .'+'. str_pad( '', 10,'-',STR_PAD_BOTH )."+\n";

        echo '|'.str_pad( 'Summary', 20,' ',STR_PAD_BOTH) .'|'. str_pad( $this->bonus, 10,' ', STR_PAD_LEFT)."|\n";

        echo '+'.str_pad( '', 20,'-',STR_PAD_BOTH) .'+'. str_pad( '', 10,'-',STR_PAD_BOTH )."+\n";

        return $this;

    }

    /**
     * @return $this
     */
    private function recountBonusForAgeGreaterRule(){

        $ruleIndex = $this::TYPE_AGE_GREATER;

        if (!in_array($ruleIndex,array_keys($this->rules)) || !$this->checkAge){
            echo '|'.str_pad( $ruleIndex, 20 ) .'|'. str_pad( 0, 20 )."|\n";
            return $this;
        }

        $bonus = (new BonusByRuleOptionForAgeGreaterRule($this->employer,$this->tax,$this->rules[$ruleIndex]))->count();

        $this->bonus += $bonus;

        echo '|'.str_pad( $ruleIndex, 20,' ',STR_PAD_LEFT) .'|'. str_pad( $bonus, 10,' ',STR_PAD_LEFT )."|\n";

        return $this;
    }

    /**
     * @return $this
     */
    private function recountBonusForAgeLowerRule(){

        $ruleIndex = $this::TYPE_AGE_LOWER;

        if (!in_array($ruleIndex,array_keys($this->rules)) || !$this->checkAge){
            return $this;
        }

        $bonus = (new BonusByRuleOptionForAgeLowerRule($this->employer,$this->tax,$this->rules[$ruleIndex]))->count();

        $this->bonus += $bonus;

        echo '|'.str_pad( $ruleIndex, 20,' ',STR_PAD_LEFT) .'|'. str_pad( $bonus, 10,' ',STR_PAD_LEFT )."|\n";

        return $this;

    }


    /**
     * @return $this
     */
    private function recountBonusForKidsNumberLargerRule(){

        $ruleIndex = $this::TYPE_KIDS_NUMBER_GREATER;

        if (!in_array($ruleIndex,array_keys($this->rules)) || !$this->checkKids){
            return $this;
        }

        $bonus = (new BonusByRuleOptionForKidsNumberLarger($this->employer,$this->tax,$this->rules[$ruleIndex]))->count();

        $this->bonus += $bonus;

        echo '|'.str_pad( $ruleIndex, 20,' ',STR_PAD_LEFT) .'|'. str_pad( $bonus, 10,' ',STR_PAD_LEFT )."|\n";

        return $this;

    }

    /**
     * @return $this
     */
    private function recountBonusForKidsNumberLowerRule(){

        $ruleIndex = $this::TYPE_KIDS_NUMBER_LOWER;

        if (!in_array($ruleIndex,array_keys($this->rules)) || !$this->checkKids){
            return $this;
        }

        $bonus = (new BonusByRuleOptionForKidsNumberLower($this->employer,$this->tax,$this->rules[$ruleIndex]))->count();

        $this->bonus += $bonus;

        echo '|'.str_pad( $ruleIndex, 20,' ',STR_PAD_LEFT) .'|'. str_pad( $bonus, 10,' ',STR_PAD_LEFT )."|\n";

        return $this;
    }

    /**
     * @return $this
     */
    private function recountBonusForUsingCompanyCarRule(){

        $ruleIndex = $this::TYPE_CAR_COMPANY;

        if (!in_array($ruleIndex,array_keys($this->rules)) || !$this->checkCar){
            return $this;
        }

        $bonus = (new BonusByRuleOptionForUsingCompanyCar($this->employer,$this->tax,$this->rules[$ruleIndex]))->count();

        $this->bonus += $bonus;

        echo '|'.str_pad( $ruleIndex, 20,' ',STR_PAD_LEFT) .'|'. str_pad( $bonus, 10,' ',STR_PAD_LEFT )."|\n";

        return $this;
    }

}