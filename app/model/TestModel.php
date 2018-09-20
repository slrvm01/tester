<?php

namespace app\model;

use system\base\DB;


/**
 * Model that provide data about tests
 * Class TestModel
 * @package app\model
 */
class TestModel
{
    /**
     * Return list with all available tests
     * @return null|\stdClass
     */
    public static function getAllTestList()
    {
        return DB::getInstance()->table('test')->get();
    }

    /**
     * Return info about only one test
     * @param int $id
     * @return null|\stdClass
     */
    public static function getTestById($id)
    {
        return DB::getInstance()->table('test')->find($id);
    }

    /**
     * Get all questions from test
     * @param $test_id
     * @return null|\stdClass
     */
    public static function getTestQuestions($test_id)
    {
        return DB::getInstance()->table('question')->select('id', 'text')->findAll('test_id', $test_id);
    }

    /**
     * Get all answer options for question
     * @param $question_id
     * @return null|\stdClass
     */
    public static function getQuestionAnswers($question_id)
    {
        return DB::getInstance()->table('answer')
            ->select('id', 'text', 'is_correct')
            ->findAll('question_id', $question_id);
    }

    public static function getTestAllData($test_id)
    {
        $test = [];
        $test['test_id'] = $test_id;
        $test['questions'] = self::getTestQuestions($test_id);
        $test['question_count'] = sizeof($test['questions']);
        foreach ($test['questions'] as $key => $question) {
            $test['questions'][$key]->answers = self::getQuestionAnswers($question->id);
        }
        return $test;
    }

    public static function createPassing($user, $test_id)
    {
        $insertId = DB::getInstance()->table('passing')->insert([
            'user' => $user,
            'test_id' => $test_id
        ]);

        return $insertId;
    }

    public static function updatePassingById($id, $data)
    {
        DB::getInstance()->table('passing')->where('id', $id)->update($data);
    }

    public static function writeLog($user, $passing_id, $question_id, $answer_id)
    {
        return DB::getInstance()->table('log')->insert([
            'user' => $user,
            'passing_id' => $passing_id,
            'question_id' => $question_id,
            'answer_id' => $answer_id
        ]);
    }
}