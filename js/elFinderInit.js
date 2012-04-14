function initElFinder(selector, options) {

    // Checking whether WYSIWYG editor is specified
    if (options['wysiwyg']) {

        // Setting callback function according to used WYSIWYG editor
        if (options['wysiwyg'] == "ckeditor") {

            options['getFileCallback'] = function(file) {
                var funcNum = window.location.search.replace(/^.*CKEditorFuncNum=(\d+).*$/, "$1");
                window.opener.CKEDITOR.tools.callFunction(funcNum, file);
                window.close();
            };
        }

        // TODO: implement your WYSIWYG editor's callback function here

        delete options['wysiwyg'];
    }

    jQuery(selector).elfinder(options).elfinder("instance");
}
