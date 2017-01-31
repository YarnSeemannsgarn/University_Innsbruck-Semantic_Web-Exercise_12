<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'persons';

  /**
   * Get the addresse of the person.
   */
  public function addresse()
  {
    return $this->hasOne('App\Addresse');
  }

  /**
   * Get the tickets of the person.
   */
  public function tickets()
  {
    return $this->hasMany('App\Ticket');
  }
}
