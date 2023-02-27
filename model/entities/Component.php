<?php

namespace Model;

class Component {
    const NOTNECESSARILY = 0;
    const NECESSARILY = 1;

    private $id;
    private $name;
    private $weight;
    private $date;
    private $necessarily;
    private $dishId;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    public function getWeight() {
        return $this->weight;
    }
    public function setWeight($weight) {
        $this->weight = $weight;
        return $this;
    }
    public function getDate() {
        return $this->date;
    }
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }
    public function isNotNecessarily() {
        return ($this->date == self::NOTNECESSARILY);
    }
    public function isNecessarily() {
        return !($this->isNotNecessarily());
    }
    public function setNotNecessarilyPr() {
        $this->date = SELF::NOTNECESSARILY;
        return $this;
    }
    public function setNecessarilyPr() {
        $this->date = SELF::NECESSARILY;
        return $this;
    }
    public function isPrivilege() {
        return $this->necessarily;
    }
    public function setNecessarily($necessarily) {
        $this->necessarily = $necessarily;
        return $this;
    }
    public function getDishId() {
        return $this->dishId;
    }
    public function setDishId($dishId) {
        $this->dishId = $dishId;
        return $this;
    }
}