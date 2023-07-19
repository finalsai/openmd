import './bootstrap';

window.onload = function() {
    if (document.getElementById('area')) {
        const vditor = new Vditor('area', {
            height: '100%',
            mode: 'sv',
            preview: {
                actions: 'none',
            },
            counter: {
                enable: true,
            },
            cache: {
                enable: true,
                id: this.raw ? location.pathname : 'openmd',
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
            ],
            after: () => {
                if (this.raw) {
                    vditor.setValue(this.raw);
                }
            }
        });

        document.getElementById('go').addEventListener('click', () => {
            document.getElementsByName('markdown')[0].value = vditor.getValue();
            vditor.setValue('');
            document.forms['mainform'].submit();
        })
    }
}
