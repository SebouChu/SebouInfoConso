<?php

namespace App\Services;

use App\Product;
use GuzzleHttp\Client;

class ProductFinderService
{

  public function search(string $barcode) {
    $product = Product::where('barcode', $barcode)->first();

    if ($product !== null) {
      return $product;
    }

    $client = new Client([
      'base_uri' => 'https://fr.openfoodfacts.org/api/v0/produit/',
      'timeout'  => 5.0
    ]);
    $response = $client->request('GET', $barcode);
    $data = json_decode($response->getBody(), true);

    if ($data['status'] === 0) {
      return null;
    }

    $product = $this->import($barcode, $data);

    return $product;
  }

  private function import(string $barcode, array $data) {
    $name = $data['product']['product_name'];
    $image = $data['product']['image_url'];

    if (isset($data['product']['nutriments']['energy_value'])) {
      $energyUnit = $data['product']['nutriments']['energy_unit'];
      $energy = intval($data['product']['nutriments']['energy_value']);
      if ($energyUnit === 'kJ') {
        $energy = round($energy / 4.184);
      }
    } else {
      $energy = 0;
    }

    $product = new Product();
    $product->name = $name;
    $product->image = $image;
    $product->barcode = $barcode;
    $product->energy = $energy;
    $product->save();

    return $product;
  }

}