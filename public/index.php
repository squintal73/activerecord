<?php

// Import the necessary classes
require '../bootstrap.php';
use core\Controller;
use core\Method;
use core\Parameters;

try {
    // Create an instance of the Controller class and load it
    $controller = (new Controller())->load();

    // Create an instance of the Method class and load it with the controller
    $method = (new Method())->load($controller);

    // Create an instance of the Parameters class and load it
    $parameters = (new Parameters())->load();

    // Call the appropriate method on the controller with the parameters
    $controller->$method($parameters);

} catch (\Exception $e) {
    // Display the error message
    dd($e->getMessage());
}
