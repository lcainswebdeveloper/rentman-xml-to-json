<?php
namespace Rentman;

use Rentman\PropertyDecorator;
use Nathanmac\Utilities\Parser\Parser;

class Rentman
{
    protected $pathtoRentmanXmlFile;
    protected $xmlFilepathIsValid;
    protected $parsedArrayData = [];
    protected $transformedData = [];
    protected $errors = [];
    protected $amenities = [];
    protected $areas = [];
    protected $categories = [];
    public function __construct($pathtoRentmanXmlFile)
    {
        $this->setPathtoRentmanXmlFile($pathtoRentmanXmlFile);
        $this->setXmlFilepathIsValid();
        $this->parseToArray();
    }

    public function parseToArray()
    {
        if (!$this->getXmlFilepathIsValid()) {
            $this->addError('The path to your XML file is incorrect.');
        } else {
            $parser = new Parser();
            $this->setParsedArrayData($parser->xml(file_get_contents($this->getPathtoRentmanXmlFile())));
        }
        return $this;
    }

    /**
     *
     */
    public function buildTransformedDataArray()
    {
        $transformed = [
            'properties' => []
        ];
        
        $this->setAmenities();
        $this->setAreas();
        $this->setCategories();
        foreach ($this->getParsedArrayData()['Properties']['Property'] as $property) {
            $decorator = new PropertyDecorator();
            $decorator->setPropertyData($property);
            $transformed['properties'][] = $decorator->decorate($this->getCategories(), $this->getAmenities(), $this->getAreas());
        }
        $foo = usort($transformed['properties'], function ($a, $b) {
            $t1 = strtotime($a['created']);
            $t2 = strtotime($b['created']);
            return $t1 - $t2;
        });
        return $transformed;
    }
    /**
     * Get the value of pathtoRentmanXmlFile
     */
    public function getPathtoRentmanXmlFile()
    {
        return $this->pathtoRentmanXmlFile;
    }

    /**
     * Set the value of pathtoRentmanXmlFile
     *
     * @return  self
     */
    public function setPathtoRentmanXmlFile($pathtoRentmanXmlFile)
    {
        $this->pathtoRentmanXmlFile = $pathtoRentmanXmlFile;

        return $this;
    }

    /**
     * Get the value of xmlFilepathIsValid
     */
    public function getXmlFilepathIsValid()
    {
        return $this->xmlFilepathIsValid;
    }

    /**
     * Set the value of xmlFilepathIsValid
     *
     * @return  self
     */
    public function setXmlFilepathIsValid()
    {
        $this->xmlFilepathIsValid = file_exists($this->getPathtoRentmanXmlFile());

        return $this;
    }

    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set the value of errors
     *
     * @return  self
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Add to errors
     *
     * @return  self
     */
    public function addError($error)
    {
        $this->errors[] = $error;

        return $this;
    }

    /**
     * Get the value of parsedArrayData
     */
    public function getParsedArrayData()
    {
        return $this->parsedArrayData;
    }

    /**
     * Set the value of parsedArrayData
     *
     * @return  self
     */
    public function setParsedArrayData($parsedArrayData)
    {
        $this->parsedArrayData = $parsedArrayData;

        return $this;
    }

    /**
     * Get the value of amenities
     */
    public function getAmenities()
    {
        return $this->amenities;
    }

    /**
     * Set the value of amenities
     *
     * @return  self
     */
    public function setAmenities()
    {
        $amenities = [];
        if (isset($this->getParsedArrayData()['Amenities'])) {
            if (isset($this->getParsedArrayData()['Amenities']['Amenity'])) {
                foreach ($this->getParsedArrayData()['Amenities']['Amenity'] as $key => $amenity) {
                    $amenities[] = array_change_key_case($amenity, CASE_LOWER);
                }
            }
        }
        $this->amenities = $amenities;

        return $this;
    }

    /**
     * Get the value of areas
     */
    public function getAreas()
    {
        return $this->areas;
    }

    /**
     * Set the value of areas
     *
     * @return  self
     */
    public function setAreas()
    {
        $areas = [];
        if (isset($this->getParsedArrayData()['Areas'])) {
            if (isset($this->getParsedArrayData()['Areas']['Area'])) {
                foreach ($this->getParsedArrayData()['Areas']['Area'] as $area) {
                    $areas[] = $area['Name'];
                }
            }
        }
        $this->areas = $areas;

        return $this;
    }

    /**
     * Get the value of categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set the value of categories
     *
     * @return  self
     */
    public function setCategories()
    {
        $categories = [];
        if (isset($this->getParsedArrayData()['Categories'])) {
            if (isset($this->getParsedArrayData()['Categories']['Category'])) {
                foreach ($this->getParsedArrayData()['Categories']['Category'] as $key => $category) {
                    $parsed = array_change_key_case($category, CASE_LOWER);
                    $categories[(int)$parsed['id']] = $parsed['name'];
                }
            }
        }
        $this->categories = $categories;

        return $this;
    }
}
