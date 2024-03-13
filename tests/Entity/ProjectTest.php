<?php

namespace App\Tests\Entity;

use App\Entity\Project;

final class ProjectTest extends Entity
{
    public function getProject(): Project
    {
        return (new Project())
            ->setTitle('un nouveau projet')
            ->setContent('Le contenue du nouveau projet')
            ->setLink('https://127.0.0.1:8000/')
            ->setGithub('https://127.0.0.1:8000/')
        ;
    }

    /**
     * Title.
     */
    public function testBadTitle(): void
    {
        $project = $this->getProject();
        $project->setTitle('');
        $this->assertHasErrors($project, 1);

        $project->setTitle('uio');
        $this->assertHasErrors($project, 1);

        $project->setTitle('Le titre du projet');
        $this->assertHasErrors($project, 1);
    }

    /**
     * Content.
     */
    public function testBadContent(): void
    {
        $project = $this->getProject();
        $project->setContent('');
        $this->assertHasErrors($project, 1);
    }

    /**
     * Link.
     */
    public function testBadLink(): void
    {
        $project = $this->getProject();
        $project->setLink('ohrnfvoiemh');
        $this->assertHasErrors($project, 1);
    }

    /**
     * Github.
     */
    public function testBadGithub(): void
    {
        $project = $this->getProject();
        $project->setGithub('ohrnfvoiemh');
        $this->assertHasErrors($project, 1);
    }

    public function testGoodProject(): void
    {
        $this->assertHasErrors($this->getProject(), 0);
    }
}
