/**
 * Created by nobikun1412 on 17-Jun-17.
 */

CKEDITOR.plugins.add( 'checkbox_quiz', {
    icons: 'checkbox_quiz',
    init: function( editor ) {
        //Plugin logic goes here.
        editor.on( 'selectionChange', function( e )
            {
                if (in_question == false || in_checkbox_question == true) {
                    editor.getCommand('insertCheckboxQuiz').setState(CKEDITOR.TRISTATE_OFF)
                }

                else if (in_question == true && in_checkbox_question == false)
                    editor.getCommand('insertCheckboxQuiz').setState(CKEDITOR.TRISTATE_DISABLED)
            }
        );
        editor.addCommand( 'insertCheckboxQuiz', new CKEDITOR.dialogCommand( 'checkbox_quizDialog' ) );
        editor.ui.addButton( 'checkbox_quiz', {
            label: 'Multiple 2 answers',
            command: 'insertCheckboxQuiz',
            toolbar: 'others,1'
        });
         CKEDITOR.dialog.add( 'checkbox_quizDialog', this.path + 'dialogs/checkbox_quiz.js' );
    }
});