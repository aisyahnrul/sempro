<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proposal;

class MonitoringController extends Controller
{
    public function index()
    {
        $proposal = Proposal::with([
            'mahasiswa',
            'mahasiswa.bimbingan.dosen',
            'proposalVer',
        ])
        ->orderByDesc('id_prop')
        ->get();

        return view('admin.monitoring.index', compact('proposal'));
    }
}