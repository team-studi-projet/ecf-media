<?php

namespace App\Test\Controller;

use App\Entity\Pret;
use App\Repository\PretRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PretControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PretRepository $repository;
    private string $path = '/pret/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Pret::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Pret index');

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
            'pret[reservDate]' => 'Testing',
            'pret[employedDate]' => 'Testing',
            'pret[returnDate]' => 'Testing',
            'pret[user]' => 'Testing',
            'pret[book]' => 'Testing',
        ]);

        self::assertResponseRedirects('/pret/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Pret();
        $fixture->setReservDate('My Title');
        $fixture->setEmployedDate('My Title');
        $fixture->setReturnDate('My Title');
        $fixture->setUser('My Title');
        $fixture->setBook('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Pret');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Pret();
        $fixture->setReservDate('My Title');
        $fixture->setEmployedDate('My Title');
        $fixture->setReturnDate('My Title');
        $fixture->setUser('My Title');
        $fixture->setBook('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'pret[reservDate]' => 'Something New',
            'pret[employedDate]' => 'Something New',
            'pret[returnDate]' => 'Something New',
            'pret[user]' => 'Something New',
            'pret[book]' => 'Something New',
        ]);

        self::assertResponseRedirects('/pret/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getReservDate());
        self::assertSame('Something New', $fixture[0]->getEmployedDate());
        self::assertSame('Something New', $fixture[0]->getReturnDate());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getBook());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Pret();
        $fixture->setReservDate('My Title');
        $fixture->setEmployedDate('My Title');
        $fixture->setReturnDate('My Title');
        $fixture->setUser('My Title');
        $fixture->setBook('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/pret/');
    }
}
