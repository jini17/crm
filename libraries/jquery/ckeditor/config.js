/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    //vtiger editor toolbar configuration 
 		    config.removePlugins = 'save,maximize,magicline'; 
			config.fullPage = true; 
 		    config.allowedContent = true; 
			config.disableNativeSpellChecker = false;
			config.enterMode = CKEDITOR.ENTER_BR;  
			config.shiftEnterMode = CKEDITOR.ENTER_P; 
			config.autoParagraph = false;
			config.fillEmptyBlocks = false;
			config.filebrowserBrowseUrl = 'kcfinder/browse.php?type=images'; 
			config.filebrowserUploadUrl = 'kcfinder/upload.php?type=images'; 
 	        config.plugins = 'dialogui,dialog,docprops,about,a11yhelp,dialogadvtab,basicstyles,bidi,blockquote,clipboard,button,panelbutton,panel,floatpanel,colorbutton,colordialog,menu,contextmenu,div,resize,toolbar,elementspath,enterkey,entities,popup,filebrowser,find,fakeobjects,floatingspace,listblock,richcombo,font,format,horizontalrule,htmlwriter,wysiwygarea,image,indent,indentblock,indentlist,justify,link,list,liststyle,magicline,pagebreak,preview,removeformat,selectall,showborders,sourcearea,specialchar,menubutton,stylescombo,tab,table,tabletools,undo,wsc'; 
 		    config.toolbarGroups = [ 
 		        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] }, 
 		        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] }, 
				{ name: 'insert' ,groups:['blocks']}, 
 		        { name: 'links' }, 
 		        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] }, 
 	        '/', 
 		        { name: 'styles' }, 
 		        { name: 'colors' }, 
 		        { name: 'tools' }, 
 		        { name: 'others' }, 
 		        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },{name: 'align'}, 
 	        { name: 'paragraph', groups: [ 'list', 'indent' ] }, 
            ];
			
			//Add new custom font names in below array
			var customFonts = ['FreeStyle Script','Brush Script STD','Bradley Hand ITC','Vladimir Script'];
			for(var i = 0; i < customFonts.length; i++){
				  config.font_names = config.font_names+';'+customFonts[i];
			}
};

//Added By Mabruk To Fix the Line Breaks in Detail View for CKEditor Templates 10/07/2018
CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    CKEDITOR.on('instanceReady', function (ev) {
        var writer = ev.editor.dataProcessor.writer;
        // The character sequence to use for every indentation step.
        writer.indentationChars = '  ';

        var dtd = CKEDITOR.dtd;
        // Elements taken as an example are: block-level elements (div or p), list items (li, dd), and table elements (td, tbody).
        for (var e in CKEDITOR.tools.extend({}, dtd.$block, dtd.$listItem, dtd.$tableContent)) {
            ev.editor.dataProcessor.writer.setRules(e, {
                // Indicates that an element creates indentation on line breaks that it contains.
                indent: false,
                // Inserts a line break before a tag.
                breakBeforeOpen: false,
                // Inserts a line break after a tag.
                breakAfterOpen: false,
                // Inserts a line break before the closing tag.
                breakBeforeClose: false,
                // Inserts a line break after the closing tag.
                breakAfterClose: false
            });
        }

        for (var e in CKEDITOR.tools.extend({}, dtd.$list, dtd.$listItem, dtd.$tableContent)) {
            ev.editor.dataProcessor.writer.setRules(e, {
                indent: true,
            });
        }

       
       
    });
}
