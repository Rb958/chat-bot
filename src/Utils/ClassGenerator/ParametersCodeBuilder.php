<?php
namespace App\Utils\ClassGenerator;

use Exception;

class ParametersCodeBuilder
{
    private $paramName;
    private $Paramtype;
    private $isOptional = false;
    private $defautValue;
    
    public function build(): string{
        $param = '';
        
        if(trim($this->paramName)!= ''){
            
            $type = '';
            
            if(trim($this->Paramtype) != null){
                $type = $this->Paramtype;
            }

            $param .= ($type != '')? $type ." " : '';
            $param .= "\$". $this->paramName;
            $param .= ($this->isOptional and trim($this->defautValue) != null and trim($this->defautValue) != '')? " = ".$this->defautValue : '';
            
        }else{
            throw new Exception("Parameter name is required");
        }
        
        return $param;
    }
    
    /**
    * Get the value of paramName
    */ 
    public function getParamName(): ?string
    {
        return $this->paramName;
    }
    
    /**
    * Set the value of paramName
    *
    * @return  self
    */ 
    public function setParamName(string $paramName)
    {
        $this->paramName = $paramName;
        
        return $this;
    }
    
    /**
    * Get the value of Paramtype
    */ 
    public function getParamtype(): ?string
    {
        return $this->Paramtype;
    }
    
    /**
    * Set the value of Paramtype
    *
    * @return  self
    */ 
    public function setParamtype(string $Paramtype)
    {
        $this->Paramtype = $Paramtype;
        
        return $this;
    }
    
    /**
    * Get the value of isOptional
    */ 
    public function getIsOptional(): bool
    {
        return $this->isOptional;
    }
    
    /**
    * Set the value of isOptional
    *
    * @return  self
    */ 
    public function setIsOptional(bool $isOptional)
    {
        $this->isOptional = $isOptional;
        
        return $this;
    }

    /**
     * Get the value of defautValue
     */ 
    public function getDefautValue()
    {
        return $this->defautValue;
    }

    /**
     * Set the value of defautValue
     *
     * @return  self
     */ 
    public function setDefautValue($defautValue)
    {
        $this->defautValue = $defautValue;

        return $this;
    }
}