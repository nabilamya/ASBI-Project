@extends('layout.admin')

@section('title', 'SignLearn - Kelola Akun Pengguna')

@section('content')

{{-- Header --}}
<div class="flex justify-between items-start mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-800">Kelola Akun Pengguna</h1>
        <p class="text-gray-400 text-sm mt-1">Kelola Akun Pengguna dan edit pengguna.</p>
    </div>
    <button id="btnTambahAkun"
            class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-bold shadow transition hover:opacity-90"
            style="background-color: #4A1A6B;">
        + Tambah Akun
    </button>
</div>

{{-- Statistik Cards --}}
<div class="grid grid-cols-3 gap-4 mb-8">

    {{-- Total Pengguna --}}
    <div class="rounded-2xl p-5" style="background-color: #BAE6FD;">
        <div class="flex items-center gap-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4.13a4 4 0 10-8 0 4 4 0 008 0z"/>
            </svg>
            <span class="text-3xl font-extrabold text-gray-800">150</span>
        </div>
        <p class="text-sm font-bold text-blue-600">Total Pengguna</p>
    </div>

    {{-- Pengguna Aktif --}}
    <div class="rounded-2xl p-5" style="background-color: #BBF7D0;">
        <div class="flex items-center gap-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4.13a4 4 0 10-8 0 4 4 0 008 0z"/>
            </svg>
            <span class="text-3xl font-extrabold text-gray-800">100</span>
        </div>
        <p class="text-sm font-bold text-green-600">Pengguna Aktif</p>
    </div>

    {{-- Pengguna Non Aktif --}}
    <div class="rounded-2xl p-5" style="background-color: #FCA5A5;">
        <div class="flex items-center gap-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4.13a4 4 0 10-8 0 4 4 0 008 0z"/>
            </svg>
            <span class="text-3xl font-extrabold text-gray-800">50</span>
        </div>
        <p class="text-sm font-bold text-red-500">Pengguna Non Aktif</p>
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
    <div class="grid grid-cols-4 text-sm font-bold text-gray-700 px-4 mb-2">
        <span>Nama Pengguna</span>
        <span>Gmail</span>
        <span>Status</span>
        <span>Aksi</span>
    </div>
    <hr class="border-gray-200 mb-3">

    {{-- Rows --}}
    <div class="space-y-2" id="userList">
        @php
            $users = [
                ['nama' => 'Arabella', 'email' => 'arabella@mail.com', 'status' => 'Non Aktif'],
                ['nama' => 'Budi Santoso', 'email' => 'budi@mail.com', 'status' => 'Aktif'],
                ['nama' => 'Citra Dewi', 'email' => 'citra@mail.com', 'status' => 'Non Aktif'],
                ['nama' => 'Dian Sastro', 'email' => 'dian@mail.com', 'status' => 'Aktif'],
                ['nama' => 'Eko Prasetyo', 'email' => 'eko@mail.com', 'status' => 'Non Aktif'],
            ];
        @endphp

        @foreach($users as $user)
        <div class="user-row grid grid-cols-4 items-center bg-white border border-gray-100 rounded-xl px-4 py-3 shadow-sm text-sm">
            <span class="font-semibold text-gray-800 user-name">{{ $user['nama'] }}</span>
            <span class="text-gray-500 user-email">{{ $user['email'] }}</span>
            <span class="user-status">
                @if($user['status'] === 'Aktif')
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-600">Aktif</span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-500">Non Aktif</span>
                @endif
            </span>
            <span class="flex items-center gap-2">
                {{-- Tombol Edit --}}
                <button class="text-blue-500 hover:text-blue-700 transition" onclick="editUser(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </button>
                {{-- Tombol Hapus --}}
                <button class="text-gray-500 hover:text-red-500 transition" onclick="confirmDelete(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </span>
        </div>
        @endforeach

        {{-- Pesan kosong saat search tidak ditemukan --}}
        <div id="emptyMsg" class="hidden text-center text-gray-400 text-sm py-6">
            Tidak ada pengguna yang ditemukan.
        </div>
    </div>

</div>

{{-- Modal Tambah / Edit Akun --}}
<div id="modalTambah" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 id="modalTitle" class="text-lg font-extrabold text-gray-800">Tambah Akun Pengguna</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
        </div>
        <div class="space-y-3">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Nama Lengkap</label>
                <input type="text" id="editNama" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300" />
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Email</label>
                <input type="email" id="editEmail" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300" />
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Password</label>
                <input type="password" id="editPassword" autocomplete="new-password" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300" placeholder="Kosongkan jika tidak diubah" />
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Status</label>
                <select id="editStatus" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <option value="Aktif">Aktif</option>
                    <option value="Non Aktif">Non Aktif</option>
                </select>
            </div>
            <button id="btnSimpan" class="w-full py-2.5 rounded-xl text-white text-sm font-bold mt-2 hover:opacity-90 transition"
                    style="background-color: #4A1A6B;">
                Simpan
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentEditRow = null; // menyimpan baris yang sedang diedit

    // Buka modal untuk tambah
    document.getElementById('btnTambahAkun').addEventListener('click', function () {
        currentEditRow = null;
        document.getElementById('modalTitle').innerText = 'Tambah Akun Pengguna';
        document.getElementById('editNama').value = '';
        document.getElementById('editEmail').value = '';
        document.getElementById('editPassword').value = '';
        document.getElementById('editStatus').value = 'Aktif';
        document.getElementById('modalTambah').style.display = 'flex';
    });

    // Tutup modal
    function closeModal() {
        document.getElementById('modalTambah').style.display = 'none';
    }

    // Klik luar modal
    document.getElementById('modalTambah').addEventListener('click', function (e) {
        if (e.target === this) closeModal();
    });

    // Fungsi edit: isi modal dengan data baris
    function editUser(btn) {
        currentEditRow = btn.closest('.user-row');
        const nama = currentEditRow.querySelector('.user-name').innerText;
        const email = currentEditRow.querySelector('.user-email').innerText;
        const statusSpan = currentEditRow.querySelector('.user-status span');
        let status = '';
        if (statusSpan.classList.contains('bg-green-100')) status = 'Aktif';
        else status = 'Non Aktif';

        document.getElementById('modalTitle').innerText = 'Edit Akun Pengguna';
        document.getElementById('editNama').value = nama;
        document.getElementById('editEmail').value = email;
        document.getElementById('editPassword').value = ''; // kosongkan untuk keamanan
        document.getElementById('editStatus').value = status;
        document.getElementById('modalTambah').style.display = 'flex';
    }

    // Simpan (tambah atau edit)
    document.getElementById('btnSimpan').addEventListener('click', function () {
        const nama = document.getElementById('editNama').value.trim();
        const email = document.getElementById('editEmail').value.trim();
        const status = document.getElementById('editStatus').value;
        const password = document.getElementById('editPassword').value;

        if (!nama || !email) {
            alert('Nama dan Email harus diisi!');
            return;
        }

        if (currentEditRow === null) {
            // TAMBAH AKUN BARU
            const userList = document.getElementById('userList');
            const newRow = document.createElement('div');
            newRow.className = 'user-row grid grid-cols-4 items-center bg-white border border-gray-100 rounded-xl px-4 py-3 shadow-sm text-sm';
            newRow.innerHTML = `
                <span class="font-semibold text-gray-800 user-name">${escapeHtml(nama)}</span>
                <span class="text-gray-500 user-email">${escapeHtml(email)}</span>
                <span class="user-status">
                    ${status === 'Aktif'
                        ? '<span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-600">Aktif</span>'
                        : '<span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-500">Non Aktif</span>'}
                </span>
                <span class="flex items-center gap-2">
                    <button class="text-blue-500 hover:text-blue-700 transition" onclick="editUser(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </button>
                    <button class="text-gray-500 hover:text-red-500 transition" onclick="confirmDelete(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </span>
            `;
            // Sisipkan sebelum emptyMsg
            const emptyMsg = document.getElementById('emptyMsg');
            userList.insertBefore(newRow, emptyMsg);
            // Update statistik (opsional, bisa hitung ulang)
            updateStats();
        } else {
            // EDIT AKUN
            currentEditRow.querySelector('.user-name').innerText = nama;
            currentEditRow.querySelector('.user-email').innerText = email;
            const statusSpan = currentEditRow.querySelector('.user-status');
            statusSpan.innerHTML = status === 'Aktif'
                ? '<span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-600">Aktif</span>'
                : '<span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-500">Non Aktif</span>';
        }

        // Reset password field (tidak disimpan ke localStorage/demo)
        closeModal();

        // Update statistik card
        updateStats();
    });

    // Hapus baris
    function confirmDelete(btn) {
        if (confirm('Yakin ingin menghapus pengguna ini?')) {
            btn.closest('.user-row').remove();
            updateStats();
            checkEmpty();
        }
    }

    // Cek kalau list kosong
    function checkEmpty() {
        const rows = document.querySelectorAll('.user-row:not([style*="display: none"])');
        document.getElementById('emptyMsg').classList.toggle('hidden', rows.length > 0);
    }

    // Search realtime
    document.getElementById('searchInput').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.user-row').forEach(row => {
            const nama = row.querySelector('.user-name').innerText.toLowerCase();
            const email = row.querySelector('.user-email').innerText.toLowerCase();
            row.style.display = (nama.includes(keyword) || email.includes(keyword)) ? '' : 'none';
        });
        checkEmpty();
    });

    // Update statistik cards (total, aktif, nonaktif)
    function updateStats() {
        const rows = document.querySelectorAll('.user-row');
        let total = rows.length;
        let aktif = 0;
        rows.forEach(row => {
            const statusText = row.querySelector('.user-status span').innerText;
            if (statusText === 'Aktif') aktif++;
        });
        const nonAktif = total - aktif;
        document.querySelector('.rounded-2xl .text-3xl').innerText = total;
        // Update card aktif dan nonaktif (mencari berdasarkan posisi)
        const cards = document.querySelectorAll('.rounded-2xl p.text-sm.font-bold');
        // Card total sudah di-update, sekarang cari card aktif dan nonaktif
        const allStats = document.querySelectorAll('.grid.grid-cols-3.gap-4 .rounded-2xl');
        if (allStats.length >= 3) {
            allStats[1].querySelector('.text-3xl').innerText = aktif;
            allStats[2].querySelector('.text-3xl').innerText = nonAktif;
        }
    }

    // Helper escape HTML
    function escapeHtml(str) {
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    // Inisialisasi statistik saat load
    updateStats();
    checkEmpty();
</script>
@endpush

@endsection
