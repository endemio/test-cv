<?php


namespace App\Interfaces;


interface RuleInterface extends RuleTypeInterface
{

    /**
     * @return float
     */
    public function getAge();

    /**
     * @return int
     */
    public function getKids();

    /**
     * @return bool
     */
    public function getCar();

    /**
     * @return bool
     */
    public function isSalary();

    /**
     * @return bool
     */
    public function isTax();

    /**
     * @return float
     */
    public function byPercent();

    /**
     * @return float
     */
    public function byMoney();

    /**
     * @return int
     */
    public function sign();

    /**
     * @return string
     */
    public function getType();
}