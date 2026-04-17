@extends('layout.app')
@section('title', 'SignLearn - Latihan')
@section('content')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');
  * { font-family: 'Poppins', sans-serif; }

  @keyframes fadeUp {
    from { opacity:0; transform:translateY(24px); }
    to   { opacity:1; transform:translateY(0); }
  }
  @keyframes fadeIn {
    from { opacity:0; } to { opacity:1; }
  }
  @keyframes popIn {
    0%   { transform: scale(0.85); opacity:0; }
    70%  { transform: scale(1.04); }
    100% { transform: scale(1);    opacity:1; }
  }
  @keyframes shake {
    0%,100% { transform: translateX(0); }
    20%     { transform: translateX(-8px); }
    40%     { transform: translateX(8px); }
    60%     { transform: translateX(-5px); }
    80%     { transform: translateX(5px); }
  }

  /* ── WRAPPER ── */
  .latihan-wrapper {
    background: linear-gradient(160deg, #FFE8F4 0%, #FFF0F8 40%, #FDE6F2 100%);
    min-height: 100vh;
    padding-bottom: 60px;
  }

  /* ── CONTENT AREA ── */
  .latihan-content {
    max-width: 720px;
    margin: 0 auto;
    padding: 36px 24px 48px;
  }

  /* ════════════════════════════
     SCREEN 1 — PILIH LEVEL
  ════════════════════════════ */
  #screen-level { animation: fadeUp 0.5s ease; }

  .level-header-card {
    background: #fff;
    border-radius: 22px;
    padding: 36px 32px 28px;
    text-align: center;
    box-shadow: 0 6px 28px rgba(200,45,133,0.10);
    border: 1.5px solid #F7DAED;
    margin-bottom: 32px;
  }
  .level-header-card h1 {
    font-size: 1.75rem;
    font-weight: 800;
    color: #492F48;
    margin-bottom: 8px;
  }
  .level-header-card p {
    font-size: 0.97rem;
    color: #7A4B78;
    font-weight: 500;
  }

  .level-label {
    font-size: 1.2rem;
    font-weight: 800;
    color: #492F48;
    margin-bottom: 16px;
  }

  .level-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-bottom: 28px;
  }

  .level-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    border: 2px solid #F2B8D8;
    border-radius: 18px;
    padding: 16px 22px;
    cursor: pointer;
    transition: all 0.22s;
    box-shadow: 0 3px 14px rgba(200,45,133,0.07);
  }
  .level-item:hover {
    border-color: #C82D85;
    box-shadow: 0 8px 24px rgba(200,45,133,0.18);
    transform: translateY(-2px);
  }
  .level-item.selected {
    border-color: #C82D85;
    background: #FEF0F8;
    box-shadow: 0 8px 28px rgba(200,45,133,0.22);
  }
  .level-item-left {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  /* Icon gambar level — buat file: public/assets/icon-level-pemula.png, dll */
  .level-icon-img {
    width: 52px;
    height: 52px;
    object-fit: contain;
    border-radius: 12px;
    flex-shrink: 0;
    filter: drop-shadow(0 3px 6px rgba(200,45,133,0.18));
  }

  .level-info h3 {
    font-size: 1.05rem;
    font-weight: 700;
    color: #492F48;
    margin-bottom: 2px;
  }
  .level-info span {
    font-size: 0.82rem;
    color: #9B6898;
    font-weight: 500;
  }

  /* Radio dot level */
  .level-item input[type="radio"] { display: none; }
  .level-radio-dot {
    width: 22px; height: 22px;
    border-radius: 50%;
    border: 2px solid #D8A8CE;
    background: #fff;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
  }
  .level-item.selected .level-radio-dot {
    border-color: #C82D85;
    background: #C82D85;
  }
  .level-radio-dot::after {
    content: '';
    width: 9px; height: 9px;
    border-radius: 50%;
    background: #fff;
    opacity: 0;
    transition: opacity 0.2s;
  }
  .level-item.selected .level-radio-dot::after { opacity: 1; }

  .btn-mulai-kuis {
    display: block;
    width: 100%;
    padding: 16px;
    border-radius: 18px;
    background: #C82D85;
    color: #fff;
    font-size: 1.05rem;
    font-weight: 800;
    text-align: center;
    border: none;
    cursor: pointer;
    box-shadow: 0 8px 28px rgba(200,45,133,0.38);
    transition: all 0.22s;
  }
  .btn-mulai-kuis:hover {
    background: #951651;
    transform: translateY(-2px);
    box-shadow: 0 14px 36px rgba(200,45,133,0.5);
  }
  .btn-mulai-kuis:disabled {
    background: #D8A8CE;
    box-shadow: none;
    cursor: not-allowed;
    transform: none;
  }

  /* ════════════════════════════
     SCREEN 2 — SOAL
  ════════════════════════════ */
  #screen-soal { display: none; animation: fadeIn 0.4s ease; }

  .soal-topbar {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 18px;
  }
  .btn-back {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: #fff;
    border: 1.5px solid #F2B8D8;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    font-size: 18px;
    color: #742958;
    transition: all 0.2s;
    flex-shrink: 0;
    border: none;
    background: transparent;
  }
  .btn-back:hover { color: #C82D85; }
  .soal-topbar-label {
    font-size: 0.95rem;
    font-weight: 700;
    color: #492F48;
  }

  .progress-quiz-bg {
    width: 100%;
    height: 10px;
    background: #F7DAED;
    border-radius: 50px;
    overflow: hidden;
    margin-bottom: 24px;
  }
  .progress-quiz-fill {
    height: 100%;
    border-radius: 50px;
    background: linear-gradient(90deg, #E8409A, #C82D85);
    transition: width 0.5s ease;
    box-shadow: 0 2px 8px rgba(200,45,133,0.35);
  }

  .soal-card {
    background: #fff;
    border-radius: 22px;
    padding: 32px 28px;
    box-shadow: 0 6px 28px rgba(200,45,133,0.10);
    border: 1.5px solid #F7DAED;
    margin-bottom: 24px;
    text-align: center;
  }
  .soal-card .soal-pertanyaan {
    font-size: 1.05rem;
    font-weight: 600;
    color: #492F48;
    margin-bottom: 22px;
  }
  .soal-card .soal-img {
    width: 120px; height: 120px;
    object-fit: contain;
    margin: 0 auto 18px;
    display: block;
    filter: drop-shadow(0 6px 12px rgba(0,0,0,0.10));
    animation: popIn 0.4s ease;
  }
  .soal-img-placeholder {
    width: 120px; height: 120px;
    margin: 0 auto 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 64px;
    animation: popIn 0.4s ease;
  }

  /* Feedback */
  .soal-feedback {
    border-radius: 14px;
    padding: 14px 18px;
    font-size: 0.95rem;
    font-weight: 700;
    display: none;
    margin-top: 16px;
    animation: popIn 0.3s ease;
  }
  .soal-feedback.benar {
    background: #E8F8EE;
    border: 1.5px solid #5CB87A;
    color: #2D6A3F;
    display: block;
  }
  .soal-feedback.salah {
    background: #FDECEC;
    border: 1.5px solid #E57373;
    color: #8B2020;
    display: block;
    animation: shake 0.4s ease;
  }
  .soal-feedback .fb-title { font-size: 1rem; font-weight: 800; margin-bottom: 3px; }
  .soal-feedback .fb-sub   { font-weight: 500; font-size: 0.88rem; }

  /* ── PILIHAN — radio button murni, tanpa label ABC ── */
  .pilihan-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 20px;
  }
  .pilihan-item {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #fff;
    border: 2px solid #F2B8D8;
    border-radius: 16px;
    padding: 14px 18px;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 10px rgba(200,45,133,0.06);
    user-select: none;
  }
  .pilihan-item:hover:not(.locked) {
    border-color: #C82D85;
    background: #FEF0F8;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(200,45,133,0.16);
  }
  .pilihan-item input[type="radio"] { display: none; }

  /* Lingkaran radio */
  .pilihan-radio-circle {
    width: 20px; height: 20px;
    border-radius: 50%;
    border: 2px solid #D8A8CE;
    background: #fff;
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
  }
  .pilihan-radio-circle::after {
    content: '';
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #C82D85;
    opacity: 0;
    transition: opacity 0.2s;
  }
  .pilihan-item.selected .pilihan-radio-circle {
    border-color: #C82D85;
  }
  .pilihan-item.selected .pilihan-radio-circle::after { opacity: 1; }

  .pilihan-text {
    font-size: 1rem;
    font-weight: 700;
    color: #492F48;
    flex: 1;
  }

  /* State: benar */
  .pilihan-item.correct {
    border-color: #5CB87A;
    background: #E8F8EE;
  }
  .pilihan-item.correct .pilihan-radio-circle {
    border-color: #5CB87A;
    background: #5CB87A;
  }
  .pilihan-item.correct .pilihan-radio-circle::after {
    opacity: 1;
    background: #fff;
  }
  .pilihan-item.correct .pilihan-text { color: #2D6A3F; }

  /* State: salah */
  .pilihan-item.wrong {
    border-color: #E57373;
    background: #FDECEC;
    opacity: 0.80;
  }
  .pilihan-item.wrong .pilihan-radio-circle {
    border-color: #E57373;
    background: #E57373;
  }
  .pilihan-item.wrong .pilihan-radio-circle::after {
    opacity: 1;
    background: #fff;
  }
  .pilihan-item.wrong .pilihan-text { color: #8B2020; }
  .pilihan-item.locked { cursor: default; }

  .check-icon {
    font-size: 16px;
    display: none;
    flex-shrink: 0;
  }
  .pilihan-item.correct .check-icon { display: block; }

  .btn-next-soal {
    display: none;
    width: 100%;
    padding: 16px;
    border-radius: 18px;
    background: #C82D85;
    color: #fff;
    font-size: 1.05rem;
    font-weight: 800;
    text-align: center;
    border: none;
    cursor: pointer;
    box-shadow: 0 8px 28px rgba(200,45,133,0.38);
    transition: all 0.22s;
  }
  .btn-next-soal:hover { background: #951651; transform: translateY(-2px); }
  .btn-next-soal.visible { display: block; animation: fadeUp 0.3s ease; }

  /* ════════════════════════════
     SCREEN 3 — HASIL
  ════════════════════════════ */
  #screen-hasil { display: none; animation: fadeUp 0.5s ease; }

  .hasil-card {
    background: #fff;
    border-radius: 24px;
    padding: 44px 32px;
    text-align: center;
    box-shadow: 0 6px 28px rgba(200,45,133,0.12);
    border: 1.5px solid #F7DAED;
  }
  .hasil-emoji { font-size: 56px; margin-bottom: 16px; animation: popIn 0.5s ease; display: block; }
  .hasil-card h2 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #492F48;
    margin-bottom: 8px;
  }
  .hasil-skor {
    font-size: 3rem;
    font-weight: 900;
    color: #C82D85;
    line-height: 1;
    margin-bottom: 4px;
  }
  .hasil-sub {
    font-size: 0.9rem;
    color: #9B6898;
    margin-bottom: 24px;
  }
  .hasil-stats {
    display: flex;
    justify-content: center;
    gap: 36px;
    margin-bottom: 28px;
    padding: 20px;
    background: #FEF0F8;
    border-radius: 16px;
  }
  .hasil-stat { text-align: center; }
  .hasil-stat .stat-val {
    font-size: 1.5rem;
    font-weight: 800;
    color: #492F48;
  }
  .hasil-stat .stat-val.green { color: #2D8B50; }
  .hasil-stat .stat-val.red   { color: #B22020; }
  .hasil-stat .stat-label {
    font-size: 0.8rem;
    color: #9B6898;
    font-weight: 500;
    margin-top: 2px;
  }
  .hasil-btns { display: flex; gap: 12px; flex-wrap: wrap; }
  .btn-ulangi {
    flex: 1; padding: 14px;
    border-radius: 14px;
    border: 2px solid #C82D85;
    color: #C82D85;
    background: #fff;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
  }
  .btn-ulangi:hover { background: #FEE6F2; }
  .btn-ke-beranda {
    flex: 1; padding: 14px;
    border-radius: 14px;
    background: #C82D85;
    color: #fff;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    border: none;
    box-shadow: 0 6px 20px rgba(200,45,133,0.32);
    transition: all 0.2s;
    text-decoration: none;
    display: flex; align-items: center; justify-content: center;
  }
  .btn-ke-beranda:hover { background: #951651; transform: translateY(-2px); }

  @media (max-width: 700px) {
    .pilihan-grid { grid-template-columns: 1fr; }
    .hasil-stats  { gap: 18px; }
  }
</style>
@endpush

<div class="latihan-wrapper">

  {{-- NAVBAR --}}
  @include('layout.navbar')

  <div class="latihan-content">

    {{-- ══════════════════════════════
         SCREEN 1 — PILIH LEVEL
    ══════════════════════════════ --}}
    <div id="screen-level">

      <div class="level-header-card">
        <h1>Kuis Praktik Isyarat</h1>
        <p>Uji kemampuan mengenali huruf BISINDO dan SIBI</p>
      </div>

      <p class="level-label">Pilih Level</p>

      <div class="level-list">

        <label class="level-item" id="lbl-pemula" onclick="selectLevel('pemula', this)">
          <div class="level-item-left">
            {{-- Buat file: public/assets/icon-level-pemula.png --}}
            <img src="{{ asset('assets/icon-level.png') }}"
                 alt="Pemula" class="level-icon-img">
            <div class="level-info">
              <h3>Pemula</h3>
              <span>Soal Mudah</span>
            </div>
          </div>
          <input type="radio" name="level" value="pemula">
          <div class="level-radio-dot"></div>
        </label>

        <label class="level-item" id="lbl-menengah" onclick="selectLevel('menengah', this)">
          <div class="level-item-left">
            {{-- Buat file: public/assets/icon-level-menengah.png --}}
            <img src="{{ asset('assets/icon-level.png') }}"
                 alt="Menengah" class="level-icon-img">
            <div class="level-info">
              <h3>Menengah</h3>
              <span>Soal Sedang</span>
            </div>
          </div>
          <input type="radio" name="level" value="menengah">
          <div class="level-radio-dot"></div>
        </label>

        <label class="level-item" id="lbl-mahir" onclick="selectLevel('mahir', this)">
          <div class="level-item-left">
            {{-- Buat file: public/assets/icon-level-mahir.png --}}
            <img src="{{ asset('assets/icon-level.png') }}"
                 alt="Mahir" class="level-icon-img">
            <div class="level-info">
              <h3>Mahir</h3>
              <span>Soal Sulit</span>
            </div>
          </div>
          <input type="radio" name="level" value="mahir">
          <div class="level-radio-dot"></div>
        </label>

      </div>

      <button class="btn-mulai-kuis" id="btn-mulai" disabled onclick="mulaiKuis()">
        Mulai Kuis
      </button>
    </div>

    {{-- ══════════════════════════════
         SCREEN 2 — SOAL
    ══════════════════════════════ --}}
    <div id="screen-soal">

      <div class="soal-topbar">
        <button class="btn-back" onclick="kembaliKeLevel()">&#8592;</button>
        <span class="soal-topbar-label" id="soal-label">Soal 1 dari 5</span>
      </div>

      <div class="progress-quiz-bg">
        <div class="progress-quiz-fill" id="quiz-progress" style="width: 0%;"></div>
      </div>

      <div class="soal-card">
        <p class="soal-pertanyaan">Huruf apa yang ditunjukkan gerakan ini?</p>
        <img class="soal-img" id="soal-img" src="" alt="Gesture isyarat"
             onerror="this.style.display='none'; document.getElementById('soal-img-ph').style.display='flex';">
        <div class="soal-img-placeholder" id="soal-img-ph" style="display:none;">🤟</div>

        <div class="soal-feedback" id="soal-feedback">
          <div class="fb-title" id="fb-title"></div>
          <div class="fb-sub"   id="fb-sub"></div>
        </div>
      </div>

      <div class="pilihan-grid" id="pilihan-grid"></div>

      <button class="btn-next-soal" id="btn-next" onclick="soalBerikutnya()">
        Soal Berikutnya
      </button>
    </div>

    {{-- ══════════════════════════════
         SCREEN 3 — HASIL
    ══════════════════════════════ --}}
    <div id="screen-hasil">
      <div class="hasil-card">
        <span class="hasil-emoji" id="hasil-emoji">🎉</span>
        <h2 id="hasil-judul">Kuis Selesai!</h2>
        <div class="hasil-skor" id="hasil-skor">0%</div>
        <p class="hasil-sub" id="hasil-sub">dari 5 soal</p>
        <div class="hasil-stats">
          <div class="hasil-stat">
            <div class="stat-val green" id="hasil-benar">0</div>
            <div class="stat-label">Benar</div>
          </div>
          <div class="hasil-stat">
            <div class="stat-val red" id="hasil-salah">0</div>
            <div class="stat-label">Salah</div>
          </div>
          <div class="hasil-stat">
            <div class="stat-val" id="hasil-total">0</div>
            <div class="stat-label">Total Soal</div>
          </div>
        </div>
        <div class="hasil-btns">
          <button class="btn-ulangi" onclick="ulangiKuis()">🔄 Ulangi Kuis</button>
          <a href="{{ route('beranda') }}" class="btn-ke-beranda">🏠 Ke Beranda</a>
        </div>
      </div>
    </div>

  </div>{{-- /latihan-content --}}

</div>{{-- /latihan-wrapper --}}

@push('scripts')
<script>
// ══════════════════════════════════════════
//  DATA SOAL — sesuaikan dengan data DB kamu
//  Gambar soal: public/assets/soal/huruf-a.png, dst.
// ══════════════════════════════════════════
const soalBank = {
  pemula: [
    { img: 'huruf-a', jawaban: 'A', pilihan: ['A','B','C','D'] },
    { img: 'huruf-b', jawaban: 'B', pilihan: ['A','B','E','F'] },
    { img: 'huruf-c', jawaban: 'C', pilihan: ['C','D','G','H'] },
    { img: 'huruf-d', jawaban: 'D', pilihan: ['B','C','D','E'] },
    { img: 'huruf-e', jawaban: 'E', pilihan: ['A','E','I','O'] },
  ],
  menengah: [
    { img: 'huruf-f', jawaban: 'F', pilihan: ['E','F','G','H'] },
    { img: 'huruf-g', jawaban: 'G', pilihan: ['F','G','H','I'] },
    { img: 'huruf-h', jawaban: 'H', pilihan: ['G','H','I','J'] },
    { img: 'huruf-i', jawaban: 'I', pilihan: ['H','I','J','K'] },
    { img: 'huruf-j', jawaban: 'J', pilihan: ['I','J','K','L'] },
  ],
  mahir: [
    { img: 'huruf-v', jawaban: 'V', pilihan: ['U','V','W','X'] },
    { img: 'huruf-w', jawaban: 'W', pilihan: ['V','W','X','Y'] },
    { img: 'huruf-x', jawaban: 'X', pilihan: ['W','X','Y','Z'] },
    { img: 'huruf-y', jawaban: 'Y', pilihan: ['V','X','Y','Z'] },
    { img: 'huruf-z', jawaban: 'Z', pilihan: ['W','X','Y','Z'] },
  ],
};

let currentLevel = null;
let soalList     = [];
let currentIndex = 0;
let skorBenar    = 0;
let answered     = false;

// ── SCREEN 1 ──
function selectLevel(level, el) {
  currentLevel = level;
  document.querySelectorAll('.level-item').forEach(i => i.classList.remove('selected'));
  el.classList.add('selected');
  document.getElementById('btn-mulai').disabled = false;
}

function mulaiKuis() {
  soalList     = [...soalBank[currentLevel]].sort(() => Math.random() - 0.5);
  currentIndex = 0;
  skorBenar    = 0;
  showScreen('soal');
  renderSoal();
}

// ── SCREEN 2 ──
function renderSoal() {
  answered = false;
  const soal  = soalList[currentIndex];
  const total = soalList.length;
  const nomor = currentIndex + 1;

  document.getElementById('soal-label').textContent   = `Soal dari ${nomor} dari ${total}`;
  document.getElementById('quiz-progress').style.width = ((nomor / total) * 100) + '%';

  const imgEl = document.getElementById('soal-img');
  const phEl  = document.getElementById('soal-img-ph');
  imgEl.src   = `/assets/soal/${soal.img}.png`;
  imgEl.style.display = 'block';
  phEl.style.display  = 'none';

  const fb = document.getElementById('soal-feedback');
  fb.className     = 'soal-feedback';
  fb.style.display = 'none';

  const btnNext = document.getElementById('btn-next');
  btnNext.classList.remove('visible');
  btnNext.textContent = (currentIndex < total - 1) ? 'Soal Berikutnya' : 'Lihat Hasil';

  // Render pilihan — radio button murni, hanya teks jawaban
  const grid     = document.getElementById('pilihan-grid');
  grid.innerHTML = '';
  const shuffled = [...soal.pilihan].sort(() => Math.random() - 0.5);

  shuffled.forEach(opt => {
    const item = document.createElement('label');
    item.className = 'pilihan-item';
    item.innerHTML = `
      <input type="radio" name="jawaban" value="${opt}">
      <div class="pilihan-radio-circle"></div>
      <span class="pilihan-text">${opt}</span>
      <span class="check-icon">✅</span>
    `;
    item.addEventListener('click', () => {
      if (answered) return;
      grid.querySelectorAll('.pilihan-item').forEach(i => i.classList.remove('selected'));
      item.classList.add('selected');
      item.querySelector('input').checked = true;
      pilihJawaban(opt, soal.jawaban);
    });
    grid.appendChild(item);
  });
}

function pilihJawaban(pilihan, jawaban) {
  if (answered) return;
  answered = true;

  const benar = pilihan === jawaban;
  const fb    = document.getElementById('soal-feedback');
  const grid  = document.getElementById('pilihan-grid');

  grid.querySelectorAll('.pilihan-item').forEach(el => {
    el.classList.add('locked');
    const val = el.querySelector('input').value;
    if (val === jawaban) {
      el.classList.remove('selected');
      el.classList.add('correct');
    } else if (val === pilihan && !benar) {
      el.classList.remove('selected');
      el.classList.add('wrong');
    }
  });

  fb.style.display = 'block';
  if (benar) {
    skorBenar++;
    fb.className = 'soal-feedback benar';
    document.getElementById('fb-title').textContent = '✅ Jawaban Benar!';
    document.getElementById('fb-sub').textContent   = `Huruf yang ditunjukkan adalah huruf ${jawaban}`;
  } else {
    fb.className = 'soal-feedback salah';
    document.getElementById('fb-title').textContent = '❌ Jawaban Salah!';
    document.getElementById('fb-sub').textContent   = `Jawaban yang benar adalah huruf ${jawaban}`;
  }

  document.getElementById('btn-next').classList.add('visible');
}

function soalBerikutnya() {
  currentIndex++;
  if (currentIndex >= soalList.length) {
    tampilkanHasil();
  } else {
    renderSoal();
  }
}

function kembaliKeLevel() { showScreen('level'); }

// ── SCREEN 3 ──
function tampilkanHasil() {
  showScreen('hasil');
  const total  = soalList.length;
  const salah  = total - skorBenar;
  const persen = Math.round((skorBenar / total) * 100);

  document.getElementById('hasil-skor').textContent  = persen + '%';
  document.getElementById('hasil-sub').textContent   = `dari ${total} soal`;
  document.getElementById('hasil-benar').textContent = skorBenar;
  document.getElementById('hasil-salah').textContent = salah;
  document.getElementById('hasil-total').textContent = total;
  document.getElementById('quiz-progress').style.width = '100%';

  const emojiEl = document.getElementById('hasil-emoji');
  const judulEl = document.getElementById('hasil-judul');
  if (persen === 100)    { emojiEl.textContent = '🏆'; judulEl.textContent = 'Sempurna! Luar Biasa!'; }
  else if (persen >= 80) { emojiEl.textContent = '🎉'; judulEl.textContent = 'Keren! Hampir Sempurna!'; }
  else if (persen >= 60) { emojiEl.textContent = '👍'; judulEl.textContent = 'Bagus! Terus Berlatih!'; }
  else                   { emojiEl.textContent = '💪'; judulEl.textContent = 'Jangan Menyerah, Coba Lagi!'; }
}

function ulangiKuis() {
  currentIndex = 0;
  skorBenar    = 0;
  soalList     = [...soalBank[currentLevel]].sort(() => Math.random() - 0.5);
  showScreen('soal');
  renderSoal();
}

function showScreen(name) {
  document.getElementById('screen-level').style.display = name === 'level' ? 'block' : 'none';
  document.getElementById('screen-soal').style.display  = name === 'soal'  ? 'block' : 'none';
  document.getElementById('screen-hasil').style.display = name === 'hasil' ? 'block' : 'none';
}
</script>
@endpush
@include('layout.footer')
@endsection