<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utu extends Model
{
    /**
    * Get the parent.
    */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
    * The Utus that belong to the Utu.
    */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function classiLang($lang)
    {
        $string = $this->$lang;

        if ($this->parent) {
            $string = $this->parent->$lang . ' » ' . $string;
            if ($this->parent->parent) {
                $string = $this->parent->parent->$lang . ' » ' . $string;
                if ($this->parent->parent->parent) {
                    $string = $this->parent->parent->parent->$lang . ' » ' . $string;
                    if ($this->parent->parent->parent->parent) {
                        $string = $this->parent->parent->parent->parent->$lang . ' » ' . $string;
                    }
                }
            }
        }

        return $string;
    }
}
