<?php


namespace App\Builders;


use App\Entity\Employer;
use App\Interfaces\EmployerBuilderInterface;
use InvalidArgumentException;

class EmployerBuilder implements EmployerBuilderInterface
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $age;

    /**
     * @var float
     */
    private $salary;

    /**
     * @var int
     */
    private $kids = 0;

    /**
     * @var bool
     */
    private $car = false;

    public function __construct(string $name, float $age, float $salary)
    {

        $this->name = $name;

        if (!is_numeric($age)){
            throw new InvalidArgumentException('Age must be only number');
        } elseif ($age < 0){
            throw new InvalidArgumentException('Age cannot be less 0');
        }

        $this->age = $age;

        if (!is_numeric($salary)){
            throw new InvalidArgumentException('Salary must be only number');
        } elseif ($salary < 0){
            throw new InvalidArgumentException('Salary cannot be less 0');
        }

        $this->salary = $salary;

    }

    /**
     * @param int $kids
     * @return $this
     */
    public function addKids(int $kids)
    {

        if (!is_int($kids)){
            throw new InvalidArgumentException('Kids number must be only integer');
        } elseif ($kids < 0){
            throw new InvalidArgumentException('Kids number cannot be less 0');
        }

        $this->kids = $kids;
        return $this;
    }

    /**
     * @return int
     */
    public function getKids():int
    {
        return $this->kids;
    }

    /**
     * @return $this
     */
    public function addCar()
    {
        $this->car = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function getCar():bool
    {
        return $this->car;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getAge():float
    {
        return $this->age;
    }

    /**
     * @return float
     */
    public function getSalary():float
    {
        return $this->salary;
    }

    /**
     * @return Employer
     */
    public function build()
    {
        return new Employer($this);
    }
}