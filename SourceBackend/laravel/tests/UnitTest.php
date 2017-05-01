<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UnitTest extends TestCase
{
    
    public function testPagination()
    {
       $response = $this->call('GET', '/pagination');
    	$contenido = json_decode($response->getContent());
            if ($contenido){

        	   $this->assertGreaterThan(0, $contenido->pageAmount, 'La canidad de paginas no es congruente');
            }
        }

    public function testAddPost(){

        $response = $this->call('GET', '/prueba')->getContent();
        $this->assertJsonStringEqualsJsonString($response, json_encode(['sisas']));

    	/*$alreadyExist = $this->call('POST', '/add-post', ['post' => 'link:1423565230987886,image:06,date:2017/01/16'])->getContent();
    	

    	$specialChar = $this->call('POST', '/add-post', ['post' => 'link:1423565230´)(987886,image:0*"6,date:2017/01/16'])->getContent();
    	
    	$this->assertJsonStringEqualsJsonString($specialChar, json_encode(['No se acepta el uso de caracteres especiales','No se acepta el uso de caracteres especiales']));

    	$invalidDate = $this->call('POST', '/add-post', ['post' => 'link:1423565230987886,image:06,date:2017/02/30'])->getContent();
    	
    	$this->assertJsonStringEqualsJsonString($invalidDate, json_encode(['La fecha debe ser una fecha valida']));

    	$empyField = $this->call('POST', '/add-post', ['post' => 'link:,image:,date:2017/03/30'])->getContent();
    	
    	$this->assertJsonStringEqualsJsonString($empyField, json_encode(['El campo link no puede estar vacio', 'El campo image no puede estar vacio']));*/
    }

}
