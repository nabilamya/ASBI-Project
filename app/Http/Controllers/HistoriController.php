<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoriController extends Controller
{
    public function index()
    {
        $riwayat = [
            [
                'id'          => 1,
                'tipe'        => 'praktik',   // 'praktik' | 'kuis'
                'judul'       => 'Praktik Huruf',
                'subjudul'    => 'BISINDO - A',
                'skor'        => 90,
                'benar'       => null,
                'salah'       => null,
                'total_soal'  => null,
                'tanggal'     => '15 Apr 2026, 10:30',
                'durasi'      => '12 menit',
                'kategori'    => 'BISINDO',
                'level'       => 'Pemula',
                // Detail khusus praktik huruf
                'huruf'       => 'A',
                'status_hasil' => 'Sangat Baik',   // Sangat Baik / Baik / Cukup / Perlu Latihan
                'rangkuman'   => 'Kamu berhasil mengenali huruf A dengan sangat baik! Gerakan tanganmu sudah tepat dan konsisten. Terus pertahankan dan lanjutkan ke huruf berikutnya.',
                // Gambar/video dari webcam — taruh di: public/assets/praktik/sesi-1.jpg
                // Bisa berupa array gambar snapshot atau path video
                'media'       => [
                    ['tipe' => 'gambar', 'path' => 'assets/praktik/sesi-1-a.jpg', 'label' => 'Snapshot 1'],
                    ['tipe' => 'gambar', 'path' => 'assets/praktik/sesi-1-b.jpg', 'label' => 'Snapshot 2'],
                    // ['tipe' => 'video', 'path' => 'assets/praktik/sesi-1.mp4', 'label' => 'Rekaman Sesi'],
                ],
            ],
            [
                'id'          => 2,
                'tipe'        => 'kuis',
                'judul'       => 'Kuis Kata',
                'subjudul'    => 'Pemula',
                'skor'        => 75,
                'benar'       => 3,
                'salah'       => 1,
                'total_soal'  => 4,
                'tanggal'     => '14 Apr 2026, 14:15',
                'durasi'      => '8 menit',
                'kategori'    => 'BISINDO',
                'level'       => 'Pemula',
                'huruf'       => null,
                'status_hasil' => null,
                'rangkuman'   => null,
                'media'       => [],
                // Detail soal yang sudah dikerjakan
                'soal_detail' => [
                    [
                        'nomor'   => 1,
                        'soal'    => 'Huruf apa yang ditunjukkan gerakan ini?',
                        // Gambar soal — taruh di: public/assets/soal/huruf-v.png
                        'img'     => 'assets/soal/huruf-v.png',
                        'pilihan' => ['A', 'B', 'V', 'C'],
                        'jawaban_user'   => 'V',
                        'jawaban_benar'  => 'V',
                        'benar'   => true,
                    ],
                    [
                        'nomor'   => 2,
                        'soal'    => 'Huruf apa yang ditunjukkan gerakan ini?',
                        'img'     => 'assets/soal/huruf-b.png',
                        'pilihan' => ['A', 'B', 'D', 'E'],
                        'jawaban_user'   => 'A',
                        'jawaban_benar'  => 'B',
                        'benar'   => false,
                    ],
                    [
                        'nomor'   => 3,
                        'soal'    => 'Huruf apa yang ditunjukkan gerakan ini?',
                        'img'     => 'assets/soal/huruf-c.png',
                        'pilihan' => ['C', 'D', 'G', 'H'],
                        'jawaban_user'   => 'C',
                        'jawaban_benar'  => 'C',
                        'benar'   => true,
                    ],
                    [
                        'nomor'   => 4,
                        'soal'    => 'Huruf apa yang ditunjukkan gerakan ini?',
                        'img'     => 'assets/soal/huruf-d.png',
                        'pilihan' => ['B', 'C', 'D', 'E'],
                        'jawaban_user'   => 'D',
                        'jawaban_benar'  => 'D',
                        'benar'   => true,
                    ],
                ],
            ],
            [
                'id'          => 3,
                'tipe'        => 'praktik',
                'judul'       => 'Praktik Huruf',
                'subjudul'    => 'BISINDO - B',
                'skor'        => 70,
                'benar'       => null,
                'salah'       => null,
                'total_soal'  => null,
                'tanggal'     => '13 Apr 2026, 09:00',
                'durasi'      => '15 menit',
                'kategori'    => 'BISINDO',
                'level'       => 'Pemula',
                'huruf'       => 'B',
                'status_hasil' => 'Baik',
                'rangkuman'   => 'Gerakan huruf B sudah cukup baik, namun posisi jari perlu sedikit diperbaiki. Coba perhatikan lagi video panduan dan ulangi latihan.',
                'media'       => [
                    ['tipe' => 'gambar', 'path' => 'assets/praktik/sesi-3-a.jpg', 'label' => 'Snapshot 1'],
                ],
            ],
            [
                'id'          => 4,
                'tipe'        => 'praktik',
                'judul'       => 'Praktik Huruf',
                'subjudul'    => 'SIBI - A',
                'skor'        => 60,
                'benar'       => null,
                'salah'       => null,
                'total_soal'  => null,
                'tanggal'     => '12 Apr 2026, 11:45',
                'durasi'      => '10 menit',
                'kategori'    => 'SIBI',
                'level'       => 'Pemula',
                'huruf'       => 'A',
                'status_hasil' => 'Cukup',
                'rangkuman'   => 'Latihan huruf A SIBI masih perlu ditingkatkan. Pastikan sudut tangan dan orientasi jari sesuai panduan. Jangan menyerah, terus berlatih!',
                'media'       => [],
            ],
        ];

        return view('histori', compact('riwayat'));
    }
}
