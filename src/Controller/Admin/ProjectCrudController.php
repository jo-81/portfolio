<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            SlugField::new('slug')->setTargetFieldName('title'),
            DateField::new('createdAt', 'Publié le'),
            DateField::new('editedAt', 'Modifié le')->hideOnIndex(),
            UrlField::new('github', 'Github')->hideOnIndex(),
            UrlField::new('link', 'Website')->hideOnIndex(),
            TextEditorField::new('content', 'Contenue')->hideOnIndex(),

            CollectionField::new('competences')->onlyOnDetail()->setTemplatePath('admin/fields/competences.html.twig'),

            BooleanField::new('published', 'Publié ?'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add('published')
            ->add('createdAt')
            ->add('competences')
        ;
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
            ->setDefaultSort(['id' => 'ASC'])
        ;
    }
}
