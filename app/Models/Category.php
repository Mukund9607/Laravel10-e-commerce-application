<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Subcategory;
class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    
    public function subcategories()
{
    return $this->hasMany(Subcategory::class, 'category_id');
}

}
