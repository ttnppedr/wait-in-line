<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Desk extends Model
{
    protected $fillable = ['user_id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function serveCustomer(User $user)
    {
        $this->user_id = $user->id;
        $this->serving_card = $user->card;

        $this->save();

        $user->card = null;

        $user->save();
    }

    public static function findEmpty()
    {
        return static::where('id', '!=', 0)->where('serving_card', null)->first();
    }

    public function isServing()
    {
        return $this->serving_card !== null;
    }

    public function leaveCustomer()
    {
        $this->user_id = null;
        $this->serving_card = null;

        $this->save();
    }

    public static function servingCard()
    {
        return static::whereNotNull('serving_card')->max('serving_card');
    }

    public static function isOverReleasedCard()
    {
        return static::servingCard() >= User::max('card');
    }

    public static function skip($count = 1)
    {
        static::firstOrCreate(['id' => 6]);
        $virtualDesk = static::find(6);

        $virtualDesk->serving_card = static::servingCard() + 1;
        $virtualDesk->save();
    }
}
