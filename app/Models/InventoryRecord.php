<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'area',
        'pareto_class',
        'branch',
        'model',
        'rank',
        'stock_status',
        'stock_status_count',
        'remaining_inventory',
        'suggested_transfer',
        'doi',
    ];
}