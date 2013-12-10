<?php

class Category extends Eloquent {
    
    protected $table = 'categories';
    protected $fillable = array('*');
    
    public function volts()
    {
        return $this->hasMany('Volt','cat_id');
    }
    
    public function voltScores()
    {
        return $this->hasMany('VoltScore','cat_id');
    }
    
    public function achievements()
    {
        return $this->hasMany('Achievement', 'cat_id');
    }
}
