<x-layout title="Detail Mata Kuliah">

    <h2>{{ $course['name'] }}</h2>

    <p>Kode Mata Kuliah: {{ $course['code'] }}</p>
    <p>SKS: {{ $course['sks'] }}</p>
    <p>Semester: {{ $course['semester'] }}</p>

    <a href="{{ route('mata-kuliah.index') }}">
        Kembali ke Daftar Mata Kuliah
    </a>

</x-layout>