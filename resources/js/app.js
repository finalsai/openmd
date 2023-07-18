import './bootstrap';

window.onload = function() {
    if (document.getElementById('area')) {
        const vditor = new Vditor('area', {
            value: window.raw,
            height: '100%',
            mode: 'sv',
            preview: {
                actions: 'none',
            },
            toolbar: [
                "emoji",
                "headings",
                "bold",
                "italic",
                "strike",
                "link",
                "table",
                "|",
                "list",
                "ordered-list",
                "check",
                "outdent",
                "indent",
                "|",
                "quote",
                "line",
                "code",
                "inline-code",
                "insert-before",
                "insert-after",
                "|",
                "undo",
                "redo",
                "|",
                "fullscreen",
                "edit-mode",
                "export",
                "outline",
            ]
        });

        document.getElementById('go').addEventListener('click', () => {
            document.getElementsByName('markdown')[0].value = vditor.getValue();
            vditor.clearStack();
            vditor.clearCache();
            document.forms['mainform'].submit();
        })
    }
}
