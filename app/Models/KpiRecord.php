<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiRecord extends Model
{
    // Allow mass assignment for the import script
    protected $fillable = [
        'type', 
        'period', 
        'after_po_oos', 
        'per_branch_oos', 
        'before_po_oos', 
        'class_a_oos', 
        'doi',
        'class_a_doi' // Added to support Class A DOI imports
    ];
}