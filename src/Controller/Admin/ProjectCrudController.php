<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ProjectCrudController extends PostCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fieldsParent = parent::configureFields($pageName);

        $datas = [
            SlugField::new('slug')->setTargetFieldName('title')->hideOnForm(),
            UrlField::new('github', 'Github')->hideOnIndex(),
            UrlField::new('link', 'Website')->hideOnIndex(),
            TextEditorField::new('content', 'Contenue')->hideOnIndex(),
            ArrayField::new('images')->onlyOnDetail(),
        ];

        return array_merge($fieldsParent, $datas); /* @phpstan-ignore-line */
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('projets')

            ->setPageTitle('detail', 'Projet : %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier %entity_label_singular%')
            ->setPageTitle('new', 'Ajouter un %entity_label_singular%')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')

            ->setEntityLabelInSingular(
                fn (?Project $project) => $project ? $project->__toString() : 'projet'
            )

            ->setPaginatorPageSize(15)
            ->setDefaultSort(['id' => 'DESC'])
        ;
    }
}
