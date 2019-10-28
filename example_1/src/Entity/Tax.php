<?php


namespace App\Entity;


use App\Interfaces\TaxInterface;
use InvalidArgumentException;

class Tax implements TaxInterface
{

    /**
     * @var float
     */
    protected $countryTax;

    /**
     * Tax constructor.
     * @param float $percent
     */
    public function __construct(float $percent)
    {
        if (!is_numeric($percent)){
            throw new InvalidArgumentException('Tax must be only number');
        } elseif (abs($percent) > 100){
            throw new InvalidArgumentException('Tax can be more then 100%');
        }

        $this->countryTax = abs($percent);
    }

    /**
     * @return float
     */
    public function getCountryTax()
    {
        return $this->countryTax;
    }
}