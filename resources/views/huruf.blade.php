@extends('layout.app')

@section('title', 'SignLearn - Belajar Huruf ' . strtoupper($huruf))

@section('content')

@include('layout.navbar')

<div class="min-h-screen flex flex-col" style="background-color: #FEE6F2;">

    {{-- ===== KONTEN UTAMA ===== --}}
    <div class="flex-1 flex flex-col items-center px-6 py-6 max-w-lg mx-auto w-full">

        {{-- Back Button --}}
        <div class="w-full flex items-center gap-2 mb-6">
            <a href="{{ route('pembelajaran.index') }}"
               class="flex items-center gap-2 text-gray-700 font-bold text-sm hover:text-pink-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ strtoupper($modul) }}
            </a>
        </div>

        {{-- Progress Bar --}}
        @php
            $alphabet = range('A', 'Z');
            $currentIndex = array_search(strtoupper($huruf), $alphabet);
            $progressPercent = (($currentIndex + 1) / 26) * 100;
        @endphp
        <div class="w-full bg-pink-200 rounded-full h-2 mb-8">
            <div class="h-2 rounded-full transition-all duration-300"
                 style="width: {{ $progressPercent }}%;
                        background: linear-gradient(90deg, #F472B6, #DB2777);">
            </div>
        </div>

        {{-- Instruksi --}}
        <p class="text-gray-500 text-sm mb-3">Ejain kata ini dengan isyarat</p>

        {{-- Huruf --}}
        <div class="w-14 h-14 bg-white rounded-xl shadow-md flex items-center justify-center mb-6 border border-pink-100">
            <span class="text-2xl font-extrabold text-gray-800">{{ strtoupper($huruf) }}</span>
        </div>

        {{-- Timer --}}
        <div class="flex flex-col items-center mb-5">
            <div class="w-14 h-14 rounded-full border-4 flex items-center justify-center mb-1"
                 style="border-color: #C07EB5;">
                <span id="timerText" class="text-xl font-extrabold" style="color: #C07EB5;">5</span>
            </div>
            <p class="text-gray-500 text-xs font-medium">Detik tersisa</p>
        </div>

        {{-- Kamera / Deteksi --}}
        <div class="w-full bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
            <div class="relative w-full bg-black" style="height: 220px;">
                <video id="cameraFeed" autoplay playsinline
                       class="w-full h-full object-cover"></video>
                <div class="absolute top-3 left-3 w-8 h-8 border-t-2 border-l-2 border-green-400 rounded-tl"></div>
                <div class="absolute top-3 right-3 w-8 h-8 border-t-2 border-r-2 border-green-400 rounded-tr"></div>
                <div class="absolute bottom-3 left-3 w-8 h-8 border-b-2 border-l-2 border-green-400 rounded-bl"></div>
                <div class="absolute bottom-3 right-3 w-8 h-8 border-b-2 border-r-2 border-green-400 rounded-br"></div>
                <div class="absolute top-0 bottom-0 left-1/2 w-px bg-pink-400 opacity-40"></div>
                <div id="cameraPlaceholder" class="absolute inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
                    <p class="text-white text-xs">Kamera tidak tersedia</p>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-100 text-center">
                <p id="detectionStatus" class="text-gray-500 text-sm font-medium">Mendeteksi Tangan...</p>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex gap-3 w-full mt-6">
            <button id="practiceBtn"
                    class="flex-1 py-2.5 rounded-xl text-center text-sm font-semibold border-2 border-pink-300 text-pink-500 hover:bg-pink-50 transition">
                🎥 Ulangi Praktik
            </button>
            <button id="masteredBtn"
                    class="flex-1 py-2.5 rounded-xl text-center text-sm font-semibold text-white transition"
                    style="background-color: #D96FAD;">
                ✔️ Sudah Dikuasai
            </button>
        </div>

        {{-- Navigasi Huruf --}}
        <div class="flex justify-between w-full mt-3 gap-3">
            @php
                $prevHuruf = $currentIndex > 0 ? $alphabet[$currentIndex - 1] : null;
                $nextHuruf = $currentIndex < 25 ? $alphabet[$currentIndex + 1] : null;
            @endphp

            @if($prevHuruf)
                <a href="{{ route('pembelajaran.huruf', ['modul' => $modul, 'huruf' => strtolower($prevHuruf)]) }}"
                   class="flex-1 py-2.5 rounded-xl text-center text-sm font-semibold border-2 border-pink-300 text-pink-500 hover:bg-pink-50 transition">
                    ← {{ $prevHuruf }}
                </a>
            @else
                <div class="flex-1"></div>
            @endif

            @if($nextHuruf)
                <a href="{{ route('pembelajaran.huruf', ['modul' => $modul, 'huruf' => strtolower($nextHuruf)]) }}"
                   class="flex-1 py-2.5 rounded-xl text-center text-sm font-semibold text-white transition"
                   style="background-color: #D96FAD;">
                    {{ $nextHuruf }} →
                </a>
            @else
                <a href="{{ route('pembelajaran.index') }}"
                   class="flex-1 py-2.5 rounded-xl text-center text-sm font-semibold text-white transition"
                   style="background-color: #D96FAD;">
                    Selesai 🎉
                </a>
            @endif
        </div>

    </div>


</div>

@push('scripts')
<script>
    const currentLetter = "{{ strtoupper($huruf) }}";
    const currentModule = "{{ strtoupper($modul) }}";

    let timeLeft = 5;
    let timerInterval = null;
    const timerText = document.getElementById('timerText');
    const detectionStatus = document.getElementById('detectionStatus');

    function startTimer() {
        if (timerInterval) clearInterval(timerInterval);
        timeLeft = 5;
        timerText.innerText = timeLeft;
        timerText.style.color = '#C07EB5';

        timerInterval = setInterval(() => {
            timeLeft--;
            timerText.innerText = timeLeft >= 0 ? timeLeft : 0;

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                timerText.innerText = '0';
                detectionStatus.innerText = 'Waktu habis! Coba lagi.';
                detectionStatus.style.color = '#EF4444';
                setTimeout(() => {
                    startTimer();
                    detectionStatus.innerText = 'Mendeteksi Tangan...';
                    detectionStatus.style.color = '';
                }, 2000);
            }
        }, 1000);
    }

    async function startCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            const video = document.getElementById('cameraFeed');
            video.srcObject = stream;
            video.style.display = 'block';
            document.getElementById('cameraPlaceholder').style.display = 'none';
            detectionStatus.innerText = 'Mendeteksi Tangan...';
        } catch (err) {
            console.warn('Kamera tidak bisa diakses:', err);
            document.getElementById('cameraPlaceholder').style.display = 'flex';
            detectionStatus.innerText = 'Izinkan akses kamera untuk mendeteksi isyarat.';
        }
    }

    function markAsMastered() {
        let masteredLetters = localStorage.getItem('signlearn_mastered');
        masteredLetters = masteredLetters ? JSON.parse(masteredLetters) : [];

        if (!masteredLetters.includes(currentLetter)) {
            masteredLetters.push(currentLetter);
            localStorage.setItem('signlearn_mastered', JSON.stringify(masteredLetters));
            showToast(`🎉 Selamat! Huruf ${currentLetter} berhasil dikuasai! 🎉`);
            return true;
        } else {
            showToast(`Huruf ${currentLetter} sudah kamu kuasai sebelumnya! 👍`, 'info');
            return false;
        }
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.innerText = message;
        toast.className = `fixed bottom-5 left-1/2 transform -translate-x-1/2 px-5 py-2 rounded-full shadow-lg text-sm z-50 ${type === 'success' ? 'bg-green-500' : 'bg-blue-500'} text-white`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    }

    function resetPractice() {
        startTimer();
        detectionStatus.innerText = 'Mendeteksi Tangan...';
        detectionStatus.style.color = '';
        showToast('Mulai praktik! Peragakan isyarat dalam 5 detik.', 'info');
    }

    document.getElementById('practiceBtn').addEventListener('click', resetPractice);
    document.getElementById('masteredBtn').addEventListener('click', markAsMastered);

    startCamera();
    startTimer();
</script>
@endpush
@include('layout.footer')
@endsection
