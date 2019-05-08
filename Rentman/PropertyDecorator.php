<?php
namespace Rentman;

class PropertyDecorator
{
    protected $propertyData;
    protected $transformed = [];
    public function __construct()
    {
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
        $this->transformed['ref_number'] = $this->setValueByKey('Refnumber');
        $this->transformed['location'] = $this->setLocation();
        $this->transformed['type'] = $this->setType();
        $this->transformed['commercial'] = $this->setCommercialBoolean();
        $this->transformed['bedrooms'] = $this->setBedRooms();
        return $this->getTransformed();
    }

    public function setBedrooms()
    {
        $bedrooms = [
            'summary' => 'Studio Apartment',
            'bedrooms' => 0,
            'singles' =>  0,
            'doubles' => 0,
        ];
        if (isset($this->propertyData['Singles'])) {
            $bedrooms['singles'] = (int)$this->propertyData['Singles'];
        }
        if (isset($this->propertyData['Doubles'])) {
            $bedrooms['doubles'] = (int)$this->propertyData['Doubles'];
        }
        if ($this->propertyData['Beds'] > 0) {
            $bedrooms['summary'] = (int)$this->propertyData['Beds'].' Bedrooms';
            $bedrooms['bedrooms'] = (int)$this->propertyData['Beds'];
        }
        return $bedrooms;
    }

    public function setType()
    {
        return $this->propertyData['Type']['#text'] ?? '';
    }

    public function setCommercialBoolean()
    {
        $commercial = false;
        if (strtolower($this->propertyData['Type']['@Commercial']) == 'true') {
            return true;
        }
    }

    protected function setLocation()
    {
        return [
            'number' => $this->setValueByKey('Number'),
            'street' => $this->setValueByKey('Street'),
            'address3' => $this->setValueByKey('Address3'),
            'address4' => $this->setValueByKey('Address4'),
            'postcode' => $this->setValueByKey('Postcode'),
            'area' => $this->setValueByKey('Area'),
            'tube' => $this->setValueByKey('Tube'),
        ];
    }

    public function setValueByKey($key)
    {
        return $this->propertyData[$key] ?? '';
    }

    public function setRentOrBuy($val = null)
    {
        if (isset($this->propertyData['Rentorbuy'])) {
            $this->transformed['rent_or_buy'] = $this->getRentOrBuyValue($this->propertyData['Rentorbuy']);
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

    /**
     * Get the value of propertyData
     */
    public function getPropertyData()
    {
        return $this->propertyData;
    }

    /**
     * Set the value of propertyData
     *
     * @return  self
     */
    public function setPropertyData($propertyData)
    {
        $this->propertyData = $propertyData;

        return $this;
    }

    /**
     * Get the value of transformed
     */
    public function getTransformed()
    {
        return $this->transformed;
    }
}
