<?php
namespace Rentman;

class PropertyDecorator
{
    protected $propertyData;
    public function __construct($propertyData)
    {
        $this->propertyData = $propertyData;
    }

    public function decorate()
    {
        //             [Refnumber] => 1.00
        //             [Number] => 5
        //             [Street] => North Street
        //             [Address3] => Egham
        //             [Address4] => Surrey
        //             [Postcode] => TW20 9RP
        //             [Area] => Egham
        //             [Tube] =>
        $this->setRentorBuy();
        return $this->propertyData;
    }

    public function setRentOrBuy($val = null)
    {
        //$this->propertyData['Rentorbuy'] = 'N/A';
        if (isset($this->propertyData['Rentorbuy'])) {
            $this->propertyData['Rentorbuy'] = $this->getRentOrBuyValue($this->propertyData['Rentorbuy']);
        }
        
        return $this;
    }

    public function getRentOrBuyValue($value)
    {
        $values = [
            1 => 'To Let',
            2 => 'For Sale',
            3 => 'For Sale and To Let',
        ];
        return $values[(int)$value] ?? 'Unknown';
    }
}
