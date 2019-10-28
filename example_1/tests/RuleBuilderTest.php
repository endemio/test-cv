<?php


namespace App\Tests;


use App\Builders\RuleBuilder;
use App\Entity\Rule;

use TypeError;
use InvalidArgumentException;

use PHPUnit\Framework\TestCase;

class RuleBuilderTest extends TestCase
{

    public function testBuildRuleInstance(){

        $ruleBuilder = new RuleBuilder();

        $rule = $ruleBuilder->build();

        $this->assertInstanceOf(Rule::class,$rule);

    }

    public function testBuildRuleInsertDataException(){

        $this->expectException(TypeError::class);
        (new RuleBuilder())->ageGreater('d');

        $this->expectException(TypeError::class);
        (new RuleBuilder())->ageLower('d');

        $this->expectException(TypeError::class);
        (new RuleBuilder())->kidsGreater('d');

        $this->expectException(InvalidArgumentException::class);
        (new RuleBuilder())->ageGreater(-1);

        $this->expectException(InvalidArgumentException::class);
        (new RuleBuilder())->ageLower(-1);

        $this->expectException(InvalidArgumentException::class);
        (new RuleBuilder())->kidsGreater(-1);

    }

    public function testBuildRuleValues(){

        $ruleBuilder = new RuleBuilder();

        // Check standard rule builder
        $rule = $ruleBuilder->kidsGreater(3)->increase()->salary()->money(500)->build();

        $this->assertEquals(3,$rule->getKids());
        $this->assertTrue($rule->isSalary());
        $this->assertFalse($rule->isTax());
        $this->assertEquals(500,$rule->byMoney());

    }

    public function testBuildRuleValuesWithDoubling(){

        $ruleBuilder = new RuleBuilder();

        // Check standard rule builder
        $rule = $ruleBuilder->kidsGreater(3)->increase()->decrease()->salary()->tax()->percent(5)->money(500)->build();

        $this->assertEquals(3,$rule->getKids());
        $this->assertEquals(1,$rule->sign());
        $this->assertTrue($rule->isSalary());
        $this->assertFalse($rule->isTax());
        $this->assertEquals(5,$rule->byPercent());
        $this->assertNotEquals(500,$rule->byMoney());

        $ruleBuilder = new RuleBuilder();

        // Check standard rule builder
        $rule = $ruleBuilder->kidsGreater(3)->ageLower(50)->decrease()->increase()->tax()->salary()->money(500)->percent(5)->build();

        $this->assertEquals(3,$rule->getKids());
        $this->assertEquals(0,$rule->getAge());
        $this->assertTrue($rule->isTax());
        $this->assertFalse($rule->isSalary());
        $this->assertEquals(500,$rule->byMoney());
        $this->assertNotEquals(5,$rule->byPercent());
    }

}