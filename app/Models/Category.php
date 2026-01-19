<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'format_code', 'description'];

    public function surats()
    {
        return $this->hasMany(Surat::class);
    }
}
