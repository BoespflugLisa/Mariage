<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class PictureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Picture::class;
    }

    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInSingular('Image')
        ->setEntityLabelInPlural('Images')
        ->setPageTitle('index', '%entity_label_plural% listing');
        //->setEntityPermission('ROLE_SUPERADMIN');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            Field::new('img'),
            TextField::new('publisher'),
            BooleanField::new('visibility'),
            AssociationField::new('tags'),
            //TextEditorField::new('description'),
        ];
    }

    
}
