/**
 * Created by nobikun1412 on 17-Jun-17.
 */
CKEDITOR.plugins.add( 'radio_quiz', {
    icons: 'radio_quiz',
    init: function( editor ) {
        //Plugin logic goes here.
        editor.on( 'selectionChange', function( e )
            {
                if (in_question == false || in_radio_question == true) {
                    editor.getCommand('insertRadioQuiz').setState(CKEDITOR.TRISTATE_OFF)
                }

                else if (in_question == true && in_radio_question == false)
                    editor.getCommand('insertRadioQuiz').setState(CKEDITOR.TRISTATE_DISABLED)
            }
        );
        editor.addCommand( 'insertRadioQuiz', new CKEDITOR.dialogCommand( 'radio_quizDialog' ) );
        editor.ui.addButton( 'radio_quiz', {
            label: 'Multiple 1 answer',
            command: 'insertRadioQuiz',
            toolbar: 'others,4'
        });
         CKEDITOR.dialog.add( 'radio_quizDialog', this.path + 'dialogs/radio_quiz.js' );
    }
});