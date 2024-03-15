<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
	
	
     // Określenie tabeli, jeśli nazwa modelu w liczbie pojedynczej nie odpowiada nazwie tabeli w liczbie mnogiej
    protected $table = 'authors';

    // Określenie, które atrybuty mogą być masowo przypisywane
       protected $fillable = ['name', 'email', 'include_in_reports'];
  
  // Określenie relacji z innymi modelami, jeśli istnieją (np. książki)
    public function books()
    {
        return $this->hasMany(Book::class);
    }    
    
    
}
