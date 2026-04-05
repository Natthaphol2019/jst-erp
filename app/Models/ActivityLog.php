<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Get the user that performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subject model that was affected.
     */
    public function subject()
    {
        return $this->morphTo('subject');
    }

    /**
     * Scope: Filter by log name.
     */
    public function scopeForLog(Builder $query, string $logName): Builder
    {
        return $query->where('log_name', $logName);
    }

    /**
     * Scope: Filter by subject type and optionally subject id.
     */
    public function scopeForSubject(Builder $query, string $type, ?int $id = null): Builder
    {
        $query->where('subject_type', $type);
        if ($id !== null) {
            $query->where('subject_id', $id);
        }
        return $query;
    }

    /**
     * Scope: Filter by user.
     */
    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Order by most recent.
     */
    public function scopeRecent(Builder $query, int $days = 30): Builder
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days))
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the action type from the description.
     */
    public function getActionTypeAttribute(): string
    {
        $desc = strtolower($this->description);
        if (str_contains($desc, 'สร้าง') || str_contains($desc, 'created')) {
            return 'created';
        }
        if (str_contains($desc, 'ลบ') || str_contains($desc, 'deleted')) {
            return 'deleted';
        }
        if (str_contains($desc, 'แก้ไข') || str_contains($desc, 'updated')) {
            return 'updated';
        }
        return 'other';
    }

    /**
     * Get human-readable action type label.
     */
    public function getActionLabelAttribute(): string
    {
        return match ($this->action_type) {
            'created' => 'สร้าง',
            'updated' => 'แก้ไข',
            'deleted' => 'ลบ',
            default => 'อื่นๆ',
        };
    }

    /**
     * Get action badge class.
     */
    public function getActionBadgeClassAttribute(): string
    {
        return match ($this->action_type) {
            'created' => 'bg-success',
            'updated' => 'bg-warning text-dark',
            'deleted' => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    /**
     * Get the formatted subject name.
     */
    public function getSubjectNameAttribute(): ?string
    {
        if (!$this->subject) {
            $props = $this->properties ?? [];
            if (isset($props['attributes']['name'])) {
                return $props['attributes']['name'];
            }
            if (isset($props['attributes']['employee_code'])) {
                return $props['attributes']['employee_code'];
            }
            return $this->subject_type ? class_basename($this->subject_type) : null;
        }

        if (method_exists($this->subject, 'getNameAttribute')) {
            return $this->subject->name;
        }
        if (method_exists($this->subject, 'getFullnameAttribute')) {
            return $this->subject->fullname;
        }

        return class_basename($this->subject) . ' #' . $this->subject_id;
    }
}
