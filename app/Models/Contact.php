<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Log;
use App\Models\Codedddstate;

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
       return Contact::firstWhere('number', $number) !== null;
    }

    public static function verifyGroup($number)
    {
       return Contact::firstWhere('number', $number) !== null;
    }

    public static function getIdContact($number)
    {
        return Contact::firstWhere('number', $number)->id;
    }

    public static function addContact($request)
    {
            $locationDdd = Codedddstate::dddlocate(substr($request->from, 2, 2));
            $contact = new Contact();
            $contact->name = $request->pushName;
            $contact->number = $request->from;
            $contact->location_ddd = $locationDdd->state . ' - ' . $locationDdd->region;
            $contact->save();

            Log::info('contato criado');

        return $contact;
    }
}
