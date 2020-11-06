<?php
namespace App\Utils\ClassGenerator;

class PropertyCodeBuilder
{
    private $visibility = "private";
    private $propertyName;
    private $defaultValue = null;

    public function render(){
        return "\t{$this->formatedVisibility()} \${$this->propertyName}{$this->formatedDefaultValue()};";
    }

    /**
     * Get the value of defaultValue
     */ 
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Set the value of defaultValue
     *
     * @return  self
     */ 
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    private function formatedDefaultValue(){
        return ($this->defaultValue != null)? " = ". $this->defaultValue : '';
    }

    /**
     * Get the value of propertyName
     */ 
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * Set the value of propertyName
     *
     * @return  self
     */ 
    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;

        return $this;
    }

    public function formatedVisibility(){
        return ($this->visibility == null)? 'private' : $this->visibility;
    }

    /**
     * Get the value of visibility
     */ 
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set the value of visibility
     *
     * @return  self
     */ 
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }
}