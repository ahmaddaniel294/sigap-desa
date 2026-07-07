<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    public const STATUS_DIAJUKAN = 'Diajukan';
    public const STATUS_DIPROSES = 'Diproses';
    public const STATUS_SELESAI = 'Selesai';

    public const STATUS_FLOW = [
        self::STATUS_DIAJUKAN,
        self::STATUS_DIPROSES,
        self::STATUS_SELESAI,
    ];

    public const CATEGORIES = [
        'Jalan Rusak',
        'Penerangan Jalan',
        'Sampah & Kebersihan',
        'Fasilitas Umum',
        'Keamanan & Ketertiban',
        'Air Bersih & Drainase',
        'Administrasi Kependudukan',
        'Lainnya',
    ];

    protected $fillable = [
        'user_id',
        'category',
        'location',
        'description',
        'photo',
        'status',
        'admin_note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusStepIndex(): int
    {
        $index = array_search($this->status, self::STATUS_FLOW, true);

        return $index === false ? 0 : $index;
    }
}
