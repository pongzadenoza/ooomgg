<?php

class Product
{
    private $Pname,$images,$price, $description,$Ptype;
    public function __construct($Pname,$images,$price, $description,$Ptype)
    {
        $this->$Pname = $Pname;
        $this->$images=$images;
        $this->$price=$price;
        $this->$description=$description;
        $this->$Ptype=$Ptype;
    }

    public function getPname()
    {
        return $this->Pname;
    }
    public function getImages()
    {
        return $this->images;
    }


    public function getPrice()
    {
        return $this->price;
    }


    public function getDescription()
    {
        return $this->description;
    }

    public function getPtype()
    {
        return $this->Ptype;
    }

    public function setPname($Pname)
    {
        $this->Pname = $Pname;
    }

    public function setImages($images)
    {
        $this->images = $images;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    
    public function setPtype($Ptype)
    {
        $this->Ptype = $Ptype;
    }

    
}

