<?php

namespace App\Http\Controllers;

class CourseController extends Controller
{
    // Menampilkan daftar seluruh mata kuliah.
    public function index()
    {
        $courses = [
            [
                'id' => 1,
                'code' => 'SI2514024',
                'name' => 'Pemrograman Web',
                'sks' => 3,
                'semester' => 5,
                'dosen' => 'Aidil Saputra Kirsan, S.ST., M.Tr.Kom',
            ],
            [
                'id' => 2,
                'code' => 'KU2511003',
                'name' => 'Kewarganegaraan',
                'sks' => 2,
                'semester' => 5,
                'dosen' => 'Siti Rahmawati, M.Kom.',
            ],
            [
                'id' => 3,
                'code' => 'KU2513003',
                'name' => 'Inovasi Sosial',
                'sks' => 2,
                'semester' => 5,
                'dosen' => 'Hendy Indrawan Sunardi, S.Kom., M.Eng.',
            ],
            [
                'id' => 4,
                'code' => 'SI2514022',
                'name' => 'Perancangan dan Pengembangan Perangkat Lunak',
                'sks' => 3,
                'semester' => 5,
                'dosen' => 'Vika Fitratunnany Insanittaqwa, S.Kom., M.Kom.',
            ],
            [
                'id' => 5,
                'code' => 'SI2514023',
                'name' => 'Perencanaan Strategis Sistem Informasi',
                'sks' => 3,
                'semester' => 5,
                'dosen' => 'Yuyun Tri Wiranti, S.Kom., M.MT',
            ],
            [
                'id' => 6,
                'code' => 'SI2514025',
                'name' => 'Kecerdasan Bisnis',
                'sks' => 3,
                'semester' => 5,
                'dosen' => 'Nursanti Novi Arisa, M.Kom.',
            ],
            [
                'id' => 7,
                'code' => 'SI2514026',
                'name' => 'Perencanaan Arsitektur Teknologi Informasi',
                'sks' => 3,
                'semester' => 5,
                'dosen' => 'Hendy Indrawan Sunardi, S.Kom., M.Eng.',
            ],
            [
                'id' => 8,
                'code' => 'SI2514034',
                'name' => 'Perencanaan Keberlangsungan Bisnis',
                'sks' => 3,
                'semester' => 5,
                'dosen' => 'Ir. I Putu Deny Arthawan Sugih Prabowo, M.Eng.',
            ],
            [
                'id' => 9,
                'code' => 'SI2515043',
                'name' => 'Manajemen Sumber Daya Manusia',
                'sks' => 2,
                'semester' => 5,
                'dosen' => 'Vika Fitratunnany Insanittaqwa, S.Kom., M.Kom.',
            ],
        ];

        // Mengirim data mata kuliah ke halaman daftar.
        return view('courses.index', compact('courses'));
    }

    public function show($mataKuliah)
    {
        $courses = [
           [
                'id' => 1,
                'code' => 'SI2514024',
                'name' => 'Pemrograman Web',
                'sks' => 3,
                'semester' => 5,
                'dosen' => 'Aidil Saputra Kirsan, S.ST., M.Tr.Kom',
            ],
            [
                'id' => 2,
                'code' => 'KU2511003',
                'name' => 'Kewarganegaraan',
                'sks' => 2,
                'semester' => 5,
                'dosen' => 'Siti Rahmawati, M.Kom.',
            ],
            [
                'id' => 3,
                'code' => 'KU2513003',
                'name' => 'Inovasi Sosial',
                'sks' => 2,
                'semester' => 5,
                'dosen' => 'Hendy Indrawan Sunardi, S.Kom., M.Eng.',
            ],
            [
                'id' => 4,
                'code' => 'SI2514022',
                'name' => 'Perancangan dan Pengembangan Perangkat Lunak',
                'sks' => 3,
                'semester' => 5,
                'dosen' => 'Vika Fitratunnany Insanittaqwa, S.Kom., M.Kom.',
            ],
            [
                'id' => 5,
                'code' => 'SI2514023',
                'name' => 'Perencanaan Strategis Sistem Informasi',
                'sks' => 3,
                'semester' => 5,
                'dosen' => 'Yuyun Tri Wiranti, S.Kom., M.MT',
            ],
            [
                'id' => 6,
                'code' => 'SI2514025',
                'name' => 'Kecerdasan Bisnis',
                'sks' => 3,
                'semester' => 5,
                'dosen' => 'Nursanti Novi Arisa, M.Kom.',
            ],
            [
                'id' => 7,
                'code' => 'SI2514026',
                'name' => 'Perencanaan Arsitektur Teknologi Informasi',
                'sks' => 3,
                'semester' => 5,
                'dosen' => 'Hendy Indrawan Sunardi, S.Kom., M.Eng.',
            ],
            [
                'id' => 8,
                'code' => 'SI2514034',
                'name' => 'Perencanaan Keberlangsungan Bisnis',
                'sks' => 3,
                'semester' => 5,
                'dosen' => 'Ir. I Putu Deny Arthawan Sugih Prabowo, M.Eng.',
            ],
            [
                'id' => 9,
                'code' => 'SI2515043',
                'name' => 'Manajemen Sumber Daya Manusia',
                'sks' => 2,
                'semester' => 5,
                'dosen' => 'Vika Fitratunnany Insanittaqwa, S.Kom., M.Kom.',
            ],
        ];

        $course = collect($courses)->firstWhere('id', (int) $mataKuliah);

        abort_if($course === null, 404);

        return view('courses.show', compact('course'));
    }
    
}
