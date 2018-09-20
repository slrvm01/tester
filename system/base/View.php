<?php

namespace system\base;

use system\components\Utils;

/**
 * Class View
 * @package system\base
 */
class View
{
    /**
     * Route for folders navigation
     * @var array $route
     */
    private $route = [];

    /**
     * Layout can be redefined in Controller
     * @var string $layout
     */
    private $layout;

    /**
     * View can be redefined in Controller
     * @var string $view
     */
    private $view;

    /**
     * View constructor.
     * @param array $route
     * @param string $layout
     * @param string $view
     */
    public function __construct(array $route, $layout, $view)
    {
        $this->route = $route;
        $this->route['controller'] = Utils::lowerCamelCase($route['controller']);
        $this->layout = $layout;
        $this->view = $view;
    }

    /**
     * Data can be provided for usage in view files
     * @param array $data
     */
    public function render(array $data)
    {
        // Extracting data from Controller function setData
        extract($data);

        $file_view = VIEWS . "/{$this->route['controller']}/{$this->view}.php";

        // Save view file contents in @var $content for inserting it in layout file
        ob_start();
        if (is_file($file_view)) {
            require_once $file_view;
        } else {
            echo "Unable to find view $file_view <br>";
        }
        $content = ob_get_clean();

        // Connect layout file.
        $file_layout = LAYOUTS . "/{$this->layout}.php";
        if (is_file($file_layout)) {
            require_once $file_layout;
        } else {
            echo "Unable to find layout $file_layout";
        }
    }
}