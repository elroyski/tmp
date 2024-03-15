<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books'; 

    protected $fillable = ['ean', 'title', 'price', 'author', 'publishing_date', 'product_form'];

}