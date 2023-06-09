<?php

namespace App\Models;

use App\Models\User;
use App\Models\Status;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    // protected $fillable = [
    //     'title','excerpt','body'
    // ];
    protected $guarded = ['id'];
   protected $with = ['user','category','condition'];

   public function scopeFilter($query, array $filters){
    // if(isset($filters['search']) ? $filters['search'] : false){
    //    return $query->where('title', 'like', '%'. $filters['search'] .'%')
    //             ->orWhere('body', 'like', '%'. request('search') .'%')
    //             ;
    // }
    $query->when($filters['search'] ?? false, function($query, $search){
        return $query->where('title', 'like', '%'. $search .'%');
    });
    $query->when($filters['category'] ?? false, function($query, $category){
        return $query->whereHas('category',function($query) use ($category){
            $query->where('slug',$category);
        });
    });
    $query->when($filters['user'] ?? false, function($query, $user){
        return $query->whereHas('user',function($query) use ($user){
            $query->where('nim',$user);
        });
    });
   }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function condition(){
        return $this->belongsTo(Condition::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
    public function klaims(){
        return $this->hasMany(Klaim::class);
    }

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
