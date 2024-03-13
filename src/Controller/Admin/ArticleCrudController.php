<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class ArticleCrudController extends PostCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fieldsParent = parent::configureFields($pageName);
        $datas = [
            TextEditorField::new('chapo', 'Contenue')->hideOnIndex(),
        ];

        return array_merge($fieldsParent, $datas); /* @phpstan-ignore-line */
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('articles')

            ->setPageTitle('detail', 'Article : %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier %entity_label_singular%')
            ->setPageTitle('new', 'Ajouter un %entity_label_singular%')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')

            ->setEntityLabelInSingular(
                fn (?Article $project) => $project ? $project->__toString() : 'article'
            )

            ->setPaginatorPageSize(15)
            ->setDefaultSort(['id' => 'ASC'])
        ;
    }
}
