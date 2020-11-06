<?php
namespace App\Utils\ClassGenerator;

use ReflectionClass;

class ClassCodeBuilder
{
    private $classname;
    private $classeNameExtended;
    private $namespace;
    private $classProperties = [];
    private $implementedInterfaces = [];
    private $functions = [];
    private $imports = [];

    public function render(){
        return "<?php\nnamespace {$this->namespace};\n\n\n{$this->formatedImports()};\n\n\nclass {$this->classname} {$this->getExtendedClass()} {$this->getImplementedInterfaces()}\n{\n\t{$this->formatedProperties()}\n\n{$this->formatedFunctions()}}";
    }

    /**
     * Get the value of classname
     */ 
    public function getClassname(): ?string
    {
        return $this->classname;
    }

    /**
     * Set the value of classname
     *
     * @return  self
     */ 
    public function setClassname($classname): self
    {
        $this->classname = ucfirst(str_replace(' ', '', ucwords($classname)));
    
        // $reflect = new ReflectionClass($classname);

        // $this->namespace = 'money'; #$reflect->getNamespaceName();

        return $this;
    }

    /**
     * Get the value of classeNameExtended
     */ 
    public function getClasseNameExtended(): ?string
    {
        return $this->classeNameExtended;
    }

    /**
     * Set the value of classeNameExtended
     *
     * @return  self
     */ 
    public function setClasseNameExtended($classeNameExtended): self
    {
        // $reflect = new ReflectionClass($classeNameExtended);
        
        // $this->addImport($reflect->getNamespaceName);

        $this->classeNameExtended = $classeNameExtended;

        return $this;
    }

    /**
     * Get the value of functions
     */ 
    public function getFunctions(): ?array
    {
        return $this->functions;
    }

    /**
     * Set the value of functions
     *
     * @return  self
     */ 
    public function addFunction(FunctionCodeBuilder $function): self
    {
        $function = $function->build();

        if(!in_array($function, $this->functions)){

            $this->functions[] = $function;

        }

        return $this;
    }

    

    public function formatedImports(): ?string
    {
        return implode(";\n",$this->imports);
    }

    /**
     * Get the value of imports
     */ 
    public function getImports(): ?array
    {
        return $this->imports;
    }

    /**
     * Set the value of imports
     *
     * @return  self
     */ 
    public function addImport(string $import): self
    {
        if(!in_array($import, $this->imports)){
            $this->imports[] = "use ".$import;
        }

        return $this;
    }

    public function addImplementedInterface($interface): self
    {
        if(!in_array($interface, $this->implementedInterfaces)){
            $this->implementedInterfaces[] = $interface;
        }

        return $this;
    }

    public function getExtendedClass()
    {
        $extended = '';

        if(trim($this->classeNameExtended) != ''){
            $extended = "extends ".$this->classeNameExtended;
        }

        return $extended;
    }

    private function getImplementedInterfaces()
    {
        $implementedInterfaces = '';

        if(!empty($this->implementedInterfaces)){

            $implementedInterfaces .= implode(',',$this->implementedInterfaces);
        }

        return $implementedInterfaces;
    }

    /**
     * Get the value of classProperties
     */ 
    public function getClassProperties(): array
    {
        return $this->classProperties;
    }

    /**
     * Set the value of classProperties
     *
     * @return  self
     */ 
    public function addClassPropertie(string $classPropertyName, string $visibility = null, string $defaultValue = null): self
    {
        if(!in_array($classPropertyName, $this->classProperties)){

            $this->classProperties[] = (new PropertyCodeBuilder())
                                        ->setVisibility($visibility)
                                        ->setPropertyName($classPropertyName)
                                        ->setDefaultValue($defaultValue)
                                        ->render();
        }

        return $this;
    }

    private function formatedProperties(){

        $properties = '';

        if(!empty($this->classProperties)){

            foreach ($this->classProperties as $property) {

                $properties .= $property . "\n";
            }
        }

        return $properties;
    }

    private function formatedFunctions(){
        
        $functions = '';

        if(!empty($this->functions)){

            foreach ($this->functions as $function) {

                $functions .= $function ."\n\n";
            }
        }
        
        return $functions;
    }

    /**
     * Get the value of namespace
     */ 
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set the value of namespace
     *
     * @return  self
     */ 
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }
}