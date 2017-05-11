<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\UriRating;
use Carbon\Carbon;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUriRatingData extends AbstractFixture implements OrderedFixtureInterface {
	public function load(ObjectManager $manager) {
		$firstUriRating = new UriRating();
		$firstUriRating->setUri($this->getReference('first-uri'));
		$firstUriRating->setVisitorId('f10e2');
		$firstUriRating->setRating(7);
		$firstUriRating->setCreatedAt(Carbon::now()->subDays(3));
		$firstUriRating->setUpdatedAt(Carbon::now()->subDays(3));
		$manager->persist($firstUriRating);
		$this->addReference('first-uri-rating', $firstUriRating);

		$secondUriRating = new UriRating();
		$secondUriRating->setUri($this->getReference('first-uri'));
		$secondUriRating->setVisitorId('821bd');
		$secondUriRating->setRating(4);
		$secondUriRating->setCreatedAt(Carbon::now()->subDays(1));
		$secondUriRating->setUpdatedAt(Carbon::now()->subDays(1));
		$manager->persist($secondUriRating);
		$this->addReference('second-uri-rating', $secondUriRating);

		$thirdUriRating = new UriRating();
		$thirdUriRating->setUri($this->getReference('second-uri'));
		$thirdUriRating->setVisitorId('a527e');
		$thirdUriRating->setRating(3);
		$thirdUriRating->setCreatedAt(Carbon::now()->subDays(2));
		$thirdUriRating->setUpdatedAt(Carbon::now()->subDays(2));
		$manager->persist($thirdUriRating);
		$this->addReference('third-uri-rating', $thirdUriRating);

		$fourthUriRating = new UriRating();
		$fourthUriRating->setUri($this->getReference('second-uri'));
		$fourthUriRating->setVisitorId('2200s');
		$fourthUriRating->setRating(9);
		$fourthUriRating->setCreatedAt(Carbon::now()->subHours(16));
		$fourthUriRating->setUpdatedAt(Carbon::now()->subHours(16));
		$manager->persist($fourthUriRating);
		$this->addReference('fourth-uri-rating', $fourthUriRating);

		$fifthUriRating = new UriRating();
		$fifthUriRating->setUri($this->getReference('second-uri'));
		$fifthUriRating->setVisitorId('2313b');
		$fifthUriRating->setRating(5);
		$fifthUriRating->setCreatedAt(Carbon::now()->subHours(2));
		$fifthUriRating->setUpdatedAt(Carbon::now()->subHours(2));
		$manager->persist($fifthUriRating);
		$this->addReference('fifth-uri-rating', $fifthUriRating);

		$sixthUriRating = new UriRating();
		$sixthUriRating->setUri($this->getReference('third-uri'));
		$sixthUriRating->setVisitorId('c0594');
		$sixthUriRating->setRating(4);
		$sixthUriRating->setCreatedAt(Carbon::now()->subHours(3));
		$sixthUriRating->setUpdatedAt(Carbon::now()->subHours(3));
		$manager->persist($sixthUriRating);
		$this->addReference('sixth-uri-rating', $sixthUriRating);

		$manager->flush();
	}

	public function getOrder() {
		return 1;
	}
}
