<?php


namespace App\Interfaces;


use App\Entity\Rule;

interface OptionBuilderInterface
{
    /**
     * @return Rule[]
     */
    public function getRules():array ;

    /**
     * @return bool
     */
    public function getCheckAge():bool ;

    /**
     * @return bool
     */
    public function getCheckKids():bool ;

    /**
     * @return bool
     */
    public function getCheckCar():bool ;

}