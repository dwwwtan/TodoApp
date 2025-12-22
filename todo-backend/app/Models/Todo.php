<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Todo extends Model
{
    use HasFactory;

    protected $table = 'todos';

    // ========================================
    // FILLABLE - Các field được phép mass assignment
    // ========================================
    protected $fillable = [
        'text',
        'completed'
    ];

    // ========================================
    // CASTS - Tự động convert kiểu dữ liệu
    // ========================================
    protected $casts = [
        'completed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // RELATIONSHIP - Todo belongs to User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
