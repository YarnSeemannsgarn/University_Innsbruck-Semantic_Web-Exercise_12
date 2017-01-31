<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tickets';

  /**
   * Get the event of the ticket.
   */
  public function event()
  {
    return $this->belongsTo('App\Event');
  }

  /**
   * Get the order for the ticket.
   */
  public function order()
  {
    return $this->hasOne('App\Order');
  }
}
