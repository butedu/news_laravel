<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Post;
use App\Models\User;


/**
 * @property int $id
 * @property string $the_comment
 * @property int $post_id
 * @property int $user_id
 * @property bool $is_reviewed
 * @property \Illuminate\Support\Carbon|null $reviewed_at
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = ['the_comment', 'post_id', 'user_id', 'is_reviewed'];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_reviewed' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
