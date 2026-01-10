<?php

namespace App\Http\Controllers\Landing\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManagerCPM\PsikologStaff;

class PsikologController extends Controller
{
    public function registrationPsikolog()
    {
        return view('landing.product.counseling.psikolog.registration-psikolog');
    }

    public function storePsikologStaffRegistration(Request $request)
    {
        $rules = [
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
        ];

        $validatedData = $request->validate($rules);

        try {
            // Format tanggal
            $tanggalLahir = \DateTime::createFromFormat('d/m/Y', $request->tanggal_Lahir);
            $jadwalTanggal = \DateTime::createFromFormat('d/m/Y', $request->jadwal_tanggal);

            $data = $validatedData;
            $data['tanggal_Lahir'] = $tanggalLahir ? $tanggalLahir->format('Y-m-d') : null;
            $data['jadwal_tanggal'] = $jadwalTanggal ? $jadwalTanggal->format('Y-m-d') : null;

            PsikologStaff::create($data);

            return view('landing.product.counseling.summary-counseling');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')
                ->withInput();
        }
    }
}
