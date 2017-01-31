<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
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
   * Get the event of the ticket.
   */
  public function person()
  {
    return $this->belongsTo('App\Person');
  }
}
