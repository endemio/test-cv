<?php


namespace App\Interfaces;


interface RuleBuilderInterface
{

    /**
     * @param float $age
     * @return RuleBuilderInterface
     */
    public function ageGreater(float $age);

    /**
     * @param int $kids
     * @return RuleBuilderInterface
     */
    public function kidsGreater(int $kids);

    /**
     * @return RuleBuilderInterface
     */
    public function carByCompany();

    /**
     * @return RuleBuilderInterface
     */
    public function salary();

    /**
     * @return RuleBuilderInterface
     */
    public function tax();

    /**
     * @param float $money
     * @return RuleBuilderInterface
     */
    public function money(float $money);

    /**
     * @param float $percent
     * @return RuleBuilderInterface
     */
    public function percent(float $percent);

    /**
     * @return RuleBuilderInterface
     */
    public function increase();

    /**
     * @return RuleBuilderInterface
     */
    public function decrease();
}