<?php

class User extends Eloquent {
        
	protected $table = 'users';
        protected $primaryKey = 'fb_uid';
        
        public function voltsOut()
        {
            return $this->hasMany("Volt", "from_uid");
        }
        
        public function voltsIn()
        {
            return $this->hasMany("Volt", "to_uid");
        }
        
        public function achievements()
        {
            return $this->belongsToMany("Achievement", "achievement_records", "fb_uid", "achievement_id");
        }
}