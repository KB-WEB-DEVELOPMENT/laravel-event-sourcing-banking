<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;
	
	protected $table = 'accounts';

    protected $fillable = ['account_uuid','balance','overdraft','user_id'];

    public $guarded = [];
	
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
