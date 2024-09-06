<?php

namespace App\Models;

use App\Models\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferFund extends Model
{
    use HasFactory;
	
	protected $table = 'transfer_funds';

    protected $fillable = ['debitor_account_uuid','creditor_account_uuid','amount'];

    public $guarded = [];
	
    public function debitorAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
