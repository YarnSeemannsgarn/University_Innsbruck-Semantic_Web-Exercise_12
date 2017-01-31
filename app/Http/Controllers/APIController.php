<?php

namespace App\Http\Controllers;

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

  }
}