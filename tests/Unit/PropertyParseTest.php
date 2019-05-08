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
        //['Rentorbuy']
        $prop1 = $properties[0];
        $prop2 = $properties[1];
        $this->assertEquals('For Sale', $prop1['Rentorbuy']);
        $this->assertEquals('To Let', $prop2['Rentorbuy']);
        prepr($prop2['Rentorbuy']);
        //$prop2 = $properties[1];
        $this->assertTrue(true);
    }
    // /** @test **/
    // public function we_should_be_able_to_create_an_issue_in_redmine()
    // {
    // }
}
