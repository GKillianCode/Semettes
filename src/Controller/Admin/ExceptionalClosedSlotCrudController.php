<?php

namespace App\Controller\Admin;

use App\Entity\ExceptionalClosedSlot;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExceptionalClosedSlotCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExceptionalClosedSlot::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('closedDate'),
            TimeField::new('startHour'),
            TimeField::new('endHour'),
        ];
    }
    
}
