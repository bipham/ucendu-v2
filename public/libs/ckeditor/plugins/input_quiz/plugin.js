/**
 * Created by nobikun1412 on 17-Jun-17.
 */
CKEDITOR.plugins.add( 'input_quiz', {
    icons: 'input_quiz',
    init: function( editor ) {
        //Plugin logic goes here.
        editor.on( 'selectionChange', function( e )
            {
                if (in_question == false) {
                    editor.getCommand('insertInputQuiz').setState(CKEDITOR.TRISTATE_OFF)
                }

                else
                    editor.getCommand('insertInputQuiz').setState(CKEDITOR.TRISTATE_DISABLED)
            }
        );
        editor.addCommand( 'insertInputQuiz', new CKEDITOR.dialogCommand( 'input_quizDialog' ) );
        editor.ui.addButton( 'input_quiz', {
            label: 'Input text',
            command: 'insertInputQuiz',
            toolbar: 'others,3'
        });
         CKEDITOR.dialog.add( 'input_quizDialog', this.path + 'dialogs/input_quiz.js' );
    }
});