<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'added_by',
        'status',
        'priority',
        'due_date',
        'completed_at',
    ];
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
