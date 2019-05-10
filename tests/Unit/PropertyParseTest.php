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
        // prepr($rentman->getParsedArrayData());
        // exit();
        $prop1toriginal = $rentman->getParsedArrayData()['Properties']['Property'][0];
        $prop2toriginal = $rentman->getParsedArrayData()['Properties']['Property'][1];
        
        $prop1transformed = $properties[0];
        $prop2transformed = $properties[1];
        $this->assertEquals('To Let', $prop1transformed['rent_or_buy']);
        $this->assertEquals('To Let', $prop2transformed['rent_or_buy']);
        $this->assertEquals($prop1toriginal['Refnumber'], $prop1transformed['ref_number']);
        $this->assertEquals($prop2toriginal['Refnumber'], $prop2transformed['ref_number']);
        $location = [
            'number' => $prop1toriginal['Number'],
            'street' => $prop1toriginal['Street'],
            'address3' => $prop1toriginal['Address3'],
            'address4' => $prop1toriginal['Address4'],
            'postcode' => $prop1toriginal['Postcode'],
            'area' => $prop1toriginal['Area'],
            'tube' => $prop1toriginal['Tube'],
        ];
        $location2 = [
            'number' => $prop2toriginal['Number'],
            'street' => $prop2toriginal['Street'],
            'address3' => $prop2toriginal['Address3'],
            'address4' => $prop2toriginal['Address4'],
            'postcode' => $prop2toriginal['Postcode'],
            'area' => $prop2toriginal['Area'],
            'tube' => $prop2toriginal['Tube'],
        ];

        $this->assertEquals($prop1transformed['location'], $location);
        $this->assertEquals($prop2transformed['location'], $location2);
        
        $this->assertEquals($prop1transformed['commercial'], false);
        $this->assertEquals($prop2transformed['commercial'], true);
        $this->assertEquals($prop1transformed['type'], 'Terrace');
        $this->assertEquals($prop2transformed['type'], 'Flat');

        $bedrooms = [
            'summary' => 'Studio Apartment',
            'bedrooms' => 0,
            'singles' => 0,
            'doubles' => 0,
        ];

        $bedrooms2 = [
            'summary' => '9 Bedrooms',
            'bedrooms' => 9,
            'singles' => 0,
            'doubles' => 9,
        ];

        $this->assertEquals($prop1transformed['bedrooms'], $bedrooms);
        $this->assertEquals($prop2transformed['bedrooms'], $bedrooms2);

        $this->assertEquals($prop1transformed['baths'], $prop1toriginal['Baths']);
        $this->assertEquals($prop1transformed['receptions'], $prop1toriginal['Receps']);
        $this->assertEquals($prop1transformed['furnished'], $prop1toriginal['Furnished']);
        $this->assertEquals($prop1transformed['garage'], convertBooleanString($prop1toriginal['Garage']));
        $this->assertEquals($prop1transformed['parking'], convertBooleanString($prop1toriginal['Parking']));
        $this->assertEquals($prop1transformed['garden'], convertBooleanString($prop1toriginal['Garden']));
        $this->assertEquals($prop1transformed['balcony'], convertBooleanString($prop1toriginal['Balcony']));
        $this->assertEquals($prop1transformed['shower'], convertBooleanString($prop1toriginal['Shower']));
        $this->assertEquals($prop1transformed['sep_wc'], convertBooleanString($prop1toriginal['Sep_wc']));
        $this->assertEquals($prop1transformed['washing_machine'], convertBooleanString($prop1toriginal['Washmachine']));
        $this->assertEquals($prop1transformed['dishwasher'], convertBooleanString($prop1toriginal['Dishwasher']));
        $this->assertEquals($prop1transformed['burglar_alarm'], convertBooleanString($prop1toriginal['Burglaralarm']));
        $this->assertEquals($prop1transformed['pets_allowed'], convertBooleanString($prop1toriginal['Petsallowed']));
        $this->assertEquals($prop1transformed['smokers_allowed'], convertBooleanString($prop1toriginal['Smokersallowed']));

        $this->assertEquals($prop2transformed['baths'], $prop2toriginal['Baths']);
        $this->assertEquals($prop2transformed['receptions'], $prop2toriginal['Receps']);
        $this->assertEquals($prop2transformed['furnished'], $prop2toriginal['Furnished']);
        $this->assertEquals($prop2transformed['garage'], convertBooleanString($prop2toriginal['Garage']));
        $this->assertEquals($prop2transformed['parking'], convertBooleanString($prop2toriginal['Parking']));
        $this->assertEquals($prop2transformed['garden'], convertBooleanString($prop2toriginal['Garden']));
        $this->assertEquals($prop2transformed['balcony'], convertBooleanString($prop2toriginal['Balcony']));
        $this->assertEquals($prop2transformed['shower'], convertBooleanString($prop2toriginal['Shower']));
        $this->assertEquals($prop2transformed['sep_wc'], convertBooleanString($prop2toriginal['Sep_wc']));
        $this->assertEquals($prop2transformed['washing_machine'], convertBooleanString($prop2toriginal['Washmachine']));
        $this->assertEquals($prop2transformed['dishwasher'], convertBooleanString($prop2toriginal['Dishwasher']));
        $this->assertEquals($prop2transformed['burglar_alarm'], convertBooleanString($prop2toriginal['Burglaralarm']));
        $this->assertEquals($prop2transformed['pets_allowed'], convertBooleanString($prop2toriginal['Petsallowed']));
        $this->assertEquals($prop2transformed['smokers_allowed'], convertBooleanString($prop2toriginal['Smokersallowed']));

        $this->assertEquals($prop1transformed['heating'], $prop1toriginal['Heating']);
        $this->assertEquals($prop2transformed['heating'], $prop2toriginal['Heating']);

        $this->assertEquals($prop1transformed['available'], $prop1toriginal['Available']);
        $this->assertEquals($prop2transformed['available'], $prop2toriginal['Available']);

        $this->assertEquals($prop1transformed['lease_length'], $prop1toriginal['Leaselength']);
        $this->assertEquals($prop2transformed['lease_length'], $prop2toriginal['Leaselength']);
        
        $this->assertEquals($prop1transformed['shortlet'], convertBooleanString($prop1toriginal['Shortlet']));
        $this->assertEquals($prop1transformed['longlet'], convertBooleanString($prop1toriginal['Longlet']));
        $this->assertEquals($prop1transformed['student_year'], convertBooleanString($prop1toriginal['Studentyear']));

        $this->assertEquals($prop2transformed['shortlet'], convertBooleanString($prop2toriginal['Shortlet']));
        $this->assertEquals($prop2transformed['longlet'], convertBooleanString($prop2toriginal['Longlet']));
        $this->assertEquals($prop2transformed['student_year'], convertBooleanString($prop2toriginal['Studentyear']));
    }
}
