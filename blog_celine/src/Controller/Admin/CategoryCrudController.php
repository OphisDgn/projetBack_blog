<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    /* configurer les champs qui sont modifiable dans le form ou juste visible dans la liste */
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
        ];
    }

    /* Pour charger par défaut le tri des articles selon le nom de la catégorie */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['name' => 'DESC']);
    }
}
