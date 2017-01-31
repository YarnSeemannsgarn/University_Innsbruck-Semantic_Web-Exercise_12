<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'events';

  /**
   * Get the tickets for the event.
   */
  public function tickets()
  {
    return $this->hasMany('App\Ticket');
  }

  /**
   * Get the addresse of the event.
   */
  public function address()
  {
    return $this->belongsTo('App\Address');
  }

  /**
   * Get the available tickets of the event
   */
  public function availableTickets()
  {
    $availableTickets = array();
    foreach ($this->tickets()->get() as $ticket) {
      if ($ticket->has('order')->get()) {
        array_push($availableTickets, $ticket);
      }
    }
    return $availableTickets;
  }
}
