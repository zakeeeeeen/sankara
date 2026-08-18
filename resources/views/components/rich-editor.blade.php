@props([
    'placeholder' => 'Tulis konten deskripsi lengkap di sini...',
    'minHeight' => '160px',
])

@php
    $wireModel = $attributes->wire('model')->value();
@endphp

<div
    x-data="richEditor({
        content: @if($wireModel) @entangle($attributes->wire('model')) @else '' @endif,
        placeholder: '{{ $placeholder }}'
    })"
    wire:ignore
    {{ $attributes->whereDoesntStartWith('wire:model')->class([
        'relative rounded-2xl border border-slate-200/90 bg-white shadow-2xs transition-all focus-within:border-sky-500 focus-within:ring-2 focus-within:ring-sky-500/20',
    ]) }}
>
    <!-- TOOLBAR -->
    <div class="flex flex-wrap items-center gap-1 border-b border-slate-100 bg-slate-50/75 px-3 py-2 rounded-t-2xl">
        <!-- HEADINGS -->
        <div class="flex items-center rounded-xl bg-white border border-slate-200/80 p-0.5 shadow-2xs">
            <button
                type="button"
                @click="setHeading(0)"
                :class="isActive('paragraph') && !isActive('heading') ? 'bg-sky-500 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="rounded-lg px-2 py-1 text-xs transition"
                title="Normal Paragraph"
            >
                P
            </button>
            <button
                type="button"
                @click="setHeading(1)"
                :class="isActive('heading', { level: 1 }) ? 'bg-sky-500 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="rounded-lg px-2 py-1 text-xs font-semibold transition"
                title="Heading 1"
            >
                H1
            </button>
            <button
                type="button"
                @click="setHeading(2)"
                :class="isActive('heading', { level: 2 }) ? 'bg-sky-500 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="rounded-lg px-2 py-1 text-xs font-semibold transition"
                title="Heading 2"
            >
                H2
            </button>
            <button
                type="button"
                @click="setHeading(3)"
                :class="isActive('heading', { level: 3 }) ? 'bg-sky-500 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="rounded-lg px-2 py-1 text-xs font-semibold transition"
                title="Heading 3"
            >
                H3
            </button>
            <button
                type="button"
                @click="setHeading(4)"
                :class="isActive('heading', { level: 4 }) ? 'bg-sky-500 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="rounded-lg px-2 py-1 text-xs font-semibold transition"
                title="Heading 4"
            >
                H4
            </button>
        </div>

        <div class="h-5 w-px bg-slate-200 mx-1"></div>

        <!-- TEXT STYLE (BOLD, ITALIC) -->
        <div class="flex items-center rounded-xl bg-white border border-slate-200/80 p-0.5 shadow-2xs">
            <button
                type="button"
                @click="toggleBold()"
                :class="isActive('bold') ? 'bg-sky-500 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="grid h-7 w-7 place-items-center rounded-lg text-xs transition"
                title="Bold (Ctrl+B)"
            >
                <i class="fa-solid fa-bold"></i>
            </button>
            <button
                type="button"
                @click="toggleItalic()"
                :class="isActive('italic') ? 'bg-sky-500 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="grid h-7 w-7 place-items-center rounded-lg text-xs transition"
                title="Italic (Ctrl+I)"
            >
                <i class="fa-solid fa-italic"></i>
            </button>
        </div>

        <div class="h-5 w-px bg-slate-200 mx-1"></div>

        <!-- LISTS (UNORDERED, ORDERED) -->
        <div class="flex items-center rounded-xl bg-white border border-slate-200/80 p-0.5 shadow-2xs">
            <button
                type="button"
                @click="toggleBulletList()"
                :class="isActive('bulletList') ? 'bg-sky-500 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="grid h-7 w-7 place-items-center rounded-lg text-xs transition"
                title="Bullet List"
            >
                <i class="fa-solid fa-list-ul"></i>
            </button>
            <button
                type="button"
                @click="toggleOrderedList()"
                :class="isActive('orderedList') ? 'bg-sky-500 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="grid h-7 w-7 place-items-center rounded-lg text-xs transition"
                title="Numbered List"
            >
                <i class="fa-solid fa-list-ol"></i>
            </button>
        </div>

        <div class="h-5 w-px bg-slate-200 mx-1"></div>

        <!-- QUOTE & CODE BLOCK -->
        <div class="flex items-center rounded-xl bg-white border border-slate-200/80 p-0.5 shadow-2xs">
            <button
                type="button"
                @click="toggleBlockquote()"
                :class="isActive('blockquote') ? 'bg-sky-500 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="grid h-7 w-7 place-items-center rounded-lg text-xs transition"
                title="Blockquote"
            >
                <i class="fa-solid fa-quote-left"></i>
            </button>
            <button
                type="button"
                @click="toggleCodeBlock()"
                :class="isActive('codeBlock') ? 'bg-sky-500 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="grid h-7 w-7 place-items-center rounded-lg text-xs transition"
                title="Code Block"
            >
                <i class="fa-solid fa-code"></i>
            </button>
        </div>

        <div class="h-5 w-px bg-slate-200 mx-1"></div>

        <!-- LINK -->
        <button
            type="button"
            @click="openLinkModal()"
            :class="isActive('link') ? 'bg-sky-500 text-white shadow-xs' : 'bg-white border border-slate-200/80 text-slate-600 hover:text-slate-900 hover:bg-slate-100 shadow-2xs'"
            class="grid h-8 w-8 place-items-center rounded-xl text-xs transition"
            title="Tautan / Link"
        >
            <i class="fa-solid fa-link"></i>
        </button>

        <!-- TABLE DROPDOWN -->
        <div class="relative" @click.outside="showTableMenu = false">
            <button
                type="button"
                @click="showTableMenu = !showTableMenu"
                :class="isActive('table') ? 'bg-sky-500 text-white shadow-xs' : 'bg-white border border-slate-200/80 text-slate-600 hover:text-slate-900 hover:bg-slate-100 shadow-2xs'"
                class="flex items-center gap-1.5 rounded-xl px-2.5 h-8 text-xs font-semibold transition"
                title="Kelola Tabel"
            >
                <i class="fa-solid fa-table"></i>
                <span class="text-[11px] hidden sm:inline">Tabel</span>
                <i class="fa-solid fa-chevron-down text-[9px] opacity-70"></i>
            </button>

            <!-- TABLE ACTIONS MENU -->
            <div
                x-show="showTableMenu"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute left-0 top-full mt-1.5 z-30 w-48 rounded-2xl border border-slate-200 bg-white p-1.5 shadow-xl text-xs"
                x-cloak
            >
                <button
                    type="button"
                    @click="insertTable()"
                    class="w-full flex items-center gap-2 rounded-xl px-3 py-2 text-left text-slate-700 hover:bg-sky-50 hover:text-sky-700 transition"
                >
                    <i class="fa-solid fa-plus text-sky-500 w-4 text-center"></i>
                    <span>Sisipkan Tabel (3x3)</span>
                </button>

                <div class="h-px bg-slate-100 my-1"></div>

                <button
                    type="button"
                    @click="addRowAfter(); showTableMenu = false"
                    class="w-full flex items-center gap-2 rounded-xl px-3 py-1.5 text-left text-slate-700 hover:bg-slate-50 transition"
                >
                    <i class="fa-solid fa-arrows-split-up-and-left text-slate-400 w-4 text-center"></i>
                    <span>Tambah Baris</span>
                </button>
                <button
                    type="button"
                    @click="addColumnAfter(); showTableMenu = false"
                    class="w-full flex items-center gap-2 rounded-xl px-3 py-1.5 text-left text-slate-700 hover:bg-slate-50 transition"
                >
                    <i class="fa-solid fa-table-columns text-slate-400 w-4 text-center"></i>
                    <span>Tambah Kolom</span>
                </button>
                <button
                    type="button"
                    @click="deleteRow(); showTableMenu = false"
                    class="w-full flex items-center gap-2 rounded-xl px-3 py-1.5 text-left text-rose-600 hover:bg-rose-50 transition"
                >
                    <i class="fa-solid fa-minus text-rose-500 w-4 text-center"></i>
                    <span>Hapus Baris</span>
                </button>
                <button
                    type="button"
                    @click="deleteColumn(); showTableMenu = false"
                    class="w-full flex items-center gap-2 rounded-xl px-3 py-1.5 text-left text-rose-600 hover:bg-rose-50 transition"
                >
                    <i class="fa-solid fa-trash-can text-rose-500 w-4 text-center"></i>
                    <span>Hapus Kolom</span>
                </button>

                <div class="h-px bg-slate-100 my-1"></div>

                <button
                    type="button"
                    @click="deleteTable()"
                    class="w-full flex items-center gap-2 rounded-xl px-3 py-1.5 text-left text-rose-600 hover:bg-rose-50 font-bold transition"
                >
                    <i class="fa-solid fa-trash text-rose-500 w-4 text-center"></i>
                    <span>Hapus Tabel</span>
                </button>
            </div>
        </div>

        <div class="flex-1"></div>

        <!-- UNDO & REDO -->
        <div class="flex items-center rounded-xl bg-white border border-slate-200/80 p-0.5 shadow-2xs">
            <button
                type="button"
                @click="undo()"
                :disabled="!canUndo()"
                class="grid h-7 w-7 place-items-center rounded-lg text-xs text-slate-600 hover:text-slate-900 hover:bg-slate-100 disabled:opacity-30 disabled:hover:bg-transparent transition"
                title="Undo (Ctrl+Z)"
            >
                <i class="fa-solid fa-rotate-left"></i>
            </button>
            <button
                type="button"
                @click="redo()"
                :disabled="!canRedo()"
                class="grid h-7 w-7 place-items-center rounded-lg text-xs text-slate-600 hover:text-slate-900 hover:bg-slate-100 disabled:opacity-30 disabled:hover:bg-transparent transition"
                title="Redo (Ctrl+Y)"
            >
                <i class="fa-solid fa-rotate-right"></i>
            </button>
        </div>
    </div>

    <!-- LINK MODAL / POPOVER -->
    <div
        x-show="showLinkModal"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="border-b border-sky-100 bg-sky-50/70 p-3 flex flex-col sm:flex-row items-stretch sm:items-center gap-2"
        x-cloak
    >
        <div class="flex-1 flex items-center gap-2 rounded-xl bg-white border border-sky-200 px-3 py-1.5 shadow-2xs">
            <i class="fa-solid fa-link text-sky-500 text-xs"></i>
            <input
                type="url"
                x-ref="linkInput"
                x-model="linkUrl"
                @keydown.enter.prevent="applyLink()"
                @keydown.escape="showLinkModal = false"
                placeholder="https://example.com"
                class="w-full text-xs text-slate-800 bg-transparent outline-none placeholder:text-slate-400"
            />
        </div>
        <div class="flex items-center gap-1.5 justify-end">
            <button
                type="button"
                @click="applyLink()"
                class="rounded-xl bg-sky-600 px-3 py-1.5 text-xs font-bold text-white hover:bg-sky-700 shadow-xs transition"
            >
                Pasang Link
            </button>
            <button
                type="button"
                @click="unsetLink()"
                x-show="isActive('link')"
                class="rounded-xl bg-rose-50 border border-rose-200 px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-100 transition"
            >
                Hapus
            </button>
            <button
                type="button"
                @click="showLinkModal = false"
                class="rounded-xl border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 transition"
            >
                Batal
            </button>
        </div>
    </div>

    <!-- PROSE CONTAINER / TIPTAP EDITOR -->
    <div
        x-ref="editorElement"
        class="prose prose-slate max-w-none prose-headings:font-bold prose-a:text-sky-600 prose-blockquote:border-sky-500 overflow-y-auto"
        style="min-height: {{ $minHeight }};"
    ></div>
</div>
