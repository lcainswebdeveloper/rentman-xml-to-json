<?php
use PHPUnit\Framework\TestCase;
use Rentman\Rentman;

final class PropertyParseTest extends TestCase
{
    /** @test **/
    public function we_should_be_able_to_parse_rentman_xml()
    {
        $rentman = new Rentman(__DIR__.'/rentman.xml');
        
        $this->assertTrue(is_array($rentman->getParsedArrayData()));
        $transformed = $rentman->buildTransformedDataArray();
        $properties = $transformed['properties'];

        foreach ($rentman->getParsedArrayData()['Properties']['Property'] as $key => $property) {
            $propertyTransformed = $properties[$key];
            prepr($propertyTransformed);
            $this->assertEquals(getRentOrBuyValue($property['Rentorbuy']), $propertyTransformed['rent_or_buy']);
            $this->assertEquals($property['Refnumber'], $propertyTransformed['ref_number']);
            $location = [
                'number' => $property['Number'],
                'street' => $property['Street'],
                'address3' => $property['Address3'],
                'address4' => $property['Address4'],
                'postcode' => $property['Postcode'],
                'area' => $property['Area'],
                'tube' => $property['Tube'],
            ];
            $this->assertEquals($propertyTransformed['location'], $location);
            $this->assertEquals($propertyTransformed['commercial'], convertBooleanString($property['Type']['@Commercial']));
            $this->assertEquals($propertyTransformed['type'], $property['Type']['#text']);
            
            // $bedrooms = [
            //     'summary' => 'Studio Apartment',
            //     'bedrooms' => 0,
            //     'singles' => 0,
            //     'doubles' => 0,
            // ];


            // $this->assertEquals($propertyTransformed['bedrooms'], $bedrooms);
            $this->assertEquals($propertyTransformed['baths'], $property['Baths']);
            $this->assertEquals($propertyTransformed['receptions'], $property['Receps']);
            $this->assertEquals($propertyTransformed['furnished'], $property['Furnished']);
            $this->assertEquals($propertyTransformed['garage'], convertBooleanString($property['Garage']));
            $this->assertEquals($propertyTransformed['parking'], convertBooleanString($property['Parking']));
            $this->assertEquals($propertyTransformed['garden'], convertBooleanString($property['Garden']));
            $this->assertEquals($propertyTransformed['balcony'], convertBooleanString($property['Balcony']));
            $this->assertEquals($propertyTransformed['shower'], convertBooleanString($property['Shower']));
            $this->assertEquals($propertyTransformed['sep_wc'], convertBooleanString($property['Sep_wc']));
            $this->assertEquals($propertyTransformed['washing_machine'], convertBooleanString($property['Washmachine']));
            $this->assertEquals($propertyTransformed['dishwasher'], convertBooleanString($property['Dishwasher']));
            $this->assertEquals($propertyTransformed['burglar_alarm'], convertBooleanString($property['Burglaralarm']));
            $this->assertEquals($propertyTransformed['pets_allowed'], convertBooleanString($property['Petsallowed']));
            $this->assertEquals($propertyTransformed['smokers_allowed'], convertBooleanString($property['Smokersallowed']));

            
            $this->assertEquals($propertyTransformed['heating'], $property['Heating']);
            
            $this->assertEquals($propertyTransformed['available'], $property['Available']);
            
            $this->assertEquals($propertyTransformed['lease_length'], $property['Leaselength']);
            
            $this->assertEquals($propertyTransformed['shortlet'], convertBooleanString($property['Shortlet']));
            $this->assertEquals($propertyTransformed['longlet'], convertBooleanString($property['Longlet']));
            $this->assertEquals($propertyTransformed['student_year'], convertBooleanString($property['Studentyear']));

            
            $this->assertEquals($propertyTransformed['dss_allowed'], convertBooleanString($property['Dssallowed']));
            
            $this->assertEquals($propertyTransformed['tennant_fees'], $property['Tenantfees']);
        }
    }
}
