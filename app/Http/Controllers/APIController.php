<?php

namespace App\Http\Controllers;

use App\Event;
use App\Order;
use App\Person;
use App\Ticket;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use League\Flysystem\Exception;

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

    return response()->json($jsonArray, 200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
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
          "@id" => "http://localhost:8000/tickets/" . $availableTicket->id,
          "itemOffered" => array(
            "@type" => "Product",
            "name" => "Ticket",
            "additionalProperty" => array(
              "@type" => "PropertyValue",
              "name" => "code",
              "value" => $availableTicket->code
            )
          ),
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
          ),
          "result" => array(
            "@type" => "Order",
            "@id-output" => "required",
            "orderDate-ouput" => "required"
          ),
          "target:" => array(
            "@type" => "EntryPoint",
            "urlTemplate" => "http://localhost:8000/api/buy-ticket",
            "httpMethod" => "POST"
          )
        );
        array_push($offersArray, $offerArray);
      }

      $address = $event->address;
      $eventArray = array(
        "@context" => "http://schema.org",
        "@type" => "Event",
        "@id" => "http://localhost:8000/events/" . $event->id,
        "name" => $event->name,
        #"description" => $event->description,
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

    return response()->json($eventsArray, 200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  }

  /**
   * Buys ticket
   *
   * @return Response
   */
  public function buyTicket() {
    $json = Input::get();
    try {
      $context = isset($json['@context']) ? $json['@context'] : "";
      if(!isset($json['@type']) || $context . $json['@type'] != "http://schema.org/BuyAction")
        throw new Exception("Request JSON is not of type schema.org/BuyAction");

      if(!isset($json['agent']) ||
        !isset($json['agent']['@type']) || $context . $json['agent']['@type'] != "http://schema.org/Person" ||
        !isset($json['agent']['givenName']) ||
        !isset($json['agent']['familyName']) ||
        !isset($json['agent']['birthDate']) ||
        !isset($json['agent']['email']))
        throw new Exception("Agent not defined correctly");

      if(!isset($json['object']) ||
        !isset($json['object']['@type']) || $context . $json['object']['@type'] != "http://schema.org/Offer" ||
        !isset($json['object']['@id']))
        throw new Exception("Object of Action not set correctly");

      $explodedId = explode('/', $json['object']['@id']);
      $ticketId = end($explodedId);
      $ticket = Ticket::find($ticketId);
      if (count($ticket->has('order')->get()) != 0) {
        $jsonArray = array(
          "@context" => "http://schema.org/",
          "@type" => "BuyAction",
          "actionStatus" => "FailedActionStatus",
          "error" => "Ticket with id " . $json['object']['@id'] . " has been already bought",
          "object" => $json['object']
        );
      } else {
        $person = new Person();
        $person->first_name = $json['agent']['givenName'];
        $person->last_name = $json['agent']['familyName'];
        $person->birth_date = $json['agent']['birthDate'];
        $person->email = $json['agent']['email'];
        $person->save();

        $order = new Order();
        $order->ticket_id = $ticketId;
        $order->person_id = $person->id;
        $order->save();

        $jsonArray = array(
          "@context" => "http://schema.org/",
          "@type" => "BuyAction",
          "actionStatus" => "CompletedActionStatus",
          "object" => $json['object'],
          "result" => array(
            "@type" => "Order",
            "@id" => "http://localhost:8000/orders/" . $order->id,
            "orderDate" => date_format($order->created_at, DateTime::ISO8601)
          )
        );
      }

      return response()->json($jsonArray, 200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    } catch(\Exception $e) {
      return response()->json('Error: ' . $e->getMessage(), 400, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
  }
}