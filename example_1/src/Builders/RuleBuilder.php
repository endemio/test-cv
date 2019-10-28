<?php


namespace App\Builders;


use App\Entity\Rule;
use App\Interfaces\RuleBuilderInterface;
use App\Interfaces\RuleInterface;
use App\Interfaces\RuleTypeInterface;
use InvalidArgumentException;

class RuleBuilder implements RuleBuilderInterface,RuleTypeInterface
{

    /**
     * @var float
     */
    public $age = 0;

    /**
     * @var int
     */
    public $kids = 0;

    /**
     * @var bool
     */
    public $car = false;

    /**
     * @var bool
     */
    public $salary = false;

    /**
     * @var bool
     */
    public $tax = false;

    /**
     * @var int
     */
    public $percent = 0;

    /**
     * @var int
     */
    public $money = 0;

    /**
     * @var int
     */
    public $sign = 0;

    /**
     * @var string
     */
    public $rule_type = '';

    public function __construct()
    {

    }

    /**
     * @param float $age
     * @return RuleBuilder
     */
    public function ageGreater(float $age)
    {
        if ($age < 0){
            throw new InvalidArgumentException('Age number can be only positive');
        }

        if ($this->kids >0 || $this->car){
            return $this;
        }

        $this->age = $age;

        $this->rule_type = $this::TYPE_AGE_GREATER;

        return $this;
    }

    /**
     * @param float $age
     * @return RuleBuilder
     */
    public function ageLower(float $age)
    {
        if ($age < 0){
            throw new InvalidArgumentException('Age number can be only positive');
        }

        if ($this->kids >0 || $this->car){
            return $this;
        }

        $this->age = $age;

        $this->rule_type = $this::TYPE_AGE_LOWER;

        return $this;
    }


    /**
     * @param int $kids
     * @return $this
     */
    public function kidsGreater(int $kids)
    {
        if ($this->age >0 || $this->car){
            return $this;
        }

        if ((int) $kids <> $kids) {
            throw new InvalidArgumentException('Kids number can be only integer');
        } elseif ($kids < 0){
            throw new InvalidArgumentException('Kids number can be only positive');
        }
        $this->kids = $kids;

        $this->rule_type = $this::TYPE_KIDS_NUMBER_GREATER;

        return $this;
    }

    /**
     * @return $this
     */
    public function carByCompany()
    {

        if ($this->kids >0 || $this->age > 0){
            return $this;
        }

        $this->car = true;

        $this->rule_type = $this::TYPE_CAR_COMPANY;

        return $this;
    }

    /**
     * @return $this
     */
    public function salary()
    {
        if (!$this->tax){
            $this->salary = true;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function tax()
    {

        if (!$this->salary) {
            $this->tax = true;
        }
        return $this;
    }

    /**
     * @param float $percent
     * @return $this
     */
    public function percent(float $percent)
    {
        if ($this->money == 0) {
            $this->percent = abs($percent);
        }
        return $this;
    }

    /**
     * @param float $money
     * @return $this
     */
    public function money(float $money)
    {
        if ($this->percent == 0) {
            $this->money = abs($money);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function increase()
    {
        if ($this->sign == 0) {
            $this->sign = 1;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function decrease()
    {
        if ($this->sign == 0) {
            $this->sign = -1;
        }
        return $this;
    }

    public function getType()
    {
        return $this->rule_type;
    }

    /**
     * @return RuleInterface
     */
    public function build()
    {
        return new Rule($this);
    }

}