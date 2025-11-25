<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Jobs\SendNewsletterPost;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Image;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string $body
 * @property int $user_id
 * @property int $category_id
 * @property bool $approved
 * @property int $views
 */
class Post extends Model
{
    use HasFactory;
    
    /**
     * @var array<int, string>
     */
    protected $fillable = ['title','slug', 'excerpt', 'body', 'user_id','category_id', 'approved'];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'approved' => 'boolean',
        'views' => 'integer',
    ];
    
    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    } 

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    } 

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
    
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function image() {
        return $this->morphOne(Image::class, 'imageable');
    } 

    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'post_saves')->withTimestamps();
    }

    protected static function booted(): void
    {
        static::created(function (Post $post) {
            if ($post->approved) {
                SendNewsletterPost::dispatch($post->id);
            }
        });

        static::updated(function (Post $post) {
            if ($post->wasChanged('approved') && $post->approved) {
                SendNewsletterPost::dispatch($post->id);
            }
        });
    }

    // scope functions
    public function scopeApproved($query)
    {
        return $query->where('approved', 1);
    }

}
