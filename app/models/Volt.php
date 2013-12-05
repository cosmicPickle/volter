<?php

class Volt extends Eloquent {
    
    protected $table = 'volts';
    protected $fillable = array('*');
    
    public function fromUser()
    {
        return $this->belongsTo("User", "from_uid");
    }
    
    public function toUser()
    {
        return $this->belongsTo("User", "to_uid");
    }
    
    public function category()
    {
        return $this->belongsTo('Category', 'cat_id');
    }
}
