<?php

class VoltScores extends Eloquent {
    
    protected $table = 'volt_scores';
    protected $fillable = array('*');
    
    public function User()
    {
        return $this->belongsTo("User", "fb_uid");
    }
    
    public function category()
    {
        return $this->belongsTo('Category', 'cat_id');
    }
}
