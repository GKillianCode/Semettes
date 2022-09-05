<?php

namespace App\Controller\Admin;

use App\Entity\WeekSlot;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class WeekSlotCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WeekSlot::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TimeField::new('start_time'),
            TimeField::new('end_time'),
            NumberField::new('week_day'),
            BooleanField::new('is_opened'),
        ];
    }
    
}
