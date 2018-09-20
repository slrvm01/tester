<?php

namespace app\controller;

use app\model\TestModel;
use system\base\Controller;

/**
 * Class Home
 * @package app\controller
 */
class Home extends Controller
{
    /**
     * Action for URL that matching /
     */
    public function indexAction()
    {
        session_unset();
        $test_list = TestModel::getAllTestList();

        $this->setData(['test_list' => $test_list]);
    }

    /**
     * Ajax request. /home/start
     * If POST data is valid - write session
     */
    public function ajaxStart()
    {
        $validate_errors = $this->validateStartForm($_POST);
        if (empty($validate_errors)) {
            $name = $_POST['name'];
            $test_id = $_POST['test'];
            $test = TestModel::getTestById($test_id);
            $passing_id = TestModel::createPassing($name, $test->id);
            $_SESSION['name'] = $name;
            $_SESSION['test_id'] = $test->id;
            $_SESSION['passing_id'] = $passing_id;
            $this->jsonSuccess([
                'name' => $name,
                'testId' => $test->id,
                'title' => $test->title,
                'passingId' => $passing_id,
            ]);
        } else {
            $this->jsonError($validate_errors);
        }
    }

    /**
     * Validate starting form at home screen.
     * Errors return as 'input name' => 'error text'
     * If form is valid - return empty array $errors
     * @param $data
     * @return array $errors
     */
    private function validateStartForm($data)
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Ievadi savu vārdu';
        }

        if (empty($data['test'])) {
            $errors['test'] = 'Izvēlies testu';
        }

        return $errors;
    }
}