<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_DETAIL, Action::INDEX)
            ->disable(Action::NEW, Action::DELETE)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username', 'Pseudo')->hideOnForm(),
            EmailField::new('email', 'Email'),
            TextField::new('plainPassword', 'Modifier votre mot de passe')
                ->onlyWhenUpdating()
                ->setFormType(PasswordType::class),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('profil')
            ->setEntityLabelInPlural('utilisateurs')
            ->setPageTitle('detail', 'Mon %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier mon %entity_label_singular%')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
        ;
    }
}
