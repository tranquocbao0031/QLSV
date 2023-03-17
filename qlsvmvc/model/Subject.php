<?php
class Subject
{
    // thuộc tính (attribute/property)
    public $id;
    public $name;
    public $number_of_credit;

    function __construct($id, $name, $number_of_credit)
    {
        $this->id = $id;
        $this->name = $name;
        $this->number_of_credit = $number_of_credit;
    }
}