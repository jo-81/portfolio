<?php

namespace App\Tests\Entity;

use App\Entity\Competence;

final class CompetenceTest extends Entity
{
    public function getCompetence(): Competence
    {
        return (new Competence())
            ->setName('une compétence')
            ->setSlug('une-competence')
            ->setPublished(true)
            ->setColor('#000')
        ;
    }

    public function testBadName(): void
    {
        $competence = $this->getCompetence();
        $competence->setName('');
        $this->assertHasErrors($competence, 1);
    }

    public function testUniqueName(): void
    {
        $competence = $this->getCompetence();
        $competence->setName('PHP');
        $this->assertHasErrors($competence, 1);
    }

    public function testBadSlug(): void
    {
        $competence = $this->getCompetence();
        $competence->setSlug('');
        $this->assertHasErrors($competence, 1);
    }

    public function testUniqueSlug(): void
    {
        $competence = $this->getCompetence();
        $competence->setSlug('php');
        $this->assertHasErrors($competence, 1);
    }

    public function testBadColor(): void
    {
        $competence = $this->getCompetence();
        $competence->setColor('PHP');
        $this->assertHasErrors($competence, 1);
    }

    public function testGoodEntity(): void
    {
        $this->assertHasErrors($this->getCompetence(), 0);
    }
}
