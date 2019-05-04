<?php


namespace Tests\AppBundle\Service;


use AppBundle\Entity\Dinosaur;
use AppBundle\Entity\Enclosure;
use AppBundle\Factory\DinosaurFactory;
use AppBundle\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class EnclosureBuilderServiceProphecyTest extends TestCase
{
    public function testItBuildsAndPersistsEnclosure()
    {
        $em = $this->prophesize(EntityManagerInterface::class);
        $dinoFactory = $this->prophesize(DinosaurFactory::class);

        $em->persist(Argument::type(Enclosure::class))->shouldBeCalledOnce();
        $em->flush()->shouldBeCalled();

        $dinoFactory->growFromSpecification(Argument::type('string'))
            ->shouldBeCalledTimes(2)
            ->willReturn(new Dinosaur())
        ;

        $builder = new EnclosureBuilderService(
            $em->reveal(),
            $dinoFactory->reveal()
        );
        $enclosure = $builder->buildEnclosure(1, 2);

        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(2, $enclosure->getDinosaurs());

        dump($enclosure->getDinosaurs()->toArray());
    }
}