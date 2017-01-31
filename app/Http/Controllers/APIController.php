<?php

namespace App\Http\Controllers;

use App\Event;
use DateTime;
use Illuminate\Support\Facades\Input;

class APIController extends Controller
{
  /**
   * Entry point for API
   *
   * @return Response
   */
  public function entry()
  {
    $jsonArray = array(
      "@context" => "http://schema.org",
      "@type" => "SearchAction",
      "target" => array(
        "@type" => "EntryPoint",
        "urlTemplate" => "http://localhost:8000/api/search/?keyword={search_keyword}"
      ),
      "query-input" => array(
        "@type" => "PropertyValueSpecification",
        "valueName" => "search_keyword",
        "valueRequired" => "http://schema.org/True"
      )
    );

    return response()->json($jsonArray, 200, [], JSON_UNESCAPED_SLASHES);
  }

  /**
   * Search for events
   *
   * @return Response
   */
  public function search()
  {
    $keyword = Input::get('keyword');
    if (is_null($keyword))
      return response()->json();

    $events = Event::where('name' , 'like', '%' . $keyword . '%')->get();
    $eventsArray = array();
    foreach ($events as $event) {
      $offersArray = array();
      foreach ($event->availableTickets() as $availableTicket) {
        $offerArray = array(
          "@type" => "Offer",
          "price" => $availableTicket->price,
          "priceCurrency" => "EUR",
          "acceptedPaymentMethod" => [
            array(
              "@type" => "PaymentMethod",
              "url" => "http://purl.org/goodrelations/v1#ByBankTransferInAdvance"
            ),
            array(
              "@type" => "PaymentMethod",
              "url" => "http://purl.org/goodrelations/v1#DirectDebit"
            )
          ],
          "potentialAction" => array(
            "@type" => "BuyAction",
            "result" => array(
              "@type" => "Order",
              "orderDate-output" => "required"
            )
          )
        );
        array_push($offersArray, $offerArray);
      }

      $address = $event->address;
      $eventArray = array(
        "@context" => "http://schema.org",
        "@type" => "Event",
        "name" => $event->name,
        "description" => $event->description,
        "url" => $event->url,
        "startDate" => date_format(date_create($event->start_date), DateTime::ISO8601),
        "endDate" => date_format(date_create($event->end_date), DateTime::ISO8601),
        "location" => array(
          "@type" => "Place",
          "name" => $event->venue,
          "address" => array(
            "@type" => "PostalAddress",
            "addressLocality" => $address->city,
            "postalCode" => $address->zip_code,
            "streetAddress" => $address->street
          )
        ),
        "offers" => $offersArray
      );
      array_push($eventsArray, $eventArray);
    }

    return response()->json($eventsArray, 200, [], JSON_UNESCAPED_SLASHES);
  }
}