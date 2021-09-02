<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function path()
    {
        return '/books/'.$this->id;
    }

    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = Author::firstOrCreate([
            'name' =>$author
        ])->id;
    }

    public function checkout(User $user)
    {

        $this->reservations()->create([
            'checked_out_at' => now(),
            'user_id' => $user->id,
            'book_id' => $this->id,
        ]);
    }
    public function checkin($user)
    {

        $reservation = $this->reservations()->where('user_id',$user->id)
            ->whereNotNull('checked_out_at')
            ->whereNull('checked_in_at')
            ->first();
        if (!$reservation) {
            throw new \Exception();
        }
        $reservation->update([
            "checked_in_at" => now()
        ]);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
