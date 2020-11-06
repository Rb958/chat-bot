<?php
namespace App\Utils\ClassGenerator;

class FunctionCodeBuilder
{

    private $visibility = "public";
    private $FunctionName;
    private $returnType = 'void';
    private $paramaters = [];
    private $body;

    public function build(){
        return "{$this->visibility} function {$this->FunctionName} ({$this->formatParameter()}): {$this->returnType}\n{\n\t{$this->body}\n}\n";
    }

    public function addParameter(string $name, string $type, bool $isRequired = true, ?string $defaultValue = null): self
    {
        $paramBuilder = new ParametersCodeBuilder();
        $this->paramaters[] = 
            $paramBuilder->setParamName($name)
            ->setParamtype($type)
            ->setIsOptional($isRequired)
            ->setDefautValue($defaultValue)
            ->build();
        return $this;
    }    

    /**
     * Get the value of visibility
     */ 
    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    /**
     * Set the value of visibility
     *
     * @return  self
     */ 
    public function setVisibility($visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get the value of FunctionName
     */ 
    public function getFunctionName(): ?string
    {
        return $this->FunctionName;
    }

    /**
     * Set the value of FunctionName
     *
     * @return  self
     */ 
    public function setFunctionName($functionName): self
    {
        $this->FunctionName = str_replace(' ', '', lcfirst(ucwords($functionName)));

        return $this;
    }

    /**
     * Get the value of returnType
     */ 
    public function getReturnType(): ?string
    {
        return $this->returnType;
    }

    /**
     * Set the value of returnType
     *
     * @return  self
     */ 
    public function setReturnType(?string $returnType): self
    {
        $this->returnType = $returnType;

        return $this;
    }

    /**
     * Get the value of body
     */ 
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Set the value of body
     *
     * @return  self
     */ 
    public function setBody($body): self
    {
        $this->body = $body;

        return $this;
    }

    public function formatParameter(): string
    {
        return implode(",", $this->paramaters);
    }


    /**
     * Get the value of paramaters
     */ 
    public function getParamaters(): ?array
    {
        return $this->paramaters;
    }
}