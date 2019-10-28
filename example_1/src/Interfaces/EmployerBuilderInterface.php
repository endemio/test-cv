<?php


namespace App\Interfaces;


interface EmployerBuilderInterface
{

    /**
     * @return float
     */
    public function getSalary():float ;

    /**
     * @return float
     */
    public function getAge():float ;

    /**
     * @return int
     */
    public function getKids():int ;

    /**
     * @return bool
     */
    public function getCar():bool ;

    /**
     * @return string
     */
    public function getName():string ;

}
