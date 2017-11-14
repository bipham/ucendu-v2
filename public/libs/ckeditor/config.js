/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {

	// %REMOVE_START%
	// The configuration options below are needed when running CKEditor from source files.
	config.plugins = 'dialogui,dialog,about,a11yhelp,dialogadvtab,basicstyles,bidi,blockquote,button,toolbar,notification,clipboard,panelbutton,panel,floatpanel,colorbutton,colordialog,templates,menu,contextmenu,copyformatting,div,resize,elementspath,enterkey,entities,popup,filebrowser,find,fakeobjects,flash,floatingspace,listblock,richcombo,font,forms,format,horizontalrule,htmlwriter,iframe,wysiwygarea,image,indent,indentblock,indentlist,smiley,justify,menubutton,language,link,list,liststyle,magicline,maximize,newpage,pagebreak,pastetext,pastefromword,preview,print,removeformat,save,selectall,showblocks,showborders,sourcearea,specialchar,scayt,stylescombo,tab,table,tabletools,tableselection,undo,wsc,lineutils,widgetselection,widget,filetools,notificationaggregator,uploadwidget,uploadimage';
	config.skin = 'icy_orange';
	// %REMOVE_END%

	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.height = '500';
    config.extraPlugins = 'select_quiz,checkbox_quiz,radio_quiz,input_quiz,html5video';
    config.allowedContent = true;
    config.filebrowserBrowseUrl = '/public/libs/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '/public/libs/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = '/public/libs/ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl = '/public/libs/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = '/public/libs/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = '/public/libs/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
    // config.extraPlugins = 'select_quiz';
    // config.allowedContent = true;


    config.toolbar = [
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-'] },
        { name: 'paragraph', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
        { name: 'insert', items: [ 'Image', 'Html5video', 'Table', 'HorizontalRule'] },
        '/',
        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
        '/',
        { name: 'others', items: [ 'checkbox_quiz', 'select_quiz', 'input_quiz', 'radio_quiz' ] }
    ];
};
