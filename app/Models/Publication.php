<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    // protected $guarded = [];
    protected $fillable = [
      'title', 'abstract', 'description', 'primary_author',
      'secondary_author', 'published_at', 'url', 'isbn', 'name',
      'email', 'cover_image', 'publication_file'];
}
