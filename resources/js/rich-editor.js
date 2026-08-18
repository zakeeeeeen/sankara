import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import { Table } from '@tiptap/extension-table';
import TableRow from '@tiptap/extension-table-row';
import TableHeader from '@tiptap/extension-table-header';
import TableCell from '@tiptap/extension-table-cell';

export function richEditor(config = {}) {
    return {
        editor: null,
        content: config.content ?? '',
        placeholder: config.placeholder ?? 'Tulis konten di sini...',
        showLinkModal: false,
        linkUrl: '',
        showTableMenu: false,
        debounceTimer: null,
        isUpdatingFromLivewire: false,

        init() {
            const initialContent = this.content || '';

            this.editor = new Editor({
                element: this.$refs.editorElement,
                extensions: [
                    StarterKit.configure({
                        heading: {
                            levels: [1, 2, 3, 4],
                        },
                    }),
                    Link.configure({
                        openOnClick: false,
                        autolink: true,
                        linkOnPaste: true,
                        HTMLAttributes: {
                            class: 'text-sky-600 underline font-medium hover:text-sky-800',
                            target: '_blank',
                            rel: 'noopener noreferrer',
                        },
                    }),
                    Table.configure({
                        resizable: false,
                        HTMLAttributes: {
                            class: 'border-collapse w-full my-4 border border-slate-200 rounded-lg overflow-hidden',
                        },
                    }),
                    TableRow,
                    TableHeader,
                    TableCell,
                ],
                content: initialContent,
                editorProps: {
                    attributes: {
                        class: 'tiptap-content focus:outline-none min-h-[160px] p-4 text-slate-800 text-sm leading-relaxed',
                        'data-placeholder': this.placeholder,
                    },
                },
                onUpdate: ({ editor }) => {
                    if (this.isUpdatingFromLivewire) return;

                    const html = editor.isEmpty ? '' : editor.getHTML();

                    // Update local alpine content
                    clearTimeout(this.debounceTimer);
                    this.debounceTimer = setTimeout(() => {
                        this.content = html;
                    }, 300);
                },
                onSelectionUpdate: () => {
                    // Triggers Alpine reactivity for toolbar buttons active states
                    this.$nextTick();
                },
            });

            // Watch external Livewire content changes (e.g. initial load, reset, or server update)
            this.$watch('content', (newVal) => {
                if (!this.editor) return;

                const currentHtml = this.editor.isEmpty ? '' : this.editor.getHTML();
                const targetVal = newVal || '';

                if (targetVal !== currentHtml) {
                    this.isUpdatingFromLivewire = true;
                    this.editor.commands.setContent(targetVal, false);
                    this.isUpdatingFromLivewire = false;
                }
            });
        },

        destroy() {
            clearTimeout(this.debounceTimer);
            if (this.editor) {
                this.editor.destroy();
                this.editor = null;
            }
        },

        // Helper checks
        isActive(name, opts = {}) {
            return this.editor ? this.editor.isActive(name, opts) : false;
        },

        canUndo() {
            return this.editor ? this.editor.can().undo() : false;
        },

        canRedo() {
            return this.editor ? this.editor.can().redo() : false;
        },

        // Text formatting
        toggleBold() {
            this.editor?.chain().focus().toggleBold().run();
        },

        toggleItalic() {
            this.editor?.chain().focus().toggleItalic().run();
        },

        // Headings
        setHeading(level) {
            if (level === 0) {
                this.editor?.chain().focus().setParagraph().run();
            } else {
                this.editor?.chain().focus().toggleHeading({ level }).run();
            }
        },

        // Lists
        toggleBulletList() {
            this.editor?.chain().focus().toggleBulletList().run();
        },

        toggleOrderedList() {
            this.editor?.chain().focus().toggleOrderedList().run();
        },

        // Blockquote & Code Block
        toggleBlockquote() {
            this.editor?.chain().focus().toggleBlockquote().run();
        },

        toggleCodeBlock() {
            this.editor?.chain().focus().toggleCodeBlock().run();
        },

        // Link management
        openLinkModal() {
            const previousUrl = this.editor?.getAttributes('link').href || '';
            this.linkUrl = previousUrl;
            this.showLinkModal = true;
            this.$nextTick(() => {
                this.$refs.linkInput?.focus();
            });
        },

        applyLink() {
            if (!this.linkUrl || this.linkUrl.trim() === '') {
                this.editor?.chain().focus().extendMarkRange('link').unsetLink().run();
            } else {
                let url = this.linkUrl.trim();
                if (!/^https?:\/\//i.test(url) && !url.startsWith('/') && !url.startsWith('#') && !url.startsWith('mailto:')) {
                    url = 'https://' + url;
                }
                this.editor?.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
            }
            this.showLinkModal = false;
            this.linkUrl = '';
        },

        unsetLink() {
            this.editor?.chain().focus().unsetLink().run();
            this.showLinkModal = false;
        },

        // Table management
        insertTable() {
            this.editor?.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run();
            this.showTableMenu = false;
        },

        addRowAfter() {
            this.editor?.chain().focus().addRowAfter().run();
        },

        deleteRow() {
            this.editor?.chain().focus().deleteRow().run();
        },

        addColumnAfter() {
            this.editor?.chain().focus().addColumnAfter().run();
        },

        deleteColumn() {
            this.editor?.chain().focus().deleteColumn().run();
        },

        deleteTable() {
            this.editor?.chain().focus().deleteTable().run();
            this.showTableMenu = false;
        },

        // Utility
        clearFormatting() {
            this.editor?.chain().focus().clearNodes().unsetAllMarks().run();
        },

        undo() {
            this.editor?.chain().focus().undo().run();
        },

        redo() {
            this.editor?.chain().focus().redo().run();
        },
    };
}

// Attach to window so Alpine can access it
if (typeof window !== 'undefined') {
    window.richEditor = richEditor;
}
