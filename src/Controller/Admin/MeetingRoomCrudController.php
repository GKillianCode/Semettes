<?php

namespace App\Controller\Admin;

use App\Entity\MeetingRoom;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MeetingRoomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MeetingRoom::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('room_name'),
            TextareaField::new('room_description'),
            TextField::new('room_image_name'),
            NumberField::new('max_person'),
            NumberField::new('rate'),
        ];
    }
}
