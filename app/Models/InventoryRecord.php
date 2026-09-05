<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryRecord extends Model
{
    protected $fillable = [
        'area', 'pareto_class', 'branch', 'model', 'stock_status', 
        'stock_status_count', 'remaining_inventory', 'suggested_transfer', 'doi'
    ];
}