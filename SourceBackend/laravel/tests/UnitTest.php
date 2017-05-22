<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UnitTest extends TestCase
{

    public function testPagination(){
       $response = $this->call('GET', '/pagination');
    	$contenido = json_decode($response->getContent());
        if ($contenido){
    	   $this->assertGreaterThan(0, $contenido->pageAmount, 'La cantidad de paginas no es congruente');
        }
    }

    public function testValidSearchPostByName(){
        $response = $this->call('POST', '/search-name?name=maria')->getContent();
        $response = json_decode($response);
        $status = $response->status;
        $this->assertEquals($status, 'success');
        $this->assertGreaterThanOrEqual(0, sizeof($response->data));
        //$this->assertJsonStringEqualsJsonString($response, json_encode(['status' => 'success', 'data' =>]));
    }

    public function testInvalidSearchPostByName(){
        $response = $this->call('POST', '/search-name?nae=maria')->getContent();
        $response = json_decode($response);
        $status = $response->status;
        $this->assertEquals($status, 'error');
        //$this->assertJsonStringEqualsJsonString($response, json_encode(['status' => 'success', 'data' =>]));
    }

    public function testValidDateRangeSearch(){
        $startRange = '2016/12/12';
        $endRange = '2017/03/12';
        $response = $this->call('GET', '/date-range', ['startRange' => $startRange, 'endRange' => $endRange])->getContent();
        $response = json_decode($response);
        $this->assertEquals($response->status, 'success');
        $this->assertGreaterThanOrEqual(0, sizeof($response->data));
    }

    public function testInvalidDateRangeSearch(){
        $startRange = '2017/12/12';
        $endRange = '2017/03/12';
        $response = $this->call('GET', '/date-range', ['startRange' => $startRange, 'endRange' => $endRange])->getContent();
        $response = json_decode($response);
        $this->assertEquals($response->status, 'error');

        $startRange = '2017/12';
        $endRange = '2017/03/12';
        $response = $this->call('GET', '/date-range', ['startRange' => $startRange, 'endRange' => $endRange])->getContent();
        $response = json_decode($response);
        $this->assertEquals($response->status, 'error');
    }

    public function testAddPost(){
        $name = 'Prueba';
        $contact = 'facabook';
        $img = 'no tiene';
        $date = '2017/12/01';
        $response = $this->call('POST', '/add-post', ['name' => $name,
                                                    'contact' => $contact,
                                                    'img' => $img,
                                                    'date' => $date]
                                )->getContent();
        $response = json_decode($response);
        $this->assertEquals($response->status, 'error');
    }

}
