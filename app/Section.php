<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Section extends Model
{
     protected $table = 'sections';
      protected $fillable = [
        'name', 'description', 'logo',
    ];
      
      public function users()
    {
        return $this->belongsToMany('App\User', 'users_sections', 'section_id', 'user_id');
    }
}
