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
        $this->assertEquals('For Sale', $prop1transformed['rent_or_buy']);
        $this->assertEquals('To Let', $prop2transformed['rent_or_buy']);
        $this->assertEquals($prop1toriginal['Refnumber'], $prop1transformed['ref_number']);
        $this->assertEquals($prop2toriginal['Refnumber'], $prop2transformed['ref_number']);
        /*
        <Number>4</Number>
    <Street>StoneyLands Road</Street>
    <Address3>Egham</Address3>
    <Address4>Surrey</Address4>
    <Postcode>TW20 9QR</Postcode>
    <Area>Egham</Area>
    <Tube></Tube>*/
    }
    // /** @test **/
    // public function we_should_be_able_to_create_an_issue_in_redmine()
    // {
    // }
}
