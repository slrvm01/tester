<div class="test-container js-test"
     data-test-id="<?= $test['test_id'] ?>"
     data-test-user="<?= $test['user'] ?>"
     data-passing-id="<?= $test['passing_id'] ?>"
     data-current-question="<?= $test['current_question'] ?>"
     data-correct-answers="<?= $test['correct_answers'] ?>"
     data-question-count="<?= $test['question_count'] ?>">
    <? foreach ($test['questions'] as $key => $question): ?>
    <div class="question-wrapper js-question-block" data-question-number="<?= $key ?>">
        <p class="question js-question"><?= $question->text ?></p>
        <div class="answers-container">
            <? foreach ($question->answers as $key => $answer): ?>
                <div class="answer js-answer"
                     data-question="<?= $question->id ?>"
                     data-answer="<?= $answer->id ?>"
                     data-correct="<?= $answer->is_correct ?>"
                     tabindex="<?= $key + 1 ?>"><?= $answer->text ?></div>
            <? endforeach; ?>
        </div>
    </div>
    <? endforeach; ?>
    <div class="test-progress">
        <div class="test-progress-bar js-progress"></div>
    </div>
</div>