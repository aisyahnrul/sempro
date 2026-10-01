@extends('layouts.app')
@section('title','Ajukan Proposal')
@section('page-title','Ajukan Proposal')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')
@section('content')
<div class="card" style="max-width:760px;">
    <div class="card-head"><div><h3>Pengajuan Proposal</h3><p style="margin:4px 0 0;">Isi judul dan unggah berkas proposal dalam format PDF.</p></div></div>
    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form action="{{ route('mahasiswa.proposal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="field"><label for="judul">Judul Proposal</label><input type="text" id="judul" name="judul" value="{{ old('judul') }}" maxlength="255" required></div>
        <div class="field"><label for="file_proposal">Berkas Proposal (PDF)</label><input type="file" id="file_proposal" name="file_proposal" accept="application/pdf,.pdf" required><div class="small" style="margin-top:6px;">Format PDF, maksimal 10 MB.</div></div>
        <div class="info-banner"><p class="small">Setelah diajukan, proposal akan masuk ke proses review dosen pembimbing.</p></div>
        <div class="form-actions"><button class="btn btn-primary" type="submit">Kirim Proposal</button><a class="btn btn-outline" href="{{ route('mahasiswa.proposal.index') }}">Batal</a></div>
    </form>
</div>
@endsection
