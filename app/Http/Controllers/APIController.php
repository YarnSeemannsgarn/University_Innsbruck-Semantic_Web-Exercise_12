<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

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
        "urlTemplate" => "http://localhost:8080/Ticketmaster/api/seach/?keyword={search_keyword}"
      ),
      "query-input" => array(
        "@type" => "PropertyValueSpecification",
        "valueName" => "search_keyword",
        "valueRequired" => "http://schema.org/True"
      )
    );
    return response()->json($jsonArray, 200, [], JSON_UNESCAPED_SLASHES);
  }
}