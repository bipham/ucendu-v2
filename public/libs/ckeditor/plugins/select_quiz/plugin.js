/**
 * Created by nobikun1412 on 17-Jun-17.
 */
CKEDITOR.plugins.add( 'select_quiz', {
    icons: 'select_quiz',
    init: function( editor ) {
        //Plugin logic goes here.
        editor.on( 'selectionChange', function( e )
            {
                if (in_question == false) {
                    editor.getCommand('insertSelectQuiz').setState(CKEDITOR.TRISTATE_OFF)
                }

                else
                    editor.getCommand('insertSelectQuiz').setState(CKEDITOR.TRISTATE_DISABLED)
            }
        );
        editor.addCommand( 'insertSelectQuiz', new CKEDITOR.dialogCommand( 'select_quizDialog' ) );
        editor.ui.addButton( 'select_quiz', {
            label: 'Select choice',
            command: 'insertSelectQuiz',
            toolbar: 'others,2'
        });
         CKEDITOR.dialog.add( 'select_quizDialog', this.path + 'dialogs/select_quiz.js' );
    }
});