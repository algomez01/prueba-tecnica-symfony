<?php

namespace App\Test\Controller;

use App\Entity\Capacitaciones;
use App\Repository\CapacitacionesRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CapacitacionesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CapacitacionesRepository $repository;
    private string $path = '/capacitaciones/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Capacitaciones::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Capacitacione index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'capacitacione[titulo]' => 'Testing',
            'capacitacione[descripcion]' => 'Testing',
            'capacitacione[estado]' => 'Testing',
            'capacitacione[user_id]' => 'Testing',
        ]);

        self::assertResponseRedirects('/capacitaciones/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Capacitaciones();
        $fixture->setTitulo('My Title');
        $fixture->setDescripcion('My Title');
        $fixture->setEstado('My Title');
        $fixture->setUser_id('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Capacitacione');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Capacitaciones();
        $fixture->setTitulo('My Title');
        $fixture->setDescripcion('My Title');
        $fixture->setEstado('My Title');
        $fixture->setUser_id('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'capacitacione[titulo]' => 'Something New',
            'capacitacione[descripcion]' => 'Something New',
            'capacitacione[estado]' => 'Something New',
            'capacitacione[user_id]' => 'Something New',
        ]);

        self::assertResponseRedirects('/capacitaciones/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitulo());
        self::assertSame('Something New', $fixture[0]->getDescripcion());
        self::assertSame('Something New', $fixture[0]->getEstado());
        self::assertSame('Something New', $fixture[0]->getUser_id());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Capacitaciones();
        $fixture->setTitulo('My Title');
        $fixture->setDescripcion('My Title');
        $fixture->setEstado('My Title');
        $fixture->setUser_id('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/capacitaciones/');
    }
}
