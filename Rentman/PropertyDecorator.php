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
        $this->transformed['baths'] = $this->setValueByKey('Baths');
        $this->transformed['receptions'] = $this->setValueByKey('Receps');
        $this->transformed['furnished'] = $this->setValueByKey('Furnished');
        $this->transformed['garage'] = $this->setValueByBooleanString('Garage');
        $this->transformed['parking'] = $this->setValueByBooleanString('Parking');
        $this->transformed['garden'] = $this->setValueByBooleanString('Garden');
        $this->transformed['balcony'] = $this->setValueByBooleanString('Balcony');
        $this->transformed['shower'] = $this->setValueByBooleanString('Shower');
        $this->transformed['sep_wc'] = $this->setValueByBooleanString('Sep_wc');
        $this->transformed['washing_machine'] = $this->setValueByBooleanString('Washmachine');
        $this->transformed['dishwasher'] = $this->setValueByBooleanString('Dishwasher');
        $this->transformed['burglar_alarm'] = $this->setValueByBooleanString('Burglaralarm');
        $this->transformed['pets_allowed'] = $this->setValueByBooleanString('Petsallowed');
        $this->transformed['smokers_allowed'] = $this->setValueByBooleanString('Smokersallowed');
        $this->transformed['floor'] = (int)$this->setValueByKey('Floor');
        $this->transformed['heating'] = $this->setValueByKey('Heating');
        $this->transformed['status'] = $this->setStatus();
        $this->transformed['let_by_us'] = $this->setLetBoolean();
        $this->transformed['sold_by_us'] = $this->setSoldBoolean();
        $this->transformed['available'] = $this->setValueByKey('Available');
        $this->transformed['service_charges'] = $this->setValueByKey('Servicecharges');
        $this->transformed['shared_comm'] = $this->setValueByKey('Sharedcomm');
        $this->transformed['lease_length'] = $this->setValueByKey('Leaselength');
        $this->transformed['shortlet'] = $this->setValueByBooleanString('Shortlet');
        $this->transformed['longlet'] = $this->setValueByBooleanString('Longlet');
        $this->transformed['student_year'] = $this->setValueByBooleanString('Studentyear');
        //<Sharedcomm></Sharedcomm>
        $this->transformed['dss_allowed'] = $this->setValueByBooleanString('Dssallowed');
        $this->transformed['price'] = $this->propertyData['Price']['#text'];
        $this->transformed['price_per'] = $this->propertyData['Price']['@Per'];
        $this->transformed['price_qualifier'] = priceQualifier($this->propertyData['Price']['@Qualifier']);
        
        $this->transformed['rent'] = $this->propertyData['Rent']['#text'];
        $this->transformed['rent_per'] = $this->propertyData['Rent']['@Period'];
        $this->transformed['rent_qualifier'] = priceQualifier($this->propertyData['Rent']['@Qualifier']);
        
        //<Rent Qualifier="1" Period="Month">2362</Rent>
        //<Saleprice></Saleprice>
        $this->transformed['tenant_fees'] = $this->setValueByKey('Tenantfees');
        
        
        

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
        if (strtolower($this->propertyData['Type']['@Commercial']) == 'true') {
            return true;
        }
        return false;
    }

    public function setStatus()
    {
        return $this->propertyData['Status']['#text'] ?? '';
    }

    public function setLetBoolean()
    {
        if (strtolower($this->propertyData['Status']['@LetByUs']) == 'true') {
            return true;
        }
        return false;
    }
    
    public function setSoldBoolean()
    {
        if (strtolower($this->propertyData['Status']['@SoldByUs']) == 'true') {
            return true;
        }
        return false;
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
    
    public function setValueByBooleanString($key)
    {
        if (isset($this->propertyData[$key])) {
            return convertBooleanString($this->propertyData[$key]);
        }
        return false;
    }

    public function setRentOrBuy($val = null)
    {
        if (isset($this->propertyData['Rentorbuy'])) {
            $this->transformed['rent_or_buy'] = getRentOrBuyValue($this->propertyData['Rentorbuy']);
        }
        
        return $this;
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
