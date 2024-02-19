<?php


require '../bootstrap.php';


use core\Controller;
use core\Method;
use core\Parameters;

try {
    $controller = new Controller();
    $controller = $controller->load();

    $method = new Method();
    $method = $method->load($controller);

    $parameters = new Parameters();
    $parameters = $parameters->load();

    $controller->$method($parameters);

} catch (\Exception $e) {
    dd($e->getMessage());
}

// use app\database\models\User;
// use app\database\activerecord\Update;
// use app\database\activerecord\Delete;
// use app\database\activerecord\FindAll;
// use app\database\activerecord\FindBy;

// $user = new User();
// $user->name = 'Robert';
// $user->email = 'sidneir@gmail.com';
// $user->id = 1;

// echo $user->execute(new Update(field:'id', value:'1'));
// echo $user->execute(new Update(field:'id', value:'1'));
// echo $user->execute(new Delete(field:'id', value:'1'));
// dd($user->execute(new FindBy(field:'id', value:'7', fields:'id, name')));
//dd($user->execute(new FindAll(fields:'id')));
