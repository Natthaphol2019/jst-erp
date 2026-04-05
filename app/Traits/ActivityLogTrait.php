<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait ActivityLogTrait
{
    /**
     * Boot the trait and register model events.
     */
    public static function bootActivityLogTrait(): void
    {
        static::created(function ($model) {
            $model->logActivity('created');
        });

        static::updated(function ($model) {
            $model->logActivity('updated');
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted');
        });
    }

    /**
     * Log the activity for this model.
     */
    protected function logActivity(string $action): void
    {
        $properties = [];
        $description = $this->generateDescription($action);

        if ($action === 'updated') {
            $properties = [
                'old' => $this->getDirtyOriginalValues(),
                'attributes' => $this->getCleanedAttributes(),
            ];
        } elseif ($action === 'created') {
            $properties = [
                'attributes' => $this->getCleanedAttributes(),
            ];
        } elseif ($action === 'deleted') {
            $properties = [
                'attributes' => $this->getCleanedAttributes(),
            ];
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'log_name' => $this->getLogName(),
            'description' => $description,
            'subject_type' => get_class($this),
            'subject_id' => $this->getKey(),
            'properties' => $properties,
        ]);
    }

    /**
     * Get the original values that were changed (before update).
     */
    protected function getDirtyOriginalValues(): array
    {
        $dirty = $this->getDirty();
        $original = [];

        foreach (array_keys($dirty) as $key) {
            $original[$key] = $this->getOriginal($key);
        }

        return $this->cleanAttributes($original);
    }

    /**
     * Get cleaned attributes (remove sensitive fields).
     */
    protected function getCleanedAttributes(): array
    {
        return $this->cleanAttributes($this->attributesToArray());
    }

    /**
     * Remove sensitive or unnecessary fields from attributes.
     */
    protected function cleanAttributes(array $attributes): array
    {
        $excluded = ['password', 'remember_token', 'updated_at', 'created_at', 'deleted_at'];

        foreach ($excluded as $key) {
            unset($attributes[$key]);
        }

        return $attributes;
    }

    /**
     * Generate a human-readable description for the action.
     */
    protected function generateDescription(string $action): string
    {
        $modelName = class_basename($this);
        $recordId = $this->getKey();
        $recordName = $this->getRecordName();

        $thaiModelName = $this->getThaiModelName();

        return match ($action) {
            'created' => "สร้าง{$thaiModelName}: {$recordName} (ID: {$recordId})",
            'updated' => "แก้ไข{$thaiModelName}: {$recordName} (ID: {$recordId})",
            'deleted' => "ลบ{$thaiModelName}: {$recordName} (ID: {$recordId})",
            default => "{$action} {$modelName} #{$recordId}",
        };
    }

    /**
     * Get a human-readable name for this record.
     */
    protected function getRecordName(): string
    {
        if (isset($this->attributes['name'])) {
            return $this->attributes['name'];
        }
        if (isset($this->attributes['employee_code'])) {
            $firstname = $this->attributes['firstname'] ?? '';
            $lastname = $this->attributes['lastname'] ?? '';
            return trim("{$this->attributes['employee_code']} {$firstname} {$lastname}");
        }
        if (isset($this->attributes['item_code'])) {
            return $this->attributes['item_code'];
        }

        return '#' . $this->getKey();
    }

    /**
     * Get Thai name for the model type.
     */
    protected function getThaiModelName(): string
    {
        return match (class_basename($this)) {
            'Employee' => 'พนักงาน',
            'Department' => 'แผนก',
            'Position' => 'ตำแหน่ง',
            'Item' => 'สินค้า',
            'ItemCategory' => 'หมวดหมู่สินค้า',
            'Requisition' => 'ใบเบิก',
            'RequisitionItem' => 'รายการเบิก',
            default => class_basename($this),
        };
    }

    /**
     * Get the log name for this model.
     */
    protected function getLogName(): string
    {
        return $this->activityLogName ?? 'default';
    }
}
