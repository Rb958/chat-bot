<?php
namespace App\Utils\Manager;

class DataRegister
{
    private $dataArray = [];
    private static $instance = null;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new DataRegister();
        }
        return self::$instance;
    } 

    public function getData($name)
    {
        return $this->dataArray[$name];
    }

    public function setData($name, $data)
    {
        $this->dataArray[$name] = $data;
    }

    public function dump(){
        return $this->dataArray;
    } 
}