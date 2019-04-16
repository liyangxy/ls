<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $fillable = [
       'title', 'description', 'rating', 'view_count', 'user_id', 'image'
   ];

   public function user()
   {
       return $this->belongsTo(User::class);
   }

   public function getImageUrlAttribute()
   {
       return config('app.url').'/'.$this->image;
   }


}
