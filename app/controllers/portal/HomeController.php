<?php

namespace app\controllers\portal;

use app\controllers\ContainerController;
use app\database\activerecord\FindAll;
use app\database\models\User;

class HomeController extends ContainerController
{
    public function index()
    {


        $user = new User();
        $users = $user->execute(new FindAll(fields:'id,name,email'));

        $this->view([
            'title' => 'Home Users',
            'users' => $users,
        ], 'portal.home');
    }

}
