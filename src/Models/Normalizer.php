<?php

namespace Rabsana\Normalizer\Models;


use Illuminate\Database\Eloquent\Model;

class Normalizer extends Model
{
    protected $table = 'rabsana_normalizer_normalizers';

    protected $fillable = [
        'from', 'to', 'ratio', 'prop', 'active', 'normalizable_id', 'normalizable_type', 'user_id'
    ];

    protected $appends = ['user_name'];

    public function normalizable(){
        return $this->morphTo();
    }

    public function scopeProp($query, $prop){
        return $query->where('prop', $prop);
    }

    public function scopeRange($query, $value){
        return $query->where('from', '<=', $value)->where('to', '>=', $value);
    }

    public function scopeUserId($query, $userId){
        if(is_null($userId)){
            return $query->whereNull('user_id');
        }

        return $query->where('user_id', $userId);
    }

    public function scopeActive($query){
        return $query->where('active', true);
    }

    public function user(){
        return $this->belongsTo('App\User')->withDefault();
    }

    public function getUserNameAttribute(){
        if(is_null($this->user_id)){
            return trans('rabsana-normalizer::messages.all_users');
        }else{
            return $this->user->name;
        }
    }
}
