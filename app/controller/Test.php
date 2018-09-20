<?php

namespace app\controller;

use system\base\Controller;
use app\model\TestModel;
use system\components\Utils;
use system\exceptions\InvalidRouteException;
use system\Router;

/**
 * Class Test
 * @package app\controller
 */
class Test extends Controller
{
    /**
     * This action called from Router/Dispatch before main action calling
     * Check if user has provided his name
     */
    public function init()
    {
        // Session keys exist for test starting
        if (!Utils::array_keys_exists(['name', 'test_id', 'passing_id'], $_SESSION)) {
            Router::createRedirectPath('/');
        } else {
            // User has changed url and now session data is different from URL data
            if ($_SESSION['test_id'] != $this->route['test_id']) {
                Router::createRedirectPath('/');
            }
        }
    }

    /**
     * URL: /test/{test_id}
     * Check if user has selected test
     * If all correct - start test
     */
    public function indexAction()
    {
        try {
            if (array_key_exists('test_id', $this->route)) {
                $test = TestModel::getTestAllData($this->route['test_id']);
            }
            if (!isset($test) || !$test) {
                throw new InvalidRouteException("Test not found");
            }

            $test['user'] = $_SESSION['name'];
            $test['passing_id'] = $_SESSION['passing_id'];
            if (!isset($_SESSION['current_question'])) {
                $_SESSION['current_question'] = 0;
            }
            $test['current_question'] = $_SESSION['current_question'];
            if (!isset($_SESSION['correct_answers'])) {
                $_SESSION['correct_answers'] = 0;
            }
            $test['correct_answers'] = $_SESSION['correct_answers'];

            $this->setData([
                'test' => $test
            ]);
        } catch (InvalidRouteException $e) {
            $e->showNotFoundPage();
        }
    }

    public function ajaxWriteLog()
    {
        $user = $_POST['user'];
        $passing_id = $_POST['passing_id'];
        $question_id = $_POST['question_id'];
        $answer_id = $_POST['answer_id'];
        $_SESSION['current_question'] = $_POST['current_question'];
        TestModel::writeLog($user, $passing_id, $question_id, $answer_id);
        $this->jsonSuccess();
    }

    public function ajaxUpdatePassing()
    {
        $passing_id = $_POST['passing_id'];
        $data = ['result' => $_POST['result'], 'is_complete' => $_POST['complete']];
        $_SESSION['correct_answers'] = $_POST['result'];
        TestModel::updatePassingById($passing_id, $data);
        $this->jsonSuccess();
    }
}