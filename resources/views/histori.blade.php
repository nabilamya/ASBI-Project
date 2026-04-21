@extends('layout.app')
@section('title', 'SignLearn - Riwayat Belajar')
@section('content')

@include('layout.navbar')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');
  * { font-family: 'Poppins', sans-serif; }

  @keyframes fadeUp {
    from { opacity:0; transform:translateY(24px); }
    to   { opacity:1; transform:translateY(0); }
  }
  @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
  @keyframes popIn {
    0%   { transform:scale(0.90); opacity:0; }
    70%  { transform:scale(1.03); }
    100% { transform:scale(1);    opacity:1; }
  }

  .histori-wrapper {
    background: linear-gradient(160deg, #FFE8F4 0%, #FFF0F8 40%, #FDE6F2 100%);
    min-height: 100vh;
  }

  /* ── HEADER ── */
  .histori-header { padding: 36px 48px 0; animation: fadeUp 0.6s ease; }
  .histori-header-card {
    background: #fff; border-radius: 22px; padding: 28px 32px;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 6px 28px rgba(200,45,133,0.10); border: 1.5px solid #F7DAED;
    margin-bottom: 32px; transition: box-shadow 0.3s, transform 0.3s;
  }
  .histori-header-card:hover { box-shadow: 0 14px 40px rgba(200,45,133,0.16); transform: translateY(-2px); }
  .histori-header-text h1 { font-size: clamp(1.5rem,3vw,2rem); font-weight: 800; color: #C82D85; margin-bottom: 6px; }
  .histori-header-text p  { font-size: 0.95rem; color: #7A4B78; font-weight: 500; }
  /*
    Icon header kanan — taruh file di:
    public/assets/icon-histori.png
  */
  .histori-header-img {
    width: 72px; height: 72px; object-fit: contain; flex-shrink: 0;
    filter: drop-shadow(0 4px 10px rgba(200,45,133,0.20));
  }

  /* ── SECTION ── */
  .section-title { font-size: 1.35rem; font-weight: 800; color: #492F48; margin-bottom: 16px; }
  .aktivitas-section { padding: 0 48px 36px; animation: fadeUp 0.7s ease 0.2s both; }

  /* ── FILTER TABS ── */
  .filter-tabs { display: flex; gap: 10px; margin-bottom: 24px; flex-wrap: wrap; }
  .filter-tab {
    padding: 8px 24px; border-radius: 50px; font-size: 0.88rem; font-weight: 700;
    cursor: pointer; border: none; transition: all 0.2s; background: #F7DAED; color: #C82D85;
  }
  .filter-tab:hover { background: #F0B8D8; }
  .filter-tab.active { background: #C82D85; color: #fff; box-shadow: 0 4px 14px rgba(200,45,133,0.30); }

  /* ── LIST ── */
  .riwayat-list { display: flex; flex-direction: column; gap: 14px; }
  .riwayat-item {
    background: #fff; border-radius: 20px; padding: 18px 22px;
    display: flex; align-items: center; gap: 16px;
    box-shadow: 0 4px 18px rgba(200,45,133,0.08); border: 1.5px solid #F7DAED;
    cursor: pointer; transition: all 0.22s; animation: fadeUp 0.4s ease;
  }
  .riwayat-item:hover { transform: translateY(-3px) scale(1.01); box-shadow: 0 12px 32px rgba(200,45,133,0.18); border-color: #E8A0CE; }

  /*
    Icon item list:
    - Praktik Huruf → public/assets/icon-praktik.png
    - Kuis Kata     → public/assets/icon-kuis.png
  */
  .riwayat-icon {
    width: 52px; height: 52px; object-fit: contain; border-radius: 14px;
    flex-shrink: 0; filter: drop-shadow(0 3px 6px rgba(200,45,133,0.15));
  }

  .riwayat-info { flex: 1; min-width: 0; }
  .riwayat-info h3 { font-size: 1rem; font-weight: 700; color: #492F48; margin-bottom: 3px; }
  .riwayat-info span { font-size: 0.83rem; color: #9B6898; font-weight: 500; }

  .riwayat-badges { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
  .badge-skor  { padding: 6px 18px; border-radius: 50px; background: #C82D85; color: #fff; font-size: 0.82rem; font-weight: 700; box-shadow: 0 4px 12px rgba(200,45,133,0.28); }
  .badge-benar { padding: 6px 14px; border-radius: 50px; background: #C82D85; color: #fff; font-size: 0.82rem; font-weight: 700; }
  .badge-salah { padding: 6px 14px; border-radius: 50px; background: #F7DAED; color: #C82D85; font-size: 0.82rem; font-weight: 700; border: 1.5px solid #F0B8D8; }

  /* ── EMPTY STATE ── */
  .empty-state { text-align: center; padding: 48px 24px; display: none; }
  /*
    Icon empty state — taruh file di:
    public/assets/icon-empty.png
  */
  .empty-icon-img { width: 56px; height: 56px; object-fit: contain; margin: 0 auto 12px; display: block; opacity: 0.6; }
  .empty-state p { font-size: 0.95rem; font-weight: 500; color: #9B6898; }

  /* ══════════════════════════════════
     MODAL SHARED
  ══════════════════════════════════ */
  .modal-overlay {
    position: fixed; inset: 0; background: rgba(73,47,72,0.52);
    backdrop-filter: blur(5px); z-index: 999; display: none;
    align-items: center; justify-content: center; padding: 16px;
  }
  .modal-overlay.open { display: flex; animation: fadeIn 0.2s ease; }
  .modal-box {
    background: #fff; border-radius: 26px; width: 100%;
    box-shadow: 0 24px 70px rgba(200,45,133,0.25);
    overflow: hidden; animation: popIn 0.3s ease;
    display: flex; flex-direction: column; max-height: 90vh;
  }
  .modal-box.modal-praktik { max-width: 560px; }
  .modal-box.modal-kuis    { max-width: 520px; }

  .modal-header {
    background: linear-gradient(135deg, #F1A2D0 0%, #C82D85 100%);
    padding: 22px 24px; display: flex; align-items: center;
    justify-content: space-between; gap: 12px; flex-shrink: 0;
  }
  .modal-header-left { display: flex; align-items: center; gap: 14px; }
  /*
    Icon header modal:
    - Praktik → public/assets/icon-praktik.png
    - Kuis    → public/assets/icon-kuis.png
  */
  .modal-header-icon {
    width: 48px; height: 48px; object-fit: contain;
    border-radius: 12px; background: rgba(255,255,255,0.22);
    padding: 5px; flex-shrink: 0;
  }
  .modal-header-text h2 { font-size: 1.05rem; font-weight: 800; color: #fff; margin-bottom: 2px; }
  .modal-header-text span { font-size: 0.82rem; color: rgba(255,255,255,0.88); font-weight: 500; }
  .modal-close {
    width: 32px; height: 32px; border-radius: 50%;
    background: rgba(255,255,255,0.22); border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: #fff; font-weight: 700;
    transition: background 0.2s; flex-shrink: 0;
  }
  .modal-close:hover { background: rgba(255,255,255,0.38); }

  .modal-body { padding: 22px 24px; overflow-y: auto; flex: 1; }

  /* Skor strip */
  .modal-skor-wrap {
    text-align: center; padding: 18px 20px; background: #FEF0F8;
    border-radius: 16px; margin-bottom: 16px; border: 1.5px solid #F7DAED;
  }
  .modal-skor-label { font-size: 0.75rem; color: #9B6898; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 3px; }
  .modal-skor-val   { font-size: 2.6rem; font-weight: 900; color: #C82D85; line-height: 1; margin-bottom: 3px; }
  .modal-skor-sub   { font-size: 0.82rem; color: #7A4B78; font-weight: 500; }

  /* Status badge */
  .status-badge { display: inline-block; padding: 5px 18px; border-radius: 50px; font-size: 0.85rem; font-weight: 700; margin-top: 8px; }
  .status-sangat-baik { background: #E8F8EE; color: #2D8B50; border: 1.5px solid #5CB87A; }
  .status-baik        { background: #EEF4FF; color: #3B5FBF; border: 1.5px solid #7B9FE8; }
  .status-cukup       { background: #FFF8E6; color: #8B6020; border: 1.5px solid #E8C87A; }
  .status-perlu       { background: #FDECEC; color: #B22020; border: 1.5px solid #E57373; }

  /* Huruf besar display */
  .huruf-display {
    width: 70px; height: 70px; border-radius: 18px;
    background: linear-gradient(135deg, #F1A2D0, #C82D85);
    display: flex; align-items: center; justify-content: center;
    font-size: 2.2rem; font-weight: 900; color: #fff;
    margin: 0 auto 4px; box-shadow: 0 6px 18px rgba(200,45,133,0.30);
  }

  /* Rangkuman */
  .rangkuman-box {
    background: #FEF8FC; border: 1.5px solid #F7DAED;
    border-radius: 14px; padding: 14px 16px; margin-bottom: 16px;
  }
  .rangkuman-title-row {
    display: flex; align-items: center; gap: 8px; margin-bottom: 6px;
  }
  /*
    Icon rangkuman — taruh file di:
    public/assets/icon-rangkuman.png
  */
  .rangkuman-icon { width: 18px; height: 18px; object-fit: contain; }
  .rang-title { font-size: 0.8rem; font-weight: 700; color: #C82D85; text-transform: uppercase; letter-spacing: 0.5px; }
  .rangkuman-box p { font-size: 0.88rem; color: #492F48; line-height: 1.65; font-weight: 500; }

  /* Media grid webcam */
  .media-section-row {
    display: flex; align-items: center; gap: 8px; margin-bottom: 10px;
  }
  /*
    Icon kamera — taruh file di:
    public/assets/icon-kamera.png
  */
  .media-section-icon { width: 18px; height: 18px; object-fit: contain; }
  .media-section-title { font-size: 0.8rem; font-weight: 700; color: #C82D85; text-transform: uppercase; letter-spacing: 0.5px; }
  .media-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
  .media-item { border-radius: 12px; overflow: hidden; border: 1.5px solid #F7DAED; position: relative; }
  .media-item img { width: 100%; height: 120px; object-fit: cover; display: block; background: #FEF0F8; }
  .media-placeholder {
    width: 100%; height: 120px;
    background: linear-gradient(135deg, #FEF0F8, #F7DAED);
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;
  }
  /*
    Icon placeholder media:
    public/assets/icon-foto.png   → slot gambar
    public/assets/icon-video.png  → slot video
  */
  .media-placeholder-icon { width: 32px; height: 32px; object-fit: contain; opacity: 0.6; }
  .media-placeholder p { font-size: 0.72rem; font-weight: 600; color: #9B6898; }
  .media-label {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(73,47,72,0.6); color: #fff;
    font-size: 0.72rem; font-weight: 600; padding: 4px 8px; text-align: center;
  }

  /* Detail rows */
  .modal-detail-list { display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px; }
  .modal-detail-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 14px; background: #FEF8FC; border-radius: 12px; border: 1px solid #F7DAED;
  }
  .detail-label {
    font-size: 0.83rem; color: #7A4B78; font-weight: 600;
    display: flex; align-items: center; gap: 8px;
  }
  /*
    Icon detail row — taruh file-file di:
    public/assets/icon-tanggal.png
    public/assets/icon-durasi.png
    public/assets/icon-kategori.png
    public/assets/icon-level.png
    public/assets/icon-soal.png
  */
  .detail-row-icon { width: 16px; height: 16px; object-fit: contain; }
  .detail-val { font-size: 0.86rem; color: #492F48; font-weight: 700; text-align: right; }

  /* Benar/salah stat (kuis) */
  .kuis-stat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
  .kuis-stat-card { border-radius: 12px; border: 1px solid #F7DAED; padding: 12px; text-align: center; background: #FEF8FC; }
  .kuis-stat-card.benar { background: #E8F8EE; border-color: #B8E8C8; }
  .kuis-stat-card.salah { background: #FDECEC; border-color: #F0BBBB; }
  .kuis-stat-val { font-size: 1.5rem; font-weight: 900; line-height: 1; margin-bottom: 4px; }
  .kuis-stat-card.benar .kuis-stat-val { color: #2D8B50; }
  .kuis-stat-card.salah .kuis-stat-val { color: #B22020; }
  .kuis-stat-label-row { display: flex; align-items: center; justify-content: center; gap: 5px; }
  /*
    Icon benar/salah:
    public/assets/icon-benar.png
    public/assets/icon-salah.png
  */
  .kuis-stat-icon { width: 14px; height: 14px; object-fit: contain; }
  .kuis-stat-label { font-size: 0.78rem; font-weight: 600; color: #7A4B78; }

  /* ── KUIS: daftar soal ── */
  .soal-list-title-row { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; }
  /*
    Icon daftar soal:
    public/assets/icon-daftar-soal.png
  */
  .soal-list-title-icon { width: 18px; height: 18px; object-fit: contain; }
  .soal-list-title { font-size: 0.8rem; font-weight: 700; color: #C82D85; text-transform: uppercase; letter-spacing: 0.5px; }

  .soal-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 16px; }
  .soal-card-detail { border-radius: 14px; border: 1.5px solid #F7DAED; overflow: hidden; background: #fff; }
  .soal-card-header { display: flex; align-items: center; gap: 10px; padding: 10px 14px; }
  .soal-card-header.benar { background: #E8F8EE; border-bottom: 1px solid #B8E8C8; }
  .soal-card-header.salah { background: #FDECEC; border-bottom: 1px solid #F0BBBB; }
  .soal-nomor {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.78rem; font-weight: 800; flex-shrink: 0; color: #fff;
  }
  .soal-card-header.benar .soal-nomor { background: #5CB87A; }
  .soal-card-header.salah .soal-nomor { background: #E57373; }
  .soal-pertanyaan-txt { font-size: 0.85rem; font-weight: 600; color: #492F48; flex: 1; }
  /*
    Icon status soal benar/salah:
    public/assets/icon-benar.png
    public/assets/icon-salah.png
  */
  .soal-status-img { width: 18px; height: 18px; object-fit: contain; flex-shrink: 0; }

  .soal-card-body { padding: 10px 14px; display: flex; gap: 12px; align-items: flex-start; }
  /*
    Gambar soal dari webcam/DB:
    public/assets/soal/huruf-x.png
  */
  .soal-img-thumb {
    width: 60px; height: 60px; object-fit: contain; border-radius: 10px;
    background: #FEF0F8; border: 1.5px solid #F7DAED; flex-shrink: 0; padding: 4px;
  }
  .soal-img-placeholder-sm {
    width: 60px; height: 60px; border-radius: 10px;
    background: #FEF0F8; border: 1.5px solid #F7DAED;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  }
  /* icon di placeholder soal: public/assets/icon-gesture.png */
  .soal-ph-icon { width: 32px; height: 32px; object-fit: contain; opacity: 0.5; }

  .soal-pilihan-wrap { flex: 1; }
  .soal-pilihan-row { display: flex; align-items: center; gap: 6px; font-size: 0.82rem; font-weight: 600; padding: 4px 0; }
  .soal-pilihan-dot {
    width: 16px; height: 16px; border-radius: 50%; border: 1.5px solid #D8A8CE;
    flex-shrink: 0; display: flex; align-items: center; justify-content: center;
  }
  .soal-pilihan-row.pilihan-benar .soal-pilihan-dot { background: #5CB87A; border-color: #5CB87A; }
  .soal-pilihan-row.pilihan-benar .soal-pilihan-dot::after { content: '\2713'; font-size: 9px; color: #fff; font-weight: 900; }
  .soal-pilihan-row.pilihan-salah .soal-pilihan-dot { background: #E57373; border-color: #E57373; }
  .soal-pilihan-row.pilihan-salah .soal-pilihan-dot::after { content: '\2715'; font-size: 9px; color: #fff; font-weight: 900; }
  .soal-pilihan-row.pilihan-benar { color: #2D8B50; }
  .soal-pilihan-row.pilihan-salah { color: #B22020; }
  .soal-pilihan-row.pilihan-netral { color: #9B6898; }

  /* CTA */
  .modal-btn {
    display: block; width: 100%; padding: 13px; border-radius: 14px;
    background: #C82D85; color: #fff; font-size: 0.93rem; font-weight: 800;
    text-align: center; border: none; cursor: pointer;
    box-shadow: 0 6px 20px rgba(200,45,133,0.32); transition: all 0.2s; text-decoration: none;
  }
  .modal-btn:hover { background: #951651; transform: translateY(-2px); box-shadow: 0 10px 28px rgba(200,45,133,0.42); color: #fff; }

  @media (max-width: 900px) {
    .histori-header    { padding: 24px 20px 0; }
    .aktivitas-section { padding: 0 20px 36px; }
    .histori-header-card { flex-direction: column; text-align: center; gap: 14px; }
  }
  @media (max-width: 500px) {
    .media-grid { grid-template-columns: 1fr; }
    .kuis-stat-grid { grid-template-columns: 1fr 1fr; }
  }
</style>
@endpush

<div class="histori-wrapper">

  {{-- HEADER CARD --}}
  <div class="histori-header">
    <div class="histori-header-card">
      <div class="histori-header-text">
        <h1>Riwayat Belajarku</h1>
        <p>Lihat semua latihan yang sudah kamu selesaikan</p>
      </div>
      {{-- Icon kanan header → public/assets/icon-histori.png --}}
      <img src="{{ asset('assets/icon-histori.png') }}" alt="Riwayat"
           class="histori-header-img" onerror="this.style.display='none'">
    </div>
  </div>

  {{-- AKTIVITAS --}}
  <section class="aktivitas-section">
    <p class="section-title">Aktivitas Terakhir</p>

    <div class="filter-tabs">
      <button class="filter-tab active" onclick="filterTab('semua', this)">Semua</button>
      <button class="filter-tab" onclick="filterTab('praktik', this)">Praktik Huruf</button>
      <button class="filter-tab" onclick="filterTab('kuis', this)">Kuis Kata</button>
    </div>

    <div class="riwayat-list" id="riwayat-list">
      @forelse($riwayat as $item)
        <div class="riwayat-item"
             data-tipe="{{ $item['tipe'] }}"
             onclick="bukaModal({{ json_encode($item) }})">

          {{--
            Icon item list:
            Praktik → public/assets/icon-praktik.png
            Kuis    → public/assets/icon-kuis.png
          --}}
          <img src="{{ asset('assets/icon-' . $item['tipe'] . '.png') }}"
               alt="{{ $item['tipe'] }}" class="riwayat-icon"
               onerror="this.style.display='none'">

          <div class="riwayat-info">
            <h3>{{ $item['judul'] }}</h3>
            <span>{{ $item['subjudul'] }}</span>
          </div>

          <div class="riwayat-badges">
            @if($item['tipe'] === 'praktik')
              <span class="badge-skor">{{ $item['skor'] }}%</span>
            @else
              <span class="badge-benar">Benar: {{ $item['benar'] }}</span>
              <span class="badge-salah">Salah: {{ $item['salah'] }}</span>
            @endif
          </div>
        </div>
      @empty
        <div class="empty-state" style="display:block;">
          {{-- Icon empty → public/assets/icon-empty.png --}}
          <img src="{{ asset('assets/icon-empty.png') }}" alt="Kosong" class="empty-icon-img"
               onerror="this.style.display='none'">
          <p>Belum ada riwayat belajar.<br>Yuk mulai belajar sekarang!</p>
        </div>
      @endforelse
    </div>

    <div class="empty-state" id="empty-filter">
      {{-- Icon empty → public/assets/icon-empty.png --}}
      <img src="{{ asset('assets/icon-empty.png') }}" alt="Kosong" class="empty-icon-img"
           onerror="this.style.display='none'">
      <p>Tidak ada riwayat untuk kategori ini.</p>
    </div>
  </section>

  @include('layout.footer')
</div>

{{-- ══════════════════════════════
     MODAL PRAKTIK HURUF
══════════════════════════════ --}}
<div class="modal-overlay" id="modal-praktik" onclick="tutupOverlay('modal-praktik', event)">
  <div class="modal-box modal-praktik">

    <div class="modal-header">
      <div class="modal-header-left">
        {{-- Icon header modal → public/assets/icon-praktik.png --}}
        <img src="{{ asset('assets/icon-praktik.png') }}" alt="Praktik"
             class="modal-header-icon" id="p-icon">
        <div class="modal-header-text">
          <h2 id="p-judul">Praktik Huruf</h2>
          <span id="p-subjudul">—</span>
        </div>
      </div>
      <button class="modal-close" onclick="tutupModal('modal-praktik')">x</button>
    </div>

    <div class="modal-body">

      {{-- Skor + huruf + status --}}
      <div class="modal-skor-wrap">
        <div class="huruf-display" id="p-huruf-display">A</div>
        <p class="modal-skor-label" style="margin-top:10px;">Skor Praktik</p>
        <div class="modal-skor-val" id="p-skor">—</div>
        <div id="p-status-badge" class="status-badge">—</div>
      </div>

      {{-- Rangkuman --}}
      <div class="rangkuman-box">
        <div class="rangkuman-title-row">
          {{-- Icon rangkuman → public/assets/icon-rangkuman.png --}}
          <img src="{{ asset('assets/icon-rangkuman.png') }}" alt="" class="rangkuman-icon"
               onerror="this.style.display='none'">
          <p class="rang-title">Rangkuman Hasil</p>
        </div>
        <p id="p-rangkuman">—</p>
      </div>

      {{-- Detail info --}}
      <div class="modal-detail-list">
        <div class="modal-detail-row">
          <span class="detail-label">
            {{-- public/assets/icon-tanggal.png --}}
            <img src="{{ asset('assets/icon-tanggal.png') }}" alt="" class="detail-row-icon" onerror="this.style.display='none'">
            Tanggal
          </span>
          <span class="detail-val" id="p-tanggal">—</span>
        </div>
        <div class="modal-detail-row">
          <span class="detail-label">
            {{-- public/assets/icon-durasi.png --}}
            <img src="{{ asset('assets/icon-durasi.png') }}" alt="" class="detail-row-icon" onerror="this.style.display='none'">
            Durasi
          </span>
          <span class="detail-val" id="p-durasi">—</span>
        </div>
        <div class="modal-detail-row">
          <span class="detail-label">
            {{-- public/assets/icon-kategori.png --}}
            <img src="{{ asset('assets/icon-kategori.png') }}" alt="" class="detail-row-icon" onerror="this.style.display='none'">
            Kategori
          </span>
          <span class="detail-val" id="p-kategori">—</span>
        </div>
        <div class="modal-detail-row">
          <span class="detail-label">
            {{-- public/assets/icon-level.png --}}
            <img src="{{ asset('assets/icon-level.png') }}" alt="" class="detail-row-icon" onerror="this.style.display='none'">
            Level
          </span>
          <span class="detail-val" id="p-level">—</span>
        </div>
      </div>

      {{-- Media webcam --}}
      <div id="p-media-section">
        <div class="media-section-row">
          {{-- public/assets/icon-kamera.png --}}
          <img src="{{ asset('assets/icon-kamera.png') }}" alt="" class="media-section-icon"
               onerror="this.style.display='none'">
          <p class="media-section-title">Foto / Video Sesi Praktik</p>
        </div>
        {{-- Gambar webcam → public/assets/praktik/namafile.jpg --}}
        <div class="media-grid" id="p-media-grid"></div>
      </div>

      <a href="{{ route('latihan') }}" class="modal-btn">Ulangi Praktik</a>
    </div>
  </div>
</div>

{{-- ══════════════════════════════
     MODAL KUIS KATA
══════════════════════════════ --}}
<div class="modal-overlay" id="modal-kuis" onclick="tutupOverlay('modal-kuis', event)">
  <div class="modal-box modal-kuis">

    <div class="modal-header">
      <div class="modal-header-left">
        {{-- Icon header modal → public/assets/icon-kuis.png --}}
        <img src="{{ asset('assets/icon-kuis.png') }}" alt="Kuis" class="modal-header-icon">
        <div class="modal-header-text">
          <h2 id="k-judul">Kuis Kata</h2>
          <span id="k-subjudul">—</span>
        </div>
      </div>
      <button class="modal-close" onclick="tutupModal('modal-kuis')">x</button>
    </div>

    <div class="modal-body">

      {{-- Skor besar --}}
      <div class="modal-skor-wrap">
        <p class="modal-skor-label">Skor Kuis</p>
        <div class="modal-skor-val" id="k-skor">—</div>
        <p class="modal-skor-sub" id="k-skor-sub">—</p>
      </div>

      {{-- Stat benar / salah --}}
      <div class="kuis-stat-grid">
        <div class="kuis-stat-card benar">
          <div class="kuis-stat-val" id="k-benar">—</div>
          <div class="kuis-stat-label-row">
            {{-- public/assets/icon-benar.png --}}
            <img src="{{ asset('assets/icon-benar.png') }}" alt="" class="kuis-stat-icon" onerror="this.style.display='none'">
            <span class="kuis-stat-label">Jawaban Benar</span>
          </div>
        </div>
        <div class="kuis-stat-card salah">
          <div class="kuis-stat-val" id="k-salah">—</div>
          <div class="kuis-stat-label-row">
            {{-- public/assets/icon-salah.png --}}
            <img src="{{ asset('assets/icon-salah.png') }}" alt="" class="kuis-stat-icon" onerror="this.style.display='none'">
            <span class="kuis-stat-label">Jawaban Salah</span>
          </div>
        </div>
      </div>

      {{-- Detail info --}}
      <div class="modal-detail-list" style="margin-bottom:16px;">
        <div class="modal-detail-row">
          <span class="detail-label">
            <img src="{{ asset('assets/icon-tanggal.png') }}" alt="" class="detail-row-icon" onerror="this.style.display='none'">
            Tanggal
          </span>
          <span class="detail-val" id="k-tanggal">—</span>
        </div>
        <div class="modal-detail-row">
          <span class="detail-label">
            <img src="{{ asset('assets/icon-durasi.png') }}" alt="" class="detail-row-icon" onerror="this.style.display='none'">
            Durasi
          </span>
          <span class="detail-val" id="k-durasi">—</span>
        </div>
        <div class="modal-detail-row">
          <span class="detail-label">
            <img src="{{ asset('assets/icon-kategori.png') }}" alt="" class="detail-row-icon" onerror="this.style.display='none'">
            Kategori
          </span>
          <span class="detail-val" id="k-kategori">—</span>
        </div>
        <div class="modal-detail-row">
          <span class="detail-label">
            <img src="{{ asset('assets/icon-level.png') }}" alt="" class="detail-row-icon" onerror="this.style.display='none'">
            Level
          </span>
          <span class="detail-val" id="k-level">—</span>
        </div>
      </div>

      {{-- Daftar soal --}}
      <div class="soal-list-title-row">
        {{-- public/assets/icon-daftar-soal.png --}}
        <img src="{{ asset('assets/icon-daftar-soal.png') }}" alt="" class="soal-list-title-icon"
             onerror="this.style.display='none'">
        <p class="soal-list-title">Kumpulan Soal yang Dikerjakan</p>
      </div>
      <div class="soal-list" id="k-soal-list"></div>

      <a href="{{ route('latihan') }}" class="modal-btn">Ulangi Kuis</a>
    </div>
  </div>
</div>

@push('scripts')
<script>
// asset base path untuk JS
const assetBase = '{{ asset("") }}';

function assetUrl(path) {
  return assetBase + path;
}

// ── FILTER ──────────────────────────────────────────
function filterTab(tipe, el) {
  document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  let visible = 0;
  document.querySelectorAll('.riwayat-item').forEach(item => {
    const show = tipe === 'semua' || item.dataset.tipe === tipe;
    item.style.display = show ? 'flex' : 'none';
    if (show) visible++;
  });
  document.getElementById('empty-filter').style.display = visible === 0 ? 'block' : 'none';
}

// ── DISPATCH ────────────────────────────────────────
function bukaModal(data) {
  if (data.tipe === 'praktik') bukaPraktik(data);
  else                         bukaKuis(data);
}

// ── MODAL PRAKTIK ───────────────────────────────────
function bukaPraktik(data) {
  document.getElementById('p-judul').textContent     = data.judul;
  document.getElementById('p-subjudul').textContent  = data.subjudul;
  document.getElementById('p-huruf-display').textContent = data.huruf ?? '?';
  document.getElementById('p-skor').textContent      = (data.skor ?? '—') + (data.skor != null ? '%' : '');
  document.getElementById('p-tanggal').textContent   = data.tanggal  ?? '—';
  document.getElementById('p-durasi').textContent    = data.durasi   ?? '—';
  document.getElementById('p-kategori').textContent  = data.kategori ?? '—';
  document.getElementById('p-level').textContent     = data.level    ?? '—';
  document.getElementById('p-rangkuman').textContent = data.rangkuman ?? '—';

  const badge  = document.getElementById('p-status-badge');
  const status = data.status_hasil ?? '';
  badge.textContent = status;
  badge.className   = 'status-badge ' + statusClass(status);

  // Media grid — gambar/video dari webcam
  const grid  = document.getElementById('p-media-grid');
  grid.innerHTML = '';
  const media = data.media ?? [];

  if (media.length === 0) {
    // Placeholder saat belum ada media
    // icon-foto.png & icon-video.png sebagai placeholder
    grid.innerHTML = `
      <div class="media-item">
        <div class="media-placeholder">
          <img src="${assetUrl('assets/icon-foto.png')}" alt="Foto" class="media-placeholder-icon"
               onerror="this.style.display='none'">
          <p>Belum ada foto</p>
        </div>
      </div>
      <div class="media-item">
        <div class="media-placeholder">
          <img src="${assetUrl('assets/icon-video.png')}" alt="Video" class="media-placeholder-icon"
               onerror="this.style.display='none'">
          <p>Belum ada video</p>
        </div>
      </div>`;
  } else {
    media.forEach(m => {
      const div = document.createElement('div');
      div.className = 'media-item';
      if (m.tipe === 'gambar') {
        div.innerHTML = `
          <img src="/${m.path}" alt="${m.label}"
               onerror="this.outerHTML='<div class=\\'media-placeholder\\'><img src=\\'${assetUrl('assets/icon-foto.png')}\\' class=\\'media-placeholder-icon\\'><p>${m.label}</p></div>'">
          <div class="media-label">${m.label}</div>`;
      } else {
        div.innerHTML = `
          <video controls style="width:100%;height:120px;object-fit:cover;background:#FEF0F8;">
            <source src="/${m.path}">
          </video>
          <div class="media-label">${m.label}</div>`;
      }
      grid.appendChild(div);
    });
  }

  bukaOverlay('modal-praktik');
}

// ── MODAL KUIS ──────────────────────────────────────
function bukaKuis(data) {
  document.getElementById('k-judul').textContent    = data.judul;
  document.getElementById('k-subjudul').textContent = data.subjudul;

  const skor  = data.skor  ?? 0;
  const benar = data.benar ?? 0;
  const salah = data.salah ?? 0;
  const total = data.total_soal ?? (benar + salah);

  document.getElementById('k-skor').textContent     = skor + '%';
  document.getElementById('k-skor-sub').textContent = benar + ' benar dari ' + total + ' soal';
  document.getElementById('k-benar').textContent    = benar;
  document.getElementById('k-salah').textContent    = salah;
  document.getElementById('k-tanggal').textContent  = data.tanggal  ?? '—';
  document.getElementById('k-durasi').textContent   = data.durasi   ?? '—';
  document.getElementById('k-kategori').textContent = data.kategori ?? '—';
  document.getElementById('k-level').textContent    = data.level    ?? '—';

  // Render daftar soal
  const list     = document.getElementById('k-soal-list');
  list.innerHTML = '';
  const soalList = data.soal_detail ?? [];

  soalList.forEach(s => {
    const cls      = s.benar ? 'benar' : 'salah';
    const iconPath = s.benar
      ? assetUrl('assets/icon-benar.png')
      : assetUrl('assets/icon-salah.png');

    let pilihanHTML = '';
    s.pilihan.forEach(p => {
      const isBenar = p === s.jawaban_benar;
      const isUser  = p === s.jawaban_user;
      let rowCls    = 'soal-pilihan-row pilihan-netral';
      if (isBenar)              rowCls = 'soal-pilihan-row pilihan-benar';
      else if (isUser && !s.benar) rowCls = 'soal-pilihan-row pilihan-salah';
      const extra = isUser
        ? (s.benar ? ' (Jawaban kamu)' : ' (Jawaban kamu)')
        : (isBenar && !s.benar ? ' (Jawaban benar)' : '');
      pilihanHTML += `<div class="${rowCls}"><div class="soal-pilihan-dot"></div>${p}${extra}</div>`;
    });

    const card = document.createElement('div');
    card.className = 'soal-card-detail';
    card.innerHTML = `
      <div class="soal-card-header ${cls}">
        <div class="soal-nomor">${s.nomor}</div>
        <span class="soal-pertanyaan-txt">${s.soal}</span>
        <img src="${iconPath}" alt="${cls}" class="soal-status-img"
             onerror="this.style.display='none'">
      </div>
      <div class="soal-card-body">
        <img src="/${s.img}" alt="Soal ${s.nomor}" class="soal-img-thumb"
             onerror="this.outerHTML='<div class=\\'soal-img-placeholder-sm\\'><img src=\\'${assetUrl('assets/icon-gesture.png')}\\' class=\\'soal-ph-icon\\'></div>'">
        <div class="soal-pilihan-wrap">${pilihanHTML}</div>
      </div>`;
    list.appendChild(card);
  });

  if (soalList.length === 0) {
    list.innerHTML = '<p style="color:#9B6898;font-size:0.88rem;text-align:center;padding:12px;">Data soal tidak tersedia.</p>';
  }

  bukaOverlay('modal-kuis');
}

// ── HELPER ──────────────────────────────────────────
function statusClass(s) {
  if (!s) return '';
  const l = s.toLowerCase();
  if (l.includes('sangat')) return 'status-sangat-baik';
  if (l.includes('baik'))   return 'status-baik';
  if (l.includes('cukup'))  return 'status-cukup';
  return 'status-perlu';
}
function bukaOverlay(id) {
  document.getElementById(id).classList.add('open');
  document.body.style.overflow = 'hidden';
}
function tutupModal(id) {
  document.getElementById(id).classList.remove('open');
  document.body.style.overflow = '';
}
function tutupOverlay(id, e) {
  if (e.target === document.getElementById(id)) tutupModal(id);
}
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') ['modal-praktik','modal-kuis'].forEach(id => tutupModal(id));
});
</script>
@endpush

@endsection