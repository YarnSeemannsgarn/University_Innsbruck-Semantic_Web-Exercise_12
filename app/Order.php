<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  /**
   * Get the ticket for order.
   */
  public function ticket()
  {
    return $this->belongsTo('App\Ticket');
  }

  /**
   * Get the person of the order.
   */
  public function person()
  {
    return $this->belongsTo('App\Person');
  }
}
