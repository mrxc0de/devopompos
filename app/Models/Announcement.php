<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    //
    protected $fillable = [
        'title',
        'content',
        'posted_by',
    ];
    // In app/Models/Announcement.php

    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }
}
