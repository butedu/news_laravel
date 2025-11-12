<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
 
    use HasFactory;

    protected $fillable = ['name','extension', 'path'];
    
    protected $appends = ['url'];

    public function imageable() {
        return $this -> morphTo();
    }
    
    /**
     * Get the full URL for the image
     */
    public function getUrlAttribute()
    {
        // Check if path exists and return full URL
        if ($this->path) {
            // If path already starts with http/https (external URL), return as is
            if (str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
                return $this->path;
            }
            
            // For local files, prepend /storage/
            return asset('storage/' . $this->path);
        }
        
        // Return placeholder if no path
        return asset('storage/placeholders/post_placeholder.jpg');
    }

}
