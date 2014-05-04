/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.plugins.addExternal('lineutils','/js/ckeditorConfig/lineutils/plugin.js', '');
CKEDITOR.plugins.addExternal('widget','/js/ckeditorConfig/widget/plugin.js', '');
CKEDITOR.plugins.addExternal('image2','/js/ckeditorConfig/image2/plugin.js', '');

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'styles' },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
	];

	config.filebrowserUploadUrl = '/api/uploadpostimage';

	config.extraPlugins = 'lineutils';
	config.extraPlugins = 'widget';
	config.extraPlugins = 'image2';

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript,Anchor,Flash,Smiley,HorizontalRule,SpecialChar,PageBreak,Iframe,Styles,Font,FontSize,SetLanguage,Save,NewPage,Preview,Print,Templates';

	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';

};

