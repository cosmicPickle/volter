<?php

class Achievement extends Eloquent {
    
    protected $table = 'achievements';
    protected $fillable = array('*');

    public function users()
    {
        return $this->belongsToMany("User", "achievement_records", "achievement_id", "fb_uid");
    }
    
    public function category()
    {
        return $this->belongsTo("Category", "cat_id");
    }
    
    public function noUser($fb_uid)
    {
        //TODO: Update selects
        return $achs = DB::table('achievements')
                        ->leftJoin('achievement_records','achievement_records.achievement_id', '=', 'achievements.id')
                        ->leftJoin('categories', 'achievements.cat_id', '=', 'categories.id')
                        ->where('achievement_records.fb_uid', '!=', $fb_uid)
                        ->orWhereNull('achievement_records.fb_uid')
                        ->get();
    }
}
