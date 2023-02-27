<?php

namespace Model;

class Dish {
    private $id;
    private $name;
    private $type;
    private $weight;

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
    public function getType() {
        return $this->type;
    }
    public function setType($type) {
        $this->type = $type;
        return $this;
    }
    public function getWeight() {
        return $this->weight;
    }
    public function setWeight($weight) {
        $this->weight = $weight;
        return $this;
    }
}