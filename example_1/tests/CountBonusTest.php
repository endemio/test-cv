<?php


namespace App\Tests;


use App\Builders\RuleBuilder;
use App\Counters\AbstractCountBonusByRuleOption;

use PHPUnit\Framework\TestCase;

class CountBonusTest extends TestCase
{

    protected $newAbstractCountBonusByRuleOption;

    protected function setUp(): void
    {

        $this->newAbstractCountBonusByRuleOption = new class extends AbstractCountBonusByRuleOption
        {
            public function returnThis()
            {
                return $this;
            }
        };
    }

    public function testCountBonusAbstract()
    {

        $this->assertInstanceOf(
            AbstractCountBonusByRuleOption::class,
            $this->newAbstractCountBonusByRuleOption->returnThis()
        );

        $this->assertEquals(0, $this->newAbstractCountBonusByRuleOption->count());

    }

    public function testCountBonusAbstractRecountBonusByRuleMath()
    {

        // Count increase/decrease values depending on salary/tax and money/percent
        $bonusForAges = 440;
        $this->assertEquals(
            $bonusForAges,
            $this->newAbstractCountBonusByRuleOption->recountBonusByRule(
                (new RuleBuilder())->ageGreater(50)->increase()->salary()->money($bonusForAges)->build(),
                50,
                5000));

        $bonusForAges = 400;
        $this->assertEquals(
            $bonusForAges,
            $this->newAbstractCountBonusByRuleOption->recountBonusByRule(
                (new RuleBuilder())->ageGreater(50)->increase()->salary()->percent(8)->build(),
                50,
                5000));

        $bonusForAges = 400;
        $this->assertEquals(
            $bonusForAges,
            $this->newAbstractCountBonusByRuleOption->recountBonusByRule(
                (new RuleBuilder())->ageGreater(50)->decrease()->tax()->percent(8)->build(),
                50,
                5000));


    }



}