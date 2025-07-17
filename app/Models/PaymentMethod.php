<?php    


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];

        public function order()
    {
        return $this->belongsTo(Order::class);

}
public function  Transaction(){
    return $this->belongsTo(Transaction::class);
}
}
