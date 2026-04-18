@extends('layout.admin')

@section('title', 'SignLearn - Modul Pembelajaran')

@section('content')

{{-- Header --}}
<div class="flex justify-between items-start mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-800">Modul Pembelajaran</h1>
        <p class="text-gray-400 text-sm mt-1">Kelola modul BISINDO & SIBI beserta huruf A-Z dan referensinya</p>
    </div>
    <button id="btnTambahSoal"
            class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-bold shadow transition hover:opacity-90"
            style="background-color: #4A1A6B;">
        + Tambah Soal
    </button>
</div>

{{-- Statistik Cards --}}
<div class="grid grid-cols-2 gap-4 mb-8 max-w-sm">

    {{-- Total Kuis --}}
    <div class="bg-red-100 rounded-2xl shadow-sm border border-red-200 p-5 text-center">
        <p class="text-4xl font-extrabold text-red-700 mb-1">1</p>
        <p class="text-sm font-bold text-red-600">Total Kuis</p>
    </div>

    {{-- Level Kuis --}}
    <div class="bg-green-100 rounded-2xl shadow-sm border border-green-200 p-5 text-center">
        <p class="text-4xl font-extrabold text-green-700 mb-1">3</p>
        <p class="text-sm font-bold text-green-600">Level Kuis</p>
    </div>

</div>

{{-- Tabel --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

    {{-- Search --}}
    <div class="mb-4">
        <div class="flex items-center gap-2 border border-gray-200 rounded-xl px-4 py-2 w-52 bg-gray-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Pencarian"
                   class="bg-transparent text-sm text-gray-500 focus:outline-none w-full" />
        </div>
    </div>

    {{-- Header Tabel --}}
<div class="grid text-sm font-bold text-gray-700 px-4 mb-2" style="grid-template-columns: 60px 1fr 1fr 1fr 1fr 1fr;">
    <span>No</span>
    <span>Nama Kuis</span>
    <span>Level</span>
    <span>Jumlah</span>
    <span>Status</span>
    <span>Aksi</span>
</div>
<hr class="border-gray-200 mb-3">

{{-- Rows --}}
<div class="space-y-2" id="modulList">
    @php
        $moduls = [
            ['no' => 1, 'nama' => 'Pemula 1', 'level' => 'Pemula', 'jumlah' => '3 Soal', 'status' => 'Aktif'],
            ['no' => 2, 'nama' => 'Pemula 2', 'level' => 'Pemula', 'jumlah' => '5 Soal', 'status' => 'Aktif'],
            ['no' => 3, 'nama' => 'Menengah 1', 'level' => 'Menengah', 'jumlah' => '4 Soal', 'status' => 'Non Aktif'],
        ];
    @endphp

    @foreach($moduls as $modul)
    <div class="modul-row grid items-center bg-white border border-gray-100 rounded-xl px-4 py-3 shadow-sm text-sm"
         style="grid-template-columns: 60px 1fr 1fr 1fr 1fr 1fr;">
        <span class="text-gray-700 font-semibold">{{ $modul['no'] }}</span>
        <span class="font-bold text-gray-800 modul-nama">{{ $modul['nama'] }}</span>
        <span class="text-gray-500 modul-level">{{ $modul['level'] }}</span>
        <span class="text-gray-500">{{ $modul['jumlah'] }}</span>
        <span>
            @if($modul['status'] === 'Aktif')
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-600">Aktif</span>
            @else
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-500">Non Aktif</span>
            @endif
        </span>
        <span class="flex items-center gap-2">
            <button onclick="openEditModal(this)"
                    data-nama="{{ $modul['nama'] }}"
                    data-level="{{ $modul['level'] }}"
                    data-jumlah="{{ str_replace(' Soal', '', $modul['jumlah']) }}"
                    data-status="{{ $modul['status'] }}"
                    class="px-3 py-1 rounded-lg text-xs font-bold border-2 border-yellow-400 text-yellow-600 hover:bg-yellow-50 transition">
                Edit
            </button>
            <button class="text-gray-500 hover:text-red-500 transition" onclick="confirmDelete(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </span>
    </div>
    @endforeach

    <div id="emptyMsg" class="hidden text-center text-gray-400 text-sm py-6">
        Tidak ada modul yang ditemukan.
    </div>
</div>

</div>

{{-- Modal Tambah Soal --}}
<div id="modalTambah" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-extrabold text-gray-800">Tambah Soal</h3>
            <button onclick="closeModal('modalTambah')" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
        </div>
        <div class="space-y-3">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Nama Kuis</label>
                <input type="text" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300" />
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Level</label>
                <select class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <option>Pemula</option>
                    <option>Menengah</option>
                    <option>Mahir</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Jumlah Soal</label>
                <input type="number" min="1" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300" />
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Status</label>
                <select class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <option>Aktif</option>
                    <option>Non Aktif</option>
                </select>
            </div>
            <button class="w-full py-2.5 rounded-xl text-white text-sm font-bold mt-2 hover:opacity-90 transition"
                    style="background-color: #4A1A6B;">
                Simpan
            </button>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div id="modalEdit" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-extrabold text-gray-800">Edit Soal</h3>
            <button onclick="closeModal('modalEdit')" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
        </div>
        <div class="space-y-3">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Nama Kuis</label>
                <input type="text" id="editNama" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300" />
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Level</label>
                <select id="editLevel" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <option>Pemula</option>
                    <option>Menengah</option>
                    <option>Mahir</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Jumlah Soal</label>
                <input type="number" id="editJumlah" min="1" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300" />
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Status</label>
                <select id="editStatus" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <option>Aktif</option>
                    <option>Non Aktif</option>
                </select>
            </div>
            <button class="w-full py-2.5 rounded-xl text-white text-sm font-bold mt-2 hover:opacity-90 transition"
                    style="background-color: #4A1A6B;">
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Buka modal tambah
    document.getElementById('btnTambahSoal').addEventListener('click', function () {
        document.getElementById('modalTambah').style.display = 'flex';
    });

    // Buka modal edit
    function openEditModal(btn) {
        document.getElementById('editNama').value = btn.dataset.nama;
        document.getElementById('editLevel').value = btn.dataset.level;
        document.getElementById('editJumlah').value = btn.dataset.jumlah;
        document.getElementById('editStatus').value = btn.dataset.status;
        document.getElementById('modalEdit').style.display = 'flex';
    }

    // Tutup modal
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    // Klik luar modal
    ['modalTambah', 'modalEdit'].forEach(id => {
        document.getElementById(id).addEventListener('click', function (e) {
            if (e.target === this) closeModal(id);
        });
    });

    // Hapus baris
    function confirmDelete(btn) {
        if (confirm('Yakin ingin menghapus modul ini?')) {
            btn.closest('.modul-row').remove();
            checkEmpty();
        }
    }

    function checkEmpty() {
        const rows = document.querySelectorAll('.modul-row:not([style*="display: none"])');
        document.getElementById('emptyMsg').classList.toggle('hidden', rows.length > 0);
    }

    // Search realtime
    document.getElementById('searchInput').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.modul-row').forEach(row => {
            const nama = row.querySelector('.modul-nama').innerText.toLowerCase();
            const level = row.querySelector('.modul-level').innerText.toLowerCase();
            row.style.display = (nama.includes(keyword) || level.includes(keyword)) ? '' : 'none';
        });
        checkEmpty();
    });
</script>
@endpush

@endsection

