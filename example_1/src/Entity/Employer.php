<?php


namespace App\Entity;

use App\Interfaces\EmployerBuilderInterface;
use App\Interfaces\EmployerInterface;

class Employer implements EmployerInterface
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $age;

    /**
     * @var float
     */
    protected $salary;

    /**
     * @var int
     */
    protected $kids = 0;

    /**
     * @var bool
     */
    protected $car = false;

    public function __construct(EmployerBuilderInterface $employerBuilder)
    {
        $this->name = $employerBuilder->getName();

        $this->age = $employerBuilder->getAge();

        $this->salary = $employerBuilder->getSalary();

        $this->kids = $employerBuilder->getKids();

        $this->car = $employerBuilder->getCar();

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
     * @return int
     */
    public function getKids():int
    {
        return $this->kids;
    }

    /**
     * @return bool
     */
    public function getCar():bool
    {
        return $this->car;
    }

}