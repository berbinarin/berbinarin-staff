<?php

namespace App\Models\ManagerCPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsikologStaff extends Model
{
    use HasFactory;

    protected $table = 'psikologstaff';

    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_Lahir',
        'umur',
        'agama',
        'posisi_anak',
        'pendidikan',
        'riwayat_pekerjaan',
        'divisi',
        'posisi',
        'status_pernikahan',
        'alamat',
        'jadwal_tanggal',
        'jadwal_pukul',
        'no_wa',
        'suku',
        'email',
        'topik_pengajuan',
        'cerita',
        'kegiatan_sosial',
        'hobi',
    ];
}
