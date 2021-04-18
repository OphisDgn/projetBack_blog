<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    /* pour configurer les informations affichées et modifiables */
    public function configureFields(string $pageName): iterable
    {
        return [
            //TextField::new('author')->hideOnForm(),
            TextField::new('title'),
            TextareaField::new('content'),
            DateField::new('postDate')->hideOnForm()
        ];
    }
    
    /* Pour charger par défaut le tri des articles selon leur date de création */
    public function configureCrud(Crud $crud): Crud 
    {
        return $crud->setDefaultSort(['postDate' => 'DESC']);
    }

}
