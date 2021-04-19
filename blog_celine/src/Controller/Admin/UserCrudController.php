<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /* configurer les champs modifiable ou non */
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('lastname')->setLabel('Nom'),
            TextField::new('firstname')->setLabel('Prénom'),
            TextField::new('username')->setLabel('Nom d\'utilisateur'),
            TextField::new('password')->setLabel('Mot de passe'),
            EmailField::new('email')->setLabel('Adresse email'),
        ];
    }
    
    /* Pour charger par défaut le tri des articles selon leur date de création */
    public function configureCrud(Crud $crud): Crud 
    {
        return $crud->setDefaultSort(['username' => 'DESC']);
    }
}
