<?php

use App\Address;
use App\Event;
use App\Ticket;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
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
      $address = new Address();
      $address->street = 'Stadionring 24';
      $address->zip_code = 44791;
      $address->city = 'Bochum';
      $address->save();

      $event = new Event();
      $event->name = 'STARLIGHT EXPRESS';
      $event->description = 'Es ist wieder Zeit für die Nacht der Weltmeisterschaft der Lokomotiven! Der STARLIGHT EXPRESS entführt seine Zuschauer wieder in ein traumhaftes Musical auf Rollerskates. Mit über 28 Jahren ungebrochener Ausstrahlungskraft ohne Unterbrechung, hat das Musical Rekorde gebrochen! STARLIGHT EXPRESS zählt zu einer der aufwendigsten Produktionen überhaupt. Das Zusammenspiel von Technik und Dramaturgie sucht seinesgleichen. Stuntskater fliegen über die Bühne und das Ensemble auf Rollschuhen erreicht eine Geschwindigkeit von bis zu 60 Stundenkilometern. Rasant bewegt es sich mitten durch die Ränge. Dem Publikum eröffnet sich dabei eine Welt voller Dynamik und Romantik. Waghalsige Akrobatik und packende Songs lösen zauberhafte Tanzszenen und ergreifende Balladen ab. Die schillernden Kostüme, in Szene gesetzt mit einem ausgefeilten Lichtkonzept, machen das Spektakel perfekt. Und auch darüber freut sich das Publikum: Starkomponist Andrew Lloyd Webber erfand die Weltmeisterschaft der Lokomotiven vor einem Vierteljahrhundert. Nun, 15 Millionen Besucher später, schrieb sein Sohn Alastair eine Liebesballade für STARLIGHT EXPRESS: „Für immer“. Seit dem 25. Geburtstag im Juni 2013 zeigt sich STARLIGHT EXPRESS mit einer neuen Licht- und Lasershow einmal mehr in frischem Glanz. Höchstes technisches Niveau garantiert zudem der Austausch der Soundanlage. Also nicht verpassen! STARLIGHT EXPRESS Tickets gibt\'s ab sofort bei Ticketmaster!';
      $event->url = 'http://www.ticketmaster.de/event/starlight-express-tickets/189707';
      $event->venue = 'Starlight Express Theater';
      $event->start_date = DateTime::createFromFormat($format, '2017-02-01 18:30:00');
      $event->address_id = $address->id;
      $event->save();

      // 5 Tickets with price 54.60
      for ($x = 1; $x <= 5; $x++) {
        $ticket = new Ticket();
        $ticket->price = 54.60;
        $ticket->code = $x;
        $ticket->event_id = $event->id;
        $ticket->save();
      }

      // 3 Tickets with price 117.90
      for ($x = 6; $x <= 8; $x++) {
        $ticket = new Ticket();
        $ticket->price = 117.90;
        $ticket->code = $x;
        $ticket->event_id = $event->id;
        $ticket->save();
      }


      // Event 2
      $address = new Address();
      $address->street = 'Goldgasse 1';
      $address->zip_code = 50688;
      $address->city = 'Köln';
      $address->save();

      $event = new Event();
      $event->name = 'BODYGUARD - Das Musical';
      $event->description = 'Bodyguard – Das Musical, seit November 2015 ist der mit dem WhatsOnStage Award prämierte Musical-Hit erstmals in Deutschland zu sehen. Schon seit 2012 begeistert das absolute Erfolgs-Musical im Londoner West End die Musical Liebhaber aus aller Welt. Die Londoner Originalproduktion ist in deutscher Fassung nun exklusiv im Musical Dome Köln zu sehen!

Die packende Hollywood-Lovestory um Popstar Rachel Marron und deren Bodyguard Frank Farmer lockte schon als Blockbuster sensationelle 6 Millionen Zuschauer in die Kinosäle Deutschlands. Hierbei spielten Whitney Houston und Kevin Costner das ungleiche Paar. Die von einem lebensbedrohlichen Stalker verfolgte Soul-Diva und ihr eiserner Leibwächter verbindet zunächst gar nichts, doch schließlich dann die ganz große Liebe. Aber reicht eine unsterbliche Liebe um das Böse zu besiegen? 

Dieses Musicalerlebnis wird nicht nur durch die leidenschaftliche Liebesgeschichte absolut sehenswert, sondern brilliert auch durch Neuerungen gegenüber des Kinohits. So liegt das Augenmerk nicht auf der Rolle des Bodyguards. Vielmehr steht die schillernde Sängerin im Vordergrund, die nicht nur ihren Leibwächter, sondern auch das gesamte Publikum in ihren Bann zieht! 

Der große Erfolg ist definitiv auch den weltberühmten Songs zum Film zuzuschreiben: Mit 45 Millionen verkauften Tonträgern bilden diese einer der erfolgreichsten Film-Soundtracks aller Zeiten und berühren auch heute noch Millionen von Herzen. In Köln erwarten Sie die original Grammy-prämierten Lieder mit Gänsehautgarantie! Von „Run to You“, über „I Have Nothing“ und „I Wanna Dance with Somebody“ bis hin zum absoluten Balladen-Klassiker „I Will Always Love You“, sind alle Welthits aus dem Liebestrack schlechthin dabei. 

Absolut erwähnenswert sind die beiden Hauptdarsteller! Patricia Meeden glänzt in der Rolle des Popstars und ist selbst auf dem besten Wege dahin: Seit sie als Solistin bei Dirty Dancing und in der Castingshow The Voice of Germany zu sehen war, ist Patricia selbst ein Stern am Musical-Himmel und eine absolute Topbesetzung für diese Rolle. Doch auch Jürgen Fischer, alias der Bodyguard, ist längst kein unbekannter Name mehr. Der ausgebildete Schauspieler stand schon für viele namhaften Produktionen vor der Kamera und bereichert das einmalige Musical an schauspielerischer Spitzenqualität. 

An Romantik, Spannung und Glamour ist dieses Meisterwerk wahrlich nicht zu übertreffen und ist daher ein absolutes Muss für alle Fans der funkelnden Musical-Welt! Bodyguard – Das Musical Tickets gibt es selbstverständlich hier bei Ticketmaster. Es ist wieder Zeit für die Nacht der Weltmeisterschaft der Lokomotiven! Der STARLIGHT EXPRESS entführt seine Zuschauer wieder in ein traumhaftes Musical auf Rollerskates. Mit über 28 Jahren ungebrochener Ausstrahlungskraft ohne Unterbrechung, hat das Musical Rekorde gebrochen! STARLIGHT EXPRESS zählt zu einer der aufwendigsten Produktionen überhaupt. Das Zusammenspiel von Technik und Dramaturgie sucht seinesgleichen. Stuntskater fliegen über die Bühne und das Ensemble auf Rollschuhen erreicht eine Geschwindigkeit von bis zu 60 Stundenkilometern. Rasant bewegt es sich mitten durch die Ränge. Dem Publikum eröffnet sich dabei eine Welt voller Dynamik und Romantik. Waghalsige Akrobatik und packende Songs lösen zauberhafte Tanzszenen und ergreifende Balladen ab. Die schillernden Kostüme, in Szene gesetzt mit einem ausgefeilten Lichtkonzept, machen das Spektakel perfekt. Und auch darüber freut sich das Publikum: Starkomponist Andrew Lloyd Webber erfand die Weltmeisterschaft der Lokomotiven vor einem Vierteljahrhundert. Nun, 15 Millionen Besucher später, schrieb sein Sohn Alastair eine Liebesballade für STARLIGHT EXPRESS: „Für immer“. Seit dem 25. Geburtstag im Juni 2013 zeigt sich STARLIGHT EXPRESS mit einer neuen Licht- und Lasershow einmal mehr in frischem Glanz. Höchstes technisches Niveau garantiert zudem der Austausch der Soundanlage. Also nicht verpassen! STARLIGHT EXPRESS Tickets gibt\'s ab sofort bei Ticketmaster!\'';
      $event->url = 'http://www.ticketmaster.de/artist/bodyguard-das-musical-tickets/894806';
      $event->venue = 'Musical Dome Köln';
      $event->start_date = DateTime::createFromFormat($format, '2017-02-02 19:30:00');
      $event->address_id = $address->id;
      $event->save();

      // 4 Tickets with price 36.40
      for ($x = 1; $x <= 4; $x++) {
        $ticket = new Ticket();
        $ticket->price = 36.40;
        $ticket->code = $x;
        $ticket->event_id = $event->id;
        $ticket->save();
      }
    }
}
