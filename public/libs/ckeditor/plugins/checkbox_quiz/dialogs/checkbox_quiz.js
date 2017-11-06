CKEDITOR.dialog.add( 'checkbox_quizDialog', function( editor ) {
    return {
        title: 'Checkbox Quiz Properties',
        minWidth: 400,
        minHeight: 200,
        contents: [
            {
                id: 'tab-basic',
                label: 'Basic Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'question',
                        label: 'Question number',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Question number field cannot be empty." )
                    },
                    // {
                    //     type: 'text',
                    //     id: 'opt_question',
                    //     label: 'Content option',
                    //     validate: CKEDITOR.dialog.validate.notEmpty( "Content option field cannot be empty." )
                    // },
                    {
                        type: 'text',
                        id: 'value_question',
                        label: 'Value option',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Value option field cannot be empty." )
                    },
                    {
                        type: 'checkbox',
                        id: 'last_option',
                        label: 'Last option',
                        // 'default': 'checked',
                        // onClick: function() {
                        //     // this = CKEDITOR.ui.dialog.checkbox
                        //     alert( 'Checked: ' + this.getValue() );
                        // }
                    }
                ]
            }
        ],
        onShow: function() {

            this.setValueOf( 'tab-basic', 'question', question_number_input );
            this.setValueOf( 'tab-basic', 'value_question', value_checkbox_option );

        },
        onOk: function() {
            var dialog = this;
            var data_ques = $('.upload-page-custom').data('idquestion');
            var class_quiz = dialog.getValueOf( 'tab-basic', 'question' );
            var value_quiz = dialog.getValueOf( 'tab-basic', 'value_question' );
            question_number_input = parseInt(class_quiz);
            var value_char_code = value_quiz.charCodeAt() + 1;
            value_checkbox_option = String.fromCharCode(value_char_code);
            // var opt_quiz = dialog.getValueOf( 'tab-basic', 'opt_question' );
            var last_option = dialog.getValueOf('tab-basic', 'last_option' );
            var l_option = '';
            in_question = true;
            in_checkbox_question = true;
            if (last_option) {
                l_option = 'last-option';
                var html = '<span class="label-checkbox key-label"><strong>' + value_quiz + '</strong></span> <input type="checkbox" class="question-quiz question-checkbox question-' + class_quiz + ' ' + l_option +'" name="question-' + class_quiz + '" value="' + value_quiz + '" onclick="bitest(this)" data-qnumber="' + data_ques +'"/> ';
                data_ques++;
                $('.upload-page-custom').data('idquestion', data_ques);
                question_number_input++;
                value_checkbox_option = 'A';
                in_question = false;
                in_checkbox_question = false;
            }
            else {
                var html = '<span class="label-checkbox key-label"><strong>' + value_quiz + '</strong></span> <input type="checkbox" class="question-quiz question-checkbox question-' + class_quiz + ' ' + l_option +'" name="question-' + class_quiz + '" value="' + value_quiz + '" onclick="bitest(this)" data-qnumber="' + data_ques +'"/> ';
            }
            editor.insertHtml( html );
        }
    };
});