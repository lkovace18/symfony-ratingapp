<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Uri;
use Carbon\Carbon;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUriData extends AbstractFixture implements OrderedFixtureInterface {
	public function load(ObjectManager $manager) {
		$firstUri = new Uri();
		$firstUri->setUri('example.com/index');
		$firstUri->setSumUsers(2);
		$firstUri->setSumRating(5.50);
		$firstUri->setCreatedAt(Carbon::now()->subDays(3));
		$firstUri->setUpdatedAt(Carbon::now()->subDays(3));
		$manager->persist($firstUri);
		$this->addReference('first-uri', $firstUri);

		$secondUri = new Uri();
		$secondUri->setUri('example.com/article/second-cool-article');
		$secondUri->setSumUsers(3);
		$secondUri->setSumRating(5.66);
		$secondUri->setCreatedAt(Carbon::now()->subDays(2));
		$secondUri->setUpdatedAt(Carbon::now()->subDays(2));
		$manager->persist($secondUri);
		$this->addReference('second-uri', $secondUri);

		$thirdUri = new Uri();
		$thirdUri->setUri('example.com/article/third-cool-article');
		$thirdUri->setSumUsers(1);
		$thirdUri->setSumRating(4);
		$thirdUri->setCreatedAt(Carbon::now()->subHours(3));
		$thirdUri->setUpdatedAt(Carbon::now()->subHours(3));
		$manager->persist($thirdUri);
		$this->addReference('third-uri', $thirdUri);

		$manager->flush();
	}

	public function getOrder() {
		return 1;
	}
}
