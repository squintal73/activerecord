<?php

namespace core;

use app\classes\Uri;
use app\exceptions\ControllerNotExistException;

class Controller
{
    // Store the current URI
    private $uri;
    // Store the name of the controller class
    private $controller;
    // Store the namespace of the controller
    private $namespace;
    // Array of folders where controllers may be located
    private $folders = [
        'app\controllers\portal',
        'app\controllers\admin',
    ];

    // Get the current URI when the Controller object is created
    public function __construct()
    {
        $this->uri = Uri::uri();
    }

    // Load the appropriate controller based on the current URI
    public function load()
    {
        // If the current URI is the home page
        if ($this->isHome()) {
            return $this->controllerHome();
        }
        // If the current URI is not the home page
        return $this->controllerNotHome();
    }

    // Handle the controller for the home page
    private function controllerHome()
    {
        // Check if the HomeController class exists in any of the specified folders
        if (!$this->controllerExist('HomeController')) {
            throw new ControllerNotExistException("Esse controller não existe");
        }

        // Instantiate the HomeController class and return it
        return $this->instantiateController();
    }

    // Handle the controller for all other pages
    private function controllerNotHome()
    {
        // Get the name of the controller class for non-home pages
        $controller = $this->getControllerNotHome();

        // Check if the controller class exists in any of the specified folders
        if (!$this->controllerExist($controller)) {
            throw new ControllerNotExistException("Esse controller não existe");
        }

        // Instantiate the controller class and return it
        return $this->instantiateController();
    }

    // Get the name of the controller class for non-home pages
    private function getControllerNotHome()
    {
        // If the URI contains more than one slash
        if (substr_count($this->uri, '/') > 1) {
            // Extract the controller and method from the URI
            list($controller, $method) = array_values(array_filter(explode('/', $this->uri)));
            // Return the formatted controller class name
            return ucfirst($controller) . 'Controller';
        }

    }

    /**
     * Check if the current URI is the home page '/'
     *
     * @return bool
     */
    private function isHome()
    {
        return ($this->uri == '/');
    }

    /**
     * Check if the specified controller exists in any of the specified folders
     *
     * @param string $controller
     * @return bool
     */
    private function controllerExist($controller)
    {
        $controllerExist = false;

        // Iterate through each folder
        foreach ($this->folders as $folder) {
            // Check if the class exists in the current folder
            if (class_exists($folder . '\\' . $controller)) {
                $controllerExist = true;
                $this->namespace = $folder; // Set the current folder as the namespace
                $this->controller = $controller; // Set the current controller
            }
        }

        return $controllerExist;
    }

    /**
     * Instantiate the specified controller with the correct namespace
     *
     * @return object
     */
    private function instantiateController()
    {
        $controller = $this->namespace . '\\' . $this->controller; // Get the full path of the controller
        return new $controller(); // Instantiate and return an instance of the controller
    }

}
