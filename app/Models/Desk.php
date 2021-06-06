<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desk extends Model
{
    use HasFactory;
    protected $fillable = ['desk_name'];
    public function tasks()
    {
        return $this->hasMany(Task::class, 'desk_id', 'id')->get();
    }
}
