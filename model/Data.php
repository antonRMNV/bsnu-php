<?php
namespace Model;

abstract class Data {
    const FILE = 0;

    private $error;
    private $user;

    public function setCurrentUser($userName) {
        $this->user = $this->readUser($userName);
    }

    public function getCurrentUser() {
        return $this->user;
    }

    public function checkRight($object, $right) {
        return $this->user->checkRight($object, $right);
    }

    public function readComponents($dishId) {
        if ($this->user->checkRight('component', 'view')) {
            $this->error = "";
            return $this->getComponents($dishId);
        } else {
            $this->error = "You have no permissions to view students";
            return false;
        }
    }
    protected abstract function getComponents($dishId);

    public function readComponent($dishId, $id) {
        if ($this->checkRight('component', 'view')) {
            $this->error = "";
            return $this->getComponent($dishId, $id);
        } else {
            $this->error = "You have no permissions to view student";
            return false;
        }
    }
    protected abstract function getComponent($dishId, $id);

    public function readDishes() {
        if ($this->checkRight('dish', 'view')) {
            $this->error = "";
            return $this->getDishes();
        } else {
            $this->error = "You have no permissions to view dishes";
            return false;
        }
    }
    protected abstract function getDishes();

    public function readDish($id) {
        if ($this->checkRight('dish', 'view')) {
            $this->error = "";
            return $this->getDish($id);
        } else {
            $this->error = "You have no permissions to view group";
            return false;
        }
    }
    protected abstract function getDish($id);

    public function readUsers() {
        if ($this->checkRight('user', 'admin')) {
            $this->error = "";
            return $this->getUsers();
        } else {
            $this->error = "You have no permissions to administrate users";
            return false;
        }
    }
    protected abstract function getUsers();

    public function readUser($id) {
        $this->error = "";
        return $this->getUser($id);
    }
    protected abstract function getUser($id);

    public function writeComponent(Component $component) {
        if ($this->checkRight('component', 'edit')) {
            $this->error = "";
            $this->setComponent($component);
            return true;
        } else {
            $this->error = "You have no permissions to edit students";
            return false;
        }
    }
    protected abstract function setComponent(Component $component);

    public function writeDish(Dish $dish) {
        if ($this->checkRight('dish', 'edit')) {
            $this->error = "";
            $this->setDish($dish);
            return true;
        } else {
            $this->error = "You have no permissions to edit groups";
            return false;
        }
    }
    protected abstract function setDish(Dish $dish);

    public function writeUser(User $user) {
        if ($this->checkRight('user', 'admin')) {
            $this->error = "";
            $this->setUser($user);
            return true;
        } else {
            $this->error = "You have no permissions to administrate users";
            return false;
        }
    }
    protected abstract function setUser(User $user);

    public function removeComponent(Component $component) {
        if ($this->checkRight('component', 'delete')) {
            $this->error = "";
            $this->delComponent($component);
            return true;
        } else {
            $this->error = "You have no permissions to delete students";
            return false;
        }
    }
    protected abstract function delComponent(Component $component);

    public function addComponent(Component $component) {
        if ($this->checkRight('component', 'create')) {
            $this->error = "";
            $this->insComponent($component);
            return true;
        } else {
            $this->error = "You have no permissions to create students";
            return false;
        }
    }
    protected abstract function insComponent(Component $component);

    public function removeDish($dishId) {
        if ($this->checkRight('dish', 'delete')) {
            $this->error = "";
            $this->delDish($dishId);
            return true;
        } else {
            $this->error = "You have no permissions to delete groups";
            return false;
        }
    }
    protected abstract function delDish($dishId);

    public function addDish() {
        if ($this->checkRight('dish', 'create')) {
            $this->error = "";
            $this->insDish();
            return true;
        } else {
            $this->error = "You have no permissions to create groups";
            return false;
        }
    }
    protected abstract function insDish();

    public function getError() {
        if ($this->error) {
            return $this->error;
        }
        return false;
    }

    public static function makeModel($type) {
        if ($type == self::FILE) {
            return new FileData();
        }
        return new FileData();
    }
}
