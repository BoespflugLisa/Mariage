<?php

namespace App\Controller\Admin;

use App\Entity\DonationPromise;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DonationPromiseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DonationPromise::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInSingular('Promesse de don')
        ->setEntityLabelInPlural('Promesses de dons')
        ->setPageTitle('index', '%entity_label_plural% listing');
        //->setEntityPermission('ROLE_SUPERADMIN');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            BooleanField::new('view'),
            TextField::new('name'),
            EmailField::new('email'),
            Field::new('donationAmount'),
            TextareaField::new('message'),
            AssociationField::new('present'),
        ];
    }
    


}
