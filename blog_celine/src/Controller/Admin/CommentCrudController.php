<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('article')->setLabel('Sur l\'article'),
            TextareaField::new('content')->setLabel('Contenu'),
            AssociationField::new('writeby')->setLabel('Ecrit par'),
            BooleanField::new('rgpd')->setLabel('J\'accepte que mes informations soient stockées dans la base de données de Blog_celine pour la gestion des commentaires. J\'ai bien noté qu\'en aucun cas ces données ne seront cédées à des tiers.'),
            IntegerField::new('status')->setLabel('Le statut : 1=approuvé, 2=en attente, 3=non approuvé')
        ];
    }
    
}
