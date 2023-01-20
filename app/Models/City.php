<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected int $id;

    protected float $latitude;

    protected float $longitude;

    protected string $name;

    protected $fillable = ['name','latitude','longitude'];
}
