<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'profile_pic_url',
        'email',
        'is_group'
    ];

    public static function verifyContact($number)
    {
        $exists = Contact::where('number', $number)->exists();
       if($exists){
           return true;
       }else{
           return false;
       }
    }

    public static function getIdContact($number)
    {
        $contact = Contact::where('number', $number)->first();
        return $contact->id;
    }
}
