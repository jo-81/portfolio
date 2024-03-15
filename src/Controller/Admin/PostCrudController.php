<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\ImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            DateField::new('createdAt', 'Publié le')->hideOnForm(),
            DateField::new('editedAt', 'Modifié le')->hideOnIndex()->hideOnForm(),
            UrlField::new('link', 'Website')->hideOnIndex(),
            CollectionField::new('competences', 'Compétences')->onlyOnDetail()->setTemplatePath('admin/fields/competences.html.twig'),
            AssociationField::new('competences', 'Compétences')->onlyOnForms(),
            BooleanField::new('published', 'Publié ?')->hideOnForm(),

            CollectionField::new('images')
                ->setEntryType(ImageType::class)
                ->setFormTypeOptions([
                    'error_bubbling' => false,
                    'by_reference' => false,
                ])
                ->setColumns('col-12 col-sm-6')
                ->renderExpanded()
                ->setEntryIsComplex()
                ->onlyOnForms(),
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
}
