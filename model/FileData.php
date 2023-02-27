<?php

namespace Model;

use Exception;

class FileData extends Data {
    const DATA_PATH = __DIR__ . '/../data/';
    const COMP_FILE_TEMPLATE = '/^component-\d\d.txt\z/';
    const DISH_FILE_TEMPLATE = '/^dish-\d\d\z/';

    protected function getComponents($dishId) {
        $Components = array();
        $conts = scandir(self::DATA_PATH . $dishId);
        foreach ($conts as $node) {
            if (preg_match(self::COMP_FILE_TEMPLATE, $node)) {
                $Components[] = $this->getComponent($dishId, $node);
            }
        }
        return $Components;
    }

    /**
     * @throws Exception
     */
    protected function getComponent($dishId, $id) {
        $f = fopen(self::DATA_PATH . $dishId . "/" . $id,"r");
        $rowStr = fgets($f);
        $rowArr = explode("/", $rowStr);
        $Component = (new Component())
            ->setId($id)
            ->setName($rowArr[0])
            ->setDate(new \DateTime($rowArr[1]))
            ->setWeight($rowArr[2]);
        if ($rowArr[3] == '0') {
            $Component->setNotNecessarilyPr();
        } else {
            $Component->setNecessarilyPr();
        }
        fclose($f);
        return $Component;
    }
    protected function getDishes() {
        $groups = array();
        $conts = scandir(self::DATA_PATH);
        foreach ($conts as $node) {
            if (preg_match(self::DISH_FILE_TEMPLATE, $node)) {
                $groups[] = $this->getDish($node);
            }
        }
        return $groups;
    }
    protected function getDish($id) {
        $f = fopen(self::DATA_PATH . $id . "/dish.txt","r");
        $grStr = fgets($f);
        $grArr = explode("/", $grStr);
        fclose($f);
        $group = (new Group())
            ->setId($id)
            ->setNumber($grArr[0])
            ->setDepartment($grArr[1])
            ->setStarosta($grArr[2]);
        return $group;
    }
    protected function getUsers() {
        $users = array();
        $f = fopen(self::DATA_PATH . "users.txt","r");
        while (!feof($f)) {
            $rowStr = fgets($f);
            $rowArr = explode(";", $rowStr);
            if (count($rowArr) == 3) {
                $user = (new User())
                    ->setUserName($rowArr[0])
                    ->setPassword($rowArr[1])
                    ->setRights(substr($rowArr[2],0,9));
                $users[] = $user;
            }
        }
        fclose($f);
        return $users;
    }
    protected function getUser($id) {
        $users = $this->getUsers();
        foreach ($users as $user) {
            if ($user->getUserName() == $id) {
                return $user;
            }
        }
        return false;
    }
    protected function setComponent(Component $component) {
        $f = fopen(self::DATA_PATH . $component->getGroupId() . "/" . $component->getId(), "w");
        $necessarily = 0;
        if ($component->isNecessarily()) {
            $necessarily = 1;
        }
        $dishArr = array($component->getName(), $component->getWeight(), $component->getDate()->format('Y-m-d'), $necessarily,);
        $DishStr = implode("/", $dishArr);
        fwrite($f, $DishStr);
        fclose($f);
    }
    protected function delComponent(Component $component) {
        unlink(self::DATA_PATH . $component->getDishId() . "/" . $component->getId());
    }
    protected function insComponent(Component $component) {
        $path = self::DATA_PATH . $component->getDishId();
        $conts = scandir($path);
        $i = 0;
        foreach ($conts as $node) {
            if (preg_match(self::COMP_FILE_TEMPLATE, $node)) {
                $last_file = $node;
            }
        }
        $file_index = (String)(((int)substr($last_file, -6, 2)) + 1);
        if (strlen($file_index) == 1) {
            $file_index = "0" . $file_index;
        }
        //формуємо ім'я нового файлу
        $newFileName = "component-" . $file_index . ".txt";

        $component->setId($newFileName);
        $this->setComponent($component);
    }
    protected function setDish(Dish $dish) {
        $f = fopen(self::DATA_PATH . $dish->getId() . "/dish.txt", "w");
        $dishArr = array($dish->getName(), $dish->getType(), $dish->getWeight(),);
        $dishStr = implode("/", $dishArr);
        fwrite($f, $dishStr);
        fclose($f);
    }
    protected function setUser(User $user) {
        $users = $this->getUsers();
        $found = false;
        foreach ($users as $key => $oneUser) {
            if ($user->getUserName() == $oneUser->getUserName()) {
                $found = true;
                break;
            }
        }
        if ($found) {
            $users[$key] = $user;
            $f = fopen(self::DATA_PATH . "users.txt", "w");
            foreach ($users as $oneUser) {
                $grArr = array($oneUser->getUserName(), $oneUser->getPassword(), $oneUser->getRights() . "\r\n",);
                $grStr = implode(";", $grArr);
                fwrite($f, $grStr);
            }
            fclose($f);
        }

    }
    protected function delDish($dishId) {
        $dirName = self::DATA_PATH . $dishId;
        $conts = scandir($dirName);
        $i=0;
        foreach ($conts as $node) {
            @unlink($dirName . "/" . $node);
        }
        @rmdir($dirName);
    }
    protected function insDish() {
        //визначаємо останню папку групи
        $path = self::DATA_PATH ;
        $conts = scandir($path);
        foreach ($conts as $node) {
            if (preg_match(self::DISH_FILE_TEMPLATE, $node)) {
                $last_group = $node;
            }
        }
        // получаем индекс последней папки и увеличиваем ее на 1
        $group_index = (String)(((int)substr($last_group, -1, 2)) + 1);
        if (strlen($group_index) == 1) {
            $group_index = "0" . $group_index;
        }
        // формируем имя новой папки
        $newGroupName = "dish-" . $group_index;

        mkdir($path . $newGroupName);
        $f = fopen($path . $newGroupName . "/dish.txt" , "w");
        fwrite($f, "New/ / ");
        fclose($f);
    }
}
