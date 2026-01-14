<?php

namespace App\Http\Controllers\Dashboard\ManagerCPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

use App\Models\ManagerCPM\PeerStaff;

class PeerStaffController extends Controller
{
    public function index(Request $request)
    {
        $PeerData = PeerStaff::orderBy('created_at', 'desc')->get();
        return view('dashboard.manager-cpm.peer.index', ['PeerData' => $PeerData]);
    }

    public function create(Request $request)
    {
        $konselling = $request->session()->get('konselling');
        return view('dashboard.manager-cpm.peer.create', compact('konselling'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jadwal_tanggal'    => 'required',
            'jadwal_pukul'      => 'required',
            'nama'              => 'required',
            'email'             => 'required',
            'tanggal_Lahir'     => 'required',
            'tempat_lahir'      => 'required',
            'alamat'            => 'required',
            'umur'              => 'required',
            'agama'             => 'required',
            'posisi_anak'       => 'required',
            'pendidikan'        => 'required',
            'riwayat_pekerjaan' => 'required',
            'divisi'            => 'required',
            'posisi'            => 'required',
            'status_pernikahan' => 'required',
            'no_wa'             => 'required',
            'suku'              => 'required',
            'topik_pengajuan'   => 'required',
            'cerita'            => 'required',
            'kegiatan_sosial'   => 'required',
            'hobi'              => 'required',
        ]);

        // Konversi tanggal
        $validatedData['jadwal_tanggal'] = Carbon::createFromFormat('d-m-Y', $validatedData['jadwal_tanggal'])->format('Y-m-d');
        $validatedData['tanggal_Lahir'] = Carbon::createFromFormat('d/m/Y', $validatedData['tanggal_Lahir'])->format('Y-m-d');

        unset($validatedData['tanggal_lahir']);


        $konselling = new PeerStaff();
        $konselling->fill($validatedData);
        $konselling->save();

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Peer staff berhasil dibuat.',
            'icon' => asset('assets\dashboard\success.webp')
        ]);
        return redirect()->route('dashboard.peer-staff.index');
    }

    public function show(Request $request, $id)
    {
        $PsikologDataDetails = PeerStaff::find($id);
        $konselling = $request->session()->get('konselling');
        return view('dashboard.manager-cpm.peer.show', ['PsikologDataDetails' => $PsikologDataDetails], compact('konselling'));
    }

    public function edit(Request $request, $id)
    {
        $PsikologDataDetails = PeerStaff::find($id);
        $konselling = $request->session()->get('konselling');
        return view('dashboard.manager-cpm.peer.edit', ['PsikologDataDetails' => $PsikologDataDetails], compact('konselling'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'jadwal_tanggal'    => 'required',
            'jadwal_pukul'      => 'required',
            'nama'              => 'required',
            'email'             => 'required',
            'tanggal_Lahir'     => 'required',
            'tempat_lahir'      => 'required',
            'alamat'            => 'required',
            'umur'              => 'required',
            'agama'             => 'required',
            'posisi_anak'       => 'required',
            'pendidikan'        => 'required',
            'riwayat_pekerjaan' => 'required',
            'divisi'            => 'required',
            'posisi'            => 'required',
            'status_pernikahan' => 'required',
            'no_wa'             => 'required',
            'suku'              => 'required',
            'topik_pengajuan'   => 'required',
            'cerita'            => 'required',
            'kegiatan_sosial'   => 'required',
            'hobi'              => 'required',
        ]);

        // Konversi tanggal
        $validatedData['jadwal_tanggal'] = Carbon::createFromFormat('d-m-Y', $validatedData['jadwal_tanggal'])->format('Y-m-d');
        $validatedData['tanggal_Lahir'] = Carbon::createFromFormat('d/m/Y', $validatedData['tanggal_Lahir'])->format('Y-m-d');


        $PsikologDataDetails = PeerStaff::find($id);
        $PsikologDataDetails->fill($validatedData);
        $PsikologDataDetails->save();

        session()->flash('alert', [
        'type' => 'success',
        'title' => 'Berhasil!',
        'message' => 'Data Peer Staff berhasil diperbarui.',
        'icon' => asset('assets\dashboard\success.webp')
        ]);

        return redirect()->route('dashboard.peer-staff.index');
    }
    public function destroy($id)
    {
        PeerStaff::where('id', $id)->delete();
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Data Peer Staff berhasil dihapus.',
            'icon' => asset('assets\dashboard\success.webp')
        ]);
        return redirect()->route('dashboard.peer-staff.index');
    }

    public function createpeer()
    {
        return view('dashboard.manager-cpm.peer.create');
    }

    public function showpeer()
    {
        return view('dashboard.manager-cpm.peer.show');
    }
}
