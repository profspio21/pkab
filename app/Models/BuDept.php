<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuDept extends Model
{
    use HasFactory;

    public $table = 'BuDept';

    protected $orderable = [
        'id',
        'bu_id',
        'dept_id',
    ];

    protected $filterable = [
        'id',
        'bu_id',
        'dept_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'bu_id',
        'dept_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function bu()
    {
        return $this->belongsTo(Bu::class);
    }

    public function dept()
    {
        return $this->belongsTo(Dept::class);
    }
}
