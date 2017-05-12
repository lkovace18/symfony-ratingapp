<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class LandingControllerTest extends WebTestCase
{
    /** @test */
    public function it_displays_langing_page_correctly()
    {
        $client = $this->makeClient();

        $client->request('GET', '/');
        $this->assertStatusCode(200, $client);

        $this->assertContains(
            'RateMe App',
            $client->getResponse()->getContent()
        );
    }

    /** @test */
    public function it_displays_js_widget()
    {
        $client = $this->makeClient();

        $client->request('GET', '/');
        $this->assertStatusCode(200, $client);

        $this->assertContains(
            'Try it, rate me ;)',
            $client->getResponse()->getContent()
        );
    }

    /** @test */
    public function it_displays_api_documentation_when_clicked_on_link()
    {
        $client = $this->makeClient();

        $crawler = $client->request('GET', '/');
        $this->assertStatusCode(200, $client);
        $link = $crawler->selectLink('API Documentation')->link();

        $client->request('GET', $link->getUri());

        $this->assertContains(
            'API documentation',
            $client->getResponse()->getContent()
        );
    }
}
