<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    protected $token ;
    
    public function setUp():void
    {
        parent::setUp();
        // Create your database records
        $headers = ['Accept'=> 'application/json'];
        $data = ['email' => 'test@test.com', '123456'];
        $response = $this->json('POST', '/api/login', $data, $headers);
        //dd($response->getContent());
    }

    /**
     * A basic test example.
     * @dataProvider productDataProvider
     * @return void
     */
    public function testStore($data, $expected)
    {
        $headers = ['Accept'=> 'application/json', 'Authorisation'=> 'Bearer '.$this->token];
        $response = $this->json('POST', '/api/products', $data, $headers);
        $response->assertStatus($expected);
    }

    public function productDataProvider()
    {
        $product1 = [
            'code' => 'P0001',
            'Name' => 'Product 001',
            'description' => 'This is Product 1'
        ];
        $product2 = [
            'code' => '',
            'Name' => 'Product 002',
            'description' => 'This is Product 2'
        ];
        $product3 = [
            'code' => 'P0003',
            'Name' => '',
            'description' => 'This is Product 3'
        ];
        return [
            [$product1, 200],
            [$product2, 422],
            [$product3, 200]
        ];
    }
}
