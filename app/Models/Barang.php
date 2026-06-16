<?php

namespace App\Models;

use App\Models\User;
use App\Models\Jenis;
use App\Models\Satuan;
use App\Models\Supplier;
use App\Models\BarangMasuk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Barang extends Model
{
    use HasFactory, LogsActivity;

    /**
     * TABLE
     */
    protected $table = 'barangs';

    /**
     * MASS ASSIGNMENT
     */
    protected $fillable = [

        'kode_barang',
        'nama_barang',
        'deskripsi',

        'gambar',

        'stok',
        'stok_minimum',

        'jenis_id',
        'satuan_id',

        'supplier_id',

        'user_id'
    ];

    /**
     * DEFAULT VALUE
     */
    protected $attributes = [

        'stok' => 0
    ];

    /**
     * CASTING
     */
    protected $casts = [

        // otomatis jadi array
        'gambar' => 'array',

        'stok' => 'integer',
        'stok_minimum' => 'integer'
    ];

    /**
     * IGNORE UPDATED_AT IN ACTIVITY LOG
     */
    protected $ignoreChangedAttributes = [
        'updated_at'
    ];

    /**
     * ACTIVITY LOG
     */
    public function getActivitylogAttributes(): array
    {
        return array_diff(
            $this->fillable,
            $this->ignoreChangedAttributes
        );
    }

    /**
     * ACTIVITY LOG OPTIONS
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->logUnguarded();
    }

    /**
     * RELASI USER
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /**
     * RELASI JENIS
     */
    public function jenis()
    {
        return $this->belongsTo(
            Jenis::class,
            'jenis_id'
        );
    }

    /**
     * RELASI SATUAN
     */
    public function satuan()
    {
        return $this->belongsTo(
            Satuan::class,
            'satuan_id'
        );
    }

    /**
     * RELASI SUPPLIER
     */
    public function supplier()
    {
        return $this->belongsTo(
            Supplier::class,
            'supplier_id'
        );
    }

    /**
     * RELASI BARANG MASUK
     */
    public function barangMasuks()
    {
        return $this->hasMany(
            BarangMasuk::class,
            'barang_id'
        );
    }

    /**
     * LAST BARANG MASUK
     */
    public function lastBarangMasuk()
    {
        return $this->hasOne(
            BarangMasuk::class,
            'barang_id'
        )->latestOfMany();
    }

    /**
     * ACCESSOR GAMBAR
     * otomatis handle single image lama
     */
    public function getGambarAttribute($value)
    {
        // jika null
        if (!$value) {
            return [];
        }

        // jika sudah array
        if (is_array($value)) {
            return $value;
        }

        // decode json
        $decoded = json_decode($value, true);

        // jika json valid
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        // fallback single image lama
        return [$value];
    }
}