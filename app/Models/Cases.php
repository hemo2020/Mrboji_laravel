<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cases extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'cases';

    const PENDING = 'pending';
    const IN_PROGRESS = 'in_progress';
    const COMPLETED = 'completed';
    const CLOSE = 'close';

    const STATUSES = [
        self::PENDING, self::IN_PROGRESS, self::COMPLETED, self::CLOSE
    ];

    const statusColour = [
        self::PENDING => 'warning',
        self::IN_PROGRESS => 'info',
        self::COMPLETED => 'success',
        self::CLOSE => 'dark',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function pricing(): HasMany
    {
        return $this->hasMany(CasePricing::class, 'case_id');
    }

    public static function getStatusLabel($status): string
    {
        return  '<span class="badge bg-'.Cases::statusColour[$status].'">'.$status.'</span>';
    }
}
