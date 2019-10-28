<?php


namespace App\Counters;


use App\Interfaces\RuleInterface;

abstract class AbstractCountBonusByRuleOption
{

    /**
     * @return float
     */
    public function count(){

        return 0.0;

    }

    /**
     * @param RuleInterface $Rule
     * @param float $countryTax
     * @param float $salary
     * @return float
     */
    public function recountBonusByRule(RuleInterface $Rule, float $countryTax, float $salary)
    {
        $result = 0.0;

        $value = 0.0;
        // If we need count bonus depending salary value
        if ($Rule->isSalary()) {

            // increase/decrease by money value
            if (abs($Rule->byMoney())) {
                $value= $Rule->sign() * $Rule->byMoney();
            }

            // increase/decrease by percent from current salary
            if (abs($Rule->byPercent())) {
                $value= $Rule->sign() * $salary * $Rule->byPercent() / 100;
            }
        }
        $result += $value;

        $value = 0.0;
        // If we need count bonus depending employer tax
        if ($Rule->isTax()) {

            // increase/decrease by percent from current tax payment
            // check if decreasing percent ($Rule->byPercent()) not greater then $countryTax
            // and if not - set bonus same as $countryTax
            if (abs($Rule->byPercent())) {
                if ($countryTax > $Rule->byPercent() ) {
                    $value = -$Rule->sign() * $salary * $Rule->byPercent() / 100;
                } else {
                    $value = -$Rule->sign() * $salary * $countryTax / 100;
                }
            }

            // increase/decrease by percent from current tax payment
            // check if $bonus is not larger then $taxPayment
            if (abs($Rule->byMoney())) {

                $taxPayment = -$Rule->sign() * $salary * $countryTax / 100;

                if ($taxPayment > $Rule->byMoney()) {
                    $value= -$Rule->sign() * $Rule->byMoney();
                } else {
                    $value = $taxPayment;
                }
            }

        }
        $result += $value;

        return $result;
    }

    /**
     * @param float $value1
     * @param float $value2
     * @return bool
     */
    public function ifValueGreaterThen(float $value1, float $value2)
    {
        if ($value2 <> 0) {
            if ($value1 > $value2) {
                return true;
            }
        }
        return false;
    }

}