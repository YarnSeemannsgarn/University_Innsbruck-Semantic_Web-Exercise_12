<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APITest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
      $response = $this->json('POST', '/api/buy-ticket', array(
        "@context" => "http://schema.org/",
        "@type" => "BuyAction",
        "agent" => array(
          "@type" => "Person",
          "givenName" => "Jan",
          "familyName" => "Schlenker",
          "birthDate" => "1990-08-02",
          "email" => "jan.schlenker@student.uibk.ac.at"
        ),
        "object" => array(
          "@type" => "Offer",
          "@id" => "1"
        )
      ));
      $this->assertTrue($response->status() == 200);
      $json = json_decode($response->getContent(), true);
      $this->assertTrue($json['@context'] == 'http://schema.org/');
      $this->assertTrue($json['@type'] == 'BuyAction');
      $this->assertTrue($json['actionStatus'] == 'CompletedActionStatus');
      $this->assertTrue($json['result']['@type'] === "Order");
    }
}
