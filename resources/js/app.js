import './bootstrap';

window.onload = function() {
    if (document.getElementById('area')) {
        const isDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const vditor = new Vditor('area', {
            height: '100%',
            mode: 'sv',
            theme: isDark ? 'dark': 'classic',
            preview: {
                actions: 'none',
                theme: {
                    current: isDark ? 'dark' : 'light',
                }
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

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            const isDark = event.matches;
            vditor.setTheme(isDark ? 'dark' : 'classic', isDark ? 'dark' : 'light');
        });

        document.getElementById('go').addEventListener('click', () => {
            document.getElementsByName('markdown')[0].value = vditor.getValue();
            // vditor.setValue('');
            document.forms['mainform'].submit();
        })
    }

    document.getElementById('png')?.addEventListener('click', () => {
        domtoimage.toBlob(document.getElementById('md'))
            .then(blob => window.saveAs(blob, 'exported.png'))
            .catch(e => console.error(e));
    });

    document.getElementById('pdf')?.addEventListener('click', () => {
        domtopdf(document.getElementById('md'), {
            filename: 'exported.pdf'
        }, (pdf) => {
            console.log('done');
        });
    });

    // document.getElementById('spam')?.addEventListener('click', () => {
    //     toggle('report')
    // });
}
