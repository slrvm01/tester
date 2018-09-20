<?php

namespace system\base;

/**
 * Class Controller
 *
 * @package system\base
 */
abstract class Controller
{
    /**
     * Current route
     * @var array $route
     */
    protected $route;

    /**
     * Layout can be redefined in controller that extends this
     * @var string $layout
     */
    protected $layout;

    /**
     * View can be redefined in controller that extends this
     * @var string $view
     */
    protected $view;

    /**
     * Data can be added in controller that extends this
     * @var array $data
     */
    protected $data = [];

    /**
     * Controller constructor.
     * @param $route
     */
    public function __construct($route)
    {
        $this->route = $route;
        $this->layout = DEFAULT_LAYOUT;
        $this->view = $route['action'];
    }

    /**
     * Method is calling from Router/Dispatch
     */
    public function getView()
    {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->data);
    }

    /**
     * Data used in views
     * @param array $data
     */
    protected function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Method make json status
     * @param $result
     * @param array $data
     */
    private function jsonStatus($result, $data = [])
    {
        $json = [];
        $json['result'] = $result;
        if (!empty($data)) {
            $json['data'] = $data;
        }

        echo json_encode($json);
    }

    /**
     * If ajax request is successful
     * @param array $data
     */
    public function jsonSuccess($data = [])
    {
        self::jsonStatus('success', $data);
    }

    /**
     * If ajax request is invalid
     * @param array $data
     */
    public function jsonError($data = [])
    {
        self::jsonStatus('error', $data);
    }
}