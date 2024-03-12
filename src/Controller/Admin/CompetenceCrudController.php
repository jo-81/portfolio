<?php

namespace App\Controller\Admin;

use App\Entity\Competence;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CompetenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Competence::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            SlugField::new('slug')->setTargetFieldName('name')->hideOnForm(),
            BooleanField::new('published', 'Publié ?')->hideOnForm(),
            ColorField::new('color', 'Couleur'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('compétences')

            ->setPageTitle('detail', 'Compétence : %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier %entity_label_singular%')
            ->setPageTitle('new', 'Ajouter une %entity_label_singular%')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')

            ->setEntityLabelInSingular(
                fn (?Competence $competence) => $competence ? $competence->__toString() : 'compétence'
            )

            ->setPaginatorPageSize(15)
            ->setDefaultSort(['id' => 'ASC'])
        ;
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
            ->add('name')
            ->add('published')
        ;
    }
}
