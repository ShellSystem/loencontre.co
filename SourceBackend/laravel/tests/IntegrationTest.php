<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IntegrationTest extends TestCase
{
    
	public function testGetPage(){
        $minRandom = -10;
        $maxRandom = 100;
        $testAcount = 10;

        $response = $this->call('GET', 'pagination');
        if($response->getContent()->pageAmount){
            $pageAmount = json_decode($response); 
        
        $negativeTest = $this->call('GET', '/get-page', ['pageNumber' => ($pageAmount * -1)])->getContent();
        $this->assertJsonStringEqualsJsonString($negativeTest, json_encode(['error' => 'Pagina fuera de rango']));
        }


        $overflowTest = $this->call('GET', '/get-page', ['pageNumber' => ($pageAmount + 1)])->getContent();
        $this->assertJsonStringEqualsJsonString($overflowTest, json_encode(['error' => 'Pagina fuera de rango']));

        $nullTest = $this->call('GET', '/get-page', ['pageNumber' => 0])->getContent();
        $this->assertJsonStringEqualsJsonString($nullTest, json_encode(['error' => 'No se ha encontrado un parámetro correcto']) , "No coniciden la respuesta esperada y la obtenida");
    }
    
}
