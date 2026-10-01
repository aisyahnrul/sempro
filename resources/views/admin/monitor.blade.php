@extends('layouts.app')
@section('title','Monitoring Pengajuan')
@section('page-title','Monitoring Pengajuan Proposal')
@section('page-subtitle','Pantau seluruh status pengajuan proposal sempro mahasiswa')
@section('content')
<div class="grid-3">
    <div class="stat"><div class="num">12</div><div class="lbl">Total pengajuan</div></div>
    <div class="stat"><div class="num">4</div><div class="lbl">Sedang direvisi</div></div>
    <div class="stat"><div class="num">5</div><div class="lbl">Disetujui / terjadwal</div></div>
</div>
<div class="card">
    <div class="card-head"><h3>Seluruh Pengajuan Proposal</h3><span class="muted">12 pengajuan</span></div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Mahasiswa</th><th>Judul Proposal</th><th>Dosen Pembimbing</th><th>Status</th><th>Update Terakhir</th><th></th></tr></thead>
            <tbody>
                <tr><td><b>Siti Rahma</b><br><span class="muted">2021001</span></td><td>Rancang Bangun Sistem Informasi Inventaris Berbasis Web</td><td>Dr. Budi Santoso, M.Kom</td><td>@include('partials.status-badge',['status'=>'Diajukan'])</td><td class="muted">20 Agustus 2026</td><td><button class="btn btn-outline btn-sm" type="button">Detail</button></td></tr>
                <tr><td><b>Dewi Lestari</b><br><span class="muted">2021003</span></td><td>Analisis Sentimen Ulasan Produk Menggunakan Naive Bayes</td><td>Dr. Budi Santoso, M.Kom</td><td>@include('partials.status-badge',['status'=>'Revisi'])</td><td class="muted">18 Agustus 2026</td><td><button class="btn btn-outline btn-sm" type="button">Detail</button></td></tr>
                <tr><td><b>Rizky Pratama</b><br><span class="muted">2021004</span></td><td>Sistem Pendukung Keputusan Pemilihan Beasiswa dengan Metode SAW</td><td>Dr. Ani Wijaya, M.T</td><td>@include('partials.status-badge',['status'=>'Ditinjau Ulang'])</td><td class="muted">19 Agustus 2026</td><td><button class="btn btn-outline btn-sm" type="button">Detail</button></td></tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
