<?php

use App\Addresse;
use App\Event;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $format = 'Y-m-d H:i:s';

      // Event 1
      $addresse = new Addresse();
      $addresse->street = 'Feldstr. 12';
      $addresse->zip_code = 27793;
      $addresse->city = 'Wildeshausen';
      $addresse->save();

      $event = new Event();
      $event->name = 'STARLIGHT EXPRESS';
      $event->venue = 'Starlight Express Theater';
      $event->start_date = DateTime::createFromFormat($format, '2009-02-15 15:16:17');
      $event->addresse_id = $addresse->id;
      $event->save();

    }
}
