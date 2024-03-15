<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\PictureField;
use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom de l\'image'),
            TextField::new('alt', 'Texte alternatif'),
            AssociationField::new('post'),
            PictureField::new('imageFile', 'Image')->onlyOnDetail(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Liste des images')
            ->setPageTitle('detail', '%entity_label_singular%')
            ->setEntityLabelInSingular(
                fn (?Image $image) => $image ? 'Image #'.$image->getId() : 'Image'
            )
            ->setPaginatorPageSize(15)
            ->setDefaultSort(['id' => 'DESC'])
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::NEW, Action::DELETE, Action::EDIT)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('post')
        ;
    }
}
