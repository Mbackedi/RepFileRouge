<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Test1Test extends WebTestCase
{
    public function testTest1()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'Kabirou',
            'PHP_AUTH_PW' => '123456',
        ]);
        $crawler = $client->request('GET', '/api/partenaire',[],[],
        ['CONTENT_TYPE' =>"application/json"],
          '{
                "id": "1",
                "nom_entreprise": "SEN TRANSFERT",
                "rs": "DIOP SA",
                "ninea": "TH0088JT",
                "adresse": "DAKAR",
                "statut" : "debloquer"
            }'
            
    );
    $test=$client->getResponse();
    var_dump($test);

    $this->assertSame(201,$test->getStatusCode());
       
    }
}
