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
      
        foreach ($this->getParsedArrayData()['Properties']['Property'] as $property) {
            $transformed['properties'][] = (new PropertyDecorator($property))->decorate();
        }
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
}
