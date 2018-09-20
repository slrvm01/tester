$(function(){
    let test = {
        $test: '',
        user: '',
        testId: '',
        passingId: '',
        currentQuestion: 0,
        correctAnswers: 0,
        questionCount: '',

        prepareTest: function() {
            this.$test = $('.js-test');
            this.user = this.$test.data('test-user');
            this.testId = this.$test.data('test-id');
            this.passingId = this.$test.data('passing-id');
            this.currentQuestion = this.$test.data('current-question');
            this.correctAnswers = this.$test.data('correct-answers');
            this.questionCount = this.$test.data('question-count');
            if (this.currentQuestion < this.questionCount) {
                this.showQuestion(this.currentQuestion);
            } else {
                this.showResult();
            }
        },

        showQuestion: function(number, hidePrev = false) {
            let $target = this.$test.find($(`.js-question-block[data-question-number=${number}]`));
            if (hidePrev === true) {
                this.$test.find($(`.js-question-block[data-question-number=${number -1}]`)).hide();
            }
            $target.show();
            this.updateProgressbar();
        },

        showResult: function() {
            $result = `<h1 class="title">Paldies, ${this.user}!</h1>
                        <h2 class="title">Tests ir pabeigts ar rezultātu ${this.correctAnswers} / ${this.questionCount}</h2>
                        <a class="result-link" href="/">Uz galvēno</a>`;
            this.$test.replaceWith($result);
            this.updatePassing(1);
        },

        updateProgressbar: function() {
            let progress = this.currentQuestion / this.questionCount * 100;
            this.$test.find('.js-progress').css({'width': progress + '%'});
        },

        writeLog: function (obj) {
            let data = {
                user: this.user,
                passing_id: this.passingId,
                question_id: obj.data('question'),
                answer_id: obj.data('answer'),
                current_question: this.currentQuestion
            };
            $.ajax({
                url: '/test/writelog',
                data: data,
                dataType: 'json',
                type: 'post',
                success: function () {}
            });
        },

        updatePassing: function (complete = 0) {
            let data = {
                passing_id: this.passingId,
                result: this.correctAnswers,
                complete: complete
            };
            $.ajax({
                url: '/test/updatepassing',
                data: data,
                dataType: 'json',
                type: 'post',
                success: function () {}
            });
        },

        init: function () {
            this.prepareTest();
            let self = this;
            this.$test.find($('.js-answer').on('click', function () {
                if($(this).data('correct') === 1) {
                    self.correctAnswers++;
                    self.updatePassing();
                }
                self.currentQuestion++;
                if (self.currentQuestion < self.questionCount) {
                    self.showQuestion(self.currentQuestion, true);
                } else {
                    self.showResult();
                }
                self.writeLog($(this));
            }));
        }
    };

    let startForm = {
        $form: $('.js-start-form'),

        submit: function() {
            let data = this.$form.serializeArray();
            let self = this;
            $.ajax({
                url: '/home/start',
                data: data,
                dataType: 'json',
                type: 'post',
                success: function (response) {
                    if (response.result === 'success') {
                        let testId = response.data.testId;
                        window.location = `/test/${testId}`;
                    } else if (response.result === 'error') {
                        self.handleFormErrors(response.data)
                    }
                }
            });
        },

        handleFormErrors: function(errors) {
            Object.keys(errors).forEach(name => {
                let $msg = $(`<p class="error-text">${errors[name]}</p>`);
                this.$form.find(`[name=${name}]`)
                    .closest('.input-wrapper, .select-wrapper')
                    .addClass('input-error')
                    .append($msg)
                    .one('input', function () {
                        $msg.closest('.input-wrapper, .select-wrapper').removeClass('input-error').end().remove();
                    });
            })
        },

        init: function () {
            this.submit();
        }
    };

    startForm.$form.on('submit', function (e) {
        e.preventDefault();
        startForm.init();
    });

    if ($(document).find('.js-test')) {
        test.init();
    }
});