<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Booking::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('booking_id'),
            DateTimeField::new('start_time'),
            DateTimeField::new('end_time'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('email'),
            TextField::new('phone'),
        ];
    }
    
}
