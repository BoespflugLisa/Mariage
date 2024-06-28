<?php

namespace App\Controller\Admin;

use App\Entity\Present;
use App\Repository\PresentRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class PresentCrudController extends AbstractCrudController
{

    public function __construct(
        public PresentRepository $presentRepository
    ) {
        $this->presentRepository = $presentRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Present::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Present')
            ->setEntityLabelInPlural('Presents')
            ->setPageTitle('index', '%entity_label_plural% listing');
        //->setEntityPermission('ROLE_SUPERADMIN');
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            ImageField::new('img')
                ->setLabel('Photo')
                ->setUploadDir("/public/img/presents")
                ->setBasePath('/img/presents'),
            UrlField::new('link'),
            Field::new('price'),
            ChoiceField::new('parentId')->setChoices([$this->getAllPresents()]),
            AssociationField::new('presentCategory')->setCrudController(PresentCategoryCrudController::class)

        ];
    }

    private function getAllPresents(): array
    {
        $allPresentsEntity = $this->presentRepository->findAll();
        $presentsName = array();
        foreach ($allPresentsEntity as $present) {
            $presentsName[$present->getId()] = $present->getName();
        }
        return array_flip($presentsName);
    }
}
