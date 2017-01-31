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
  public function addresse()
  {
    return $this->hasOne('App\Addresse');
  }
}
