<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{
    protected $fillable = [
       'title', 'description', 'rating', 'view_count', 'user_id'
   ];

   public function user()
   {
       return $this->belongsTo(User::class);
   }


}
