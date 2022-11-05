<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/decoupled-document/ckeditor.js"></script>

<div class="card">
    <div class="card-body">
        <div class="card-title">Kelola Hasil Ujian</div>
        <div class="document-editor">
            <div class="document-editor__toolbar"></div>
            <div class="document-editor__editable-container">
                <div class="document-editor__editable">
                    Editor content is inserted here.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .document-editor {
        border: 1px solid var(--ck-color-base-border);
        border-radius: var(--ck-border-radius);
        max-height: 700px;
        display: flex;
        flex-flow: column nowrap
    }

    .document-editor__toolbar {
        z-index: 1;
        box-shadow: 0 0 5px hsla(0, 0%, 0%, .2);
        border-bottom: 1px solid var(--ck-color-toolbar-border)
    }

    .document-editor__toolbar .ck-toolbar {
        border: 0;
        border-radius: 0
    }

    .document-editor__editable-container {
        padding: calc(2 * var(--ck-spacing-large));
        background: var(--ck-color-base-foreground);
        overflow-y: scroll
    }

    .document-editor__editable-container .document-editor__editable.ck-editor__editable {
        width: 15.8cm;
        min-height: 21cm;
        padding: 1cm 2cm 2cm;
        border: 1px hsl(0, 0%, 82.7%) solid;
        border-radius: var(--ck-border-radius);
        background: white;
        box-shadow: 0 0 5px hsla(0, 0%, 0%, .1);
        margin: 0 auto
    }

    .main__content-wide .document-editor__editable-container .document-editor__editable.ck-editor__editable {
        width: 18cm
    }

    .document-editor .ck-content,
    .document-editor .ck-heading-dropdown .ck-list .ck-button__label {
        font: 16px/1.6 "Helvetica Neue", Helvetica, Arial, sans-serif
    }

    .document-editor .ck-heading-dropdown .ck-list .ck-button__label {
        line-height: calc(1.7 * var(--ck-line-height-base) * var(--ck-font-size-base));
        min-width: 6em
    }

    .document-editor .ck-heading-dropdown .ck-list .ck-heading_heading1 .ck-button__label,
    .document-editor .ck-heading-dropdown .ck-list .ck-heading_heading2 .ck-button__label {
        transform: scale(0.8);
        transform-origin: left
    }

    .document-editor .ck-content h2,
    .document-editor .ck-heading-dropdown .ck-heading_heading1 .ck-button__label {
        font-size: 2.18em;
        font-weight: normal
    }

    .document-editor .ck-content h2 {
        line-height: 1.37em;
        padding-top: .342em;
        margin-bottom: .142em
    }

    .document-editor .ck-content h3,
    .document-editor .ck-heading-dropdown .ck-heading_heading2 .ck-button__label {
        font-size: 1.75em;
        font-weight: normal;
        color: hsl(203, 100%, 50%)
    }

    .document-editor .ck-heading-dropdown .ck-heading_heading2.ck-on .ck-button__label {
        color: var(--ck-color-list-button-on-text)
    }

    .document-editor .ck-content h3 {
        line-height: 1.86em;
        padding-top: .171em;
        margin-bottom: .357em
    }

    .document-editor .ck-content h4,
    .document-editor .ck-heading-dropdown .ck-heading_heading3 .ck-button__label {
        font-size: 1.31em;
        font-weight: bold
    }

    .document-editor .ck-content h4 {
        line-height: 1.24em;
        padding-top: .286em;
        margin-bottom: .952em
    }

    .document-editor .ck-content blockquote {
        font-family: Georgia, serif;
        margin-left: calc(2 * var(--ck-spacing-large));
        margin-right: calc(2 * var(--ck-spacing-large))
    }

    @media only screen and (max-width: 960px) {
        .document-editor__editable-container .document-editor__editable.ck-editor__editable {
            padding: 1.5em
        }
    }

    @media only screen and (max-width: 1200px) {
        .main__content-wide .document-editor__editable-container .document-editor__editable.ck-editor__editable {
            width: 100%
        }
    }

    @media only screen and (min-width: 1360px) {
        .main .main__content.main__content-wide {
            padding-right: 0
        }
    }

    @media only screen and (min-width: 1600px) {
        .main .main__content.main__content-wide {
            width: 24cm
        }

        .main .main__content.main__content-wide .main__content-inner {
            width: auto;
            margin: 0 50px
        }

        .main__content-wide .document-editor__editable-container .document-editor__editable.ck-editor__editable {
            width: 60%
        }
    }
</style>

<script>
    DecoupledEditor.create(document.querySelector('.document-editor__editable')).then(editor => {
        const toolbarContainer = document.querySelector('.document-editor__toolbar');
        toolbarContainer.appendChild(editor.ui.view.toolbar.element);
        window.editor = editor;
    }).catch(err => {
        console.error(err);
    });
</script>