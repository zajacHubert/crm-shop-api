<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'title',
        'desc',
        'category',
        'price',
        'order_id',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('id');
    }
}
