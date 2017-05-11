<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LandingControllerTest extends WebTestCase
{
    public function testShowindex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

}
