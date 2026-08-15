@extends('layouts.admin')

@section('title', 'Kategori Portofolio - Admin Sankara Tech')
@section('page_title', 'Kategori Portofolio')
@section('page_subtitle', 'Kategori dipakai untuk filter di halaman portofolio')

@section('content')
    <div x-data="{ createModalOpen: false, editModalOpen: false, editCat: { id: '', name: '', slug: '', sort_order: 0 } }">
        <div class="reveal flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Kategori Portofolio</h1>
                <p class="mt-1 text-sm text-slate-600">Daftar kategori untuk mengelompokkan project portofolio.</p>
            </div>

            <div class="flex items-center gap-3">
                <button
                    type="button"
                    @click="createModalOpen = true"
                    class="brand-gradient inline-flex items-center justify-center gap-2 rounded-2xl px-5 py-2.5 text-sm font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5"
                >
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Kategori</span>
                </button>
            </div>
        </div>

        @if (session('status'))
            <div class="mt-6 rounded-2xl border border-emerald-200/70 bg-gradient-to-r from-emerald-50 to-cyan-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="mt-8 overflow-hidden rounded-[2rem] border border-slate-200/70 bg-white/90 shadow-sm backdrop-blur">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-200/60 bg-slate-50/50 text-xs font-semibold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th class="px-6 py-4">Nama Kategori</th>
                            <th class="px-6 py-4">Slug</th>
                            <th class="px-6 py-4 text-center">Urutan</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/60">
                        @forelse ($categories as $cat)
                            <tr class="text-slate-800 transition hover:bg-slate-50/60">
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    <div class="flex items-center gap-3">
                                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-sky-50 text-sky-600">
                                            <i class="fa-solid fa-folder text-xs"></i>
                                        </span>
                                        <span>{{ $cat->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $cat->slug }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex rounded-xl bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        {{ $cat->sort_order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <button
                                            type="button"
                                            @click="editCat = { id: '{{ $cat->id }}', name: '{{ addslashes($cat->name) }}', slug: '{{ addslashes($cat->slug) }}', sort_order: {{ $cat->sort_order }} }; editModalOpen = true"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200/70 bg-white/80 px-3.5 py-1.5 text-xs font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white"
                                        >
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                            <span>Edit</span>
                                        </button>

                                        <form method="POST" action="{{ route('admin.portfolio-categories.destroy', $cat) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200/70 bg-rose-50 px-3.5 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">
                                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-sm font-medium text-slate-500">
                                    Belum ada kategori portofolio. Klik tombol "Tambah Kategori" untuk membuat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- CREATE MODAL -->
        <div
            x-show="createModalOpen"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
            <div class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm" @click="createModalOpen = false"></div>

            <div class="relative w-full max-w-md rounded-3xl border border-slate-200/70 bg-white p-6 shadow-2xl transition sm:p-8">
                <div class="flex items-center justify-between">
                    <div class="text-lg font-bold text-slate-900">Tambah Kategori</div>
                    <button type="button" @click="createModalOpen = false" class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-500 hover:bg-slate-100">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <form class="mt-6 space-y-4" method="POST" action="{{ route('admin.portfolio-categories.store') }}">
                    @csrf
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Nama Kategori</label>
                        <input name="name" placeholder="cth. Web Application" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white" required />
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Slug (Opsional)</label>
                        <input name="slug" placeholder="cth. web-application" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white" />
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Urutan (Sort Order)</label>
                        <input type="number" name="sort_order" value="0" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white" />
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 pt-2">
                        <button type="button" @click="createModalOpen = false" class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="brand-gradient rounded-2xl px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div
            x-show="editModalOpen"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
            <div class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm" @click="editModalOpen = false"></div>

            <div class="relative w-full max-w-md rounded-3xl border border-slate-200/70 bg-white p-6 shadow-2xl transition sm:p-8">
                <div class="flex items-center justify-between">
                    <div class="text-lg font-bold text-slate-900">Edit Kategori</div>
                    <button type="button" @click="editModalOpen = false" class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-500 hover:bg-slate-100">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <form class="mt-6 space-y-4" method="POST" :action="'{{ url('admin/portfolio-categories') }}/' + editCat.id">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Nama Kategori</label>
                        <input name="name" x-model="editCat.name" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white" required />
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Slug</label>
                        <input name="slug" x-model="editCat.slug" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white" />
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Urutan (Sort Order)</label>
                        <input type="number" name="sort_order" x-model="editCat.sort_order" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white" />
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 pt-2">
                        <button type="button" @click="editModalOpen = false" class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="brand-gradient rounded-2xl px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

