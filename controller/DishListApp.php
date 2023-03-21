<?php

namespace Controller;

use \Model\Data;
use \View\DishListView;

class DishListApp {
    private $model;
    private $view;

    public function __construct($modelType, $viewType) {
        session_start();
        $this->model = Data::makeModel($modelType);
        $this->view = DishListView::makeView($viewType);
    }

    public function checkAuth() {
        if($_SESSION['user']) {
            $this->model->setCurrentUser($_SESSION['user']);
            $this->view->setCurrentUser($this->model->getCurrentUser());
        } else {
            header('Location: ?action=login');
        }
    }

    public function run() {
        if(!in_array($_GET['action'], array('login', 'checkLogin'))) {
            $this->checkAuth();
        }
        if($_GET['action']) {
            switch ($_GET['action']) {
                case 'login':
                    $this->showLoginForm();
                    break;
                case 'checkLogin':
                    $this->checkLogin();
                    break;
                case 'logout':
                    $this->logout();
                    break;
                case 'create-dish':
                    $this->createDish();
                    break;
                case 'edit-dish-form':
                    $this->showEditDishForm();
                    break;
                case 'edit-dish':
                    $this->editDish();
                    break;
                case 'delete-dish':
                    $this->deleteDish();
                    break;
                case 'create-component-form':
                    $this->showCreateComponentForm();
                    break;
                case 'create-component':
                    $this->createComponent();
                    break;
                case 'edit-component-form':
                    $this->showEditComponentForm();
                    break;
                case 'edit-component':
                    $this->editComponent();
                    break;
                case 'delete-component':
                    $this->deleteComponent();
                    break;
                case 'admin':
                    $this->adminUsers();
                    break;
                case 'edit-user-form':
                    $this->showEditUserForm();
                    break;
                case 'edit-user':
                    $this->editUser();
                    break;
                default:
                    $this->showMainForm();
            }
        } else {
            $this->showMainForm();
        }
    }

    private function showLoginForm() {
        $this->view->showLoginForm();
    }

    private function checkLogin() {
        if ($user = $this->model->readUser($_POST['username'])) {
            if($user->checkPassWord($_POST['password'])) {
                session_start();
                $_SESSION['user'] = $user->getUserName();
                header('Location: ../index.php');
            }
        }
    }

    private function logout() {
        unset($_SESSION['user']);
        header('Location: ?action=login');
    }

    private function showMainForm() {
        $dishes = array();
        if($this->model->checkRight('dish','view')) {
            $dishes = $this->model->readDishes();
        }

        $dish = new \Model\Dish();
        if($_GET['dish'] &&  $this->model->checkRight('dish','view')) {
            $dish =  $this->model->readDish($_GET['dish']);
        }

        $components = array();
        if($_GET['dish'] &&  $this->model->checkRight('component','view')) {
            $components = $this->model->readComponents($_GET['dish']);
        }

        $this->view->showMainForm($dishes, $dish, $components);
    }

    private function createDish() {
        if(!$this->model->addDish()) {
            die($this->model->getError());
        } else {
            header('Location: index.php');
        }
    }

    private function showEditDishForm() {
        if(!$dish = $this->model->readDish($_GET['dish'])) {
            die($this->model->getError());
        }
        $this->view->showDishEditForm($dish);
    }

    private function editDish() {
        if($_POST) {
            if(!$this->model->writeDish((new \Model\Dish())
                ->setId($_GET['dish'])
                ->setName($_POST['name'])
                ->setWeight(($_POST['weight']))
                ->setType($_POST['type'])
            )) {
                die($this->model->getError());
            } else {
                header('Location: index.php?dish=' . $_GET['dish']);
            }
        }
    }

    private function deleteDish() {
        if(!$this->model->removeDish($_GET['dish'])) {
            die($this->model->getError());
        } else {
            header('Location: index.php');
        }
    }

    private function showEditComponentForm() {
        $component = $this->model->readComponent($_GET['dish'], $_GET['file']);
        $this->view->showComponentEditForm($component);
    }

    private function editComponent() {
        $component = (new \Model\Component())
            ->setDishId($_GET['dish'])
            ->setName($_POST['name'])
            ->setWeight($_POST['weight'])
            ->setDate(new \DateTime($_POST['date']))
            ->setNecessarily($_POST['necessarily']);

        if(!$this->model->writeComponent($component)) {
            die($this->model->getError());
        } else {
            header('Location: index.php?dish=' . $_GET['dish']);
        }
    }

    private function showCreateComponentForm() {
        $this->view->showComponentCreateForm();
    }

    private function createComponent() {
        $component = (new \Model\Component())
            ->setDishId($_GET['dish'])
            ->setName($_POST['name'])
            ->setWeight($_POST['weight'])
            ->setDate(new \DateTime($_POST['date']))
            ->setNecessarily($_POST['necessarily']);

        if(!$this->model->addComponent($component)) {
            die($this->model->getError());
        } else {
            header('Location: index.php?dish=' . $_GET['dish']);
        }
    }

    private function deleteComponent() {
        $component = (new \Model\Component())->setId($_GET['file'])->setDishId($_GET['dish']);
        if(!$this->model->removeComponent($component)) {
            die($this->model->getError());
        } else {
            header('Location: index.php?dish=' . $_GET['dish']);
        }
    }

    private function adminUsers() {
        $users = $this->model->readUsers();
        $this->view->showAdminForm($users);
    }
    private function showEditUserForm() {
        if(!$user = $this->model->readUser($_GET['username'])) {
            die($this->model->getError());
        }
        $this->view->showUserEditForm($user);
    }
    private function editUser() {
        $rights = "";
        for($i=0; $i<9; $i++) {
            if ($_POST['right' . $i]) {
                $rights .= "1";
            } else {
                $rights .= "0";
            }
        }
        $user = (new \Model\User())
            ->setUserName($_POST['user_name'])
            ->setPassword($_POST['user_pwd'])
            ->setRights($rights);
        if(!$this->model->writeUser($user)) {
            die($this->model->getError());
        } else {
            header('Location: ?action=admin ');
        }
    }
}