<?php


namespace App\Admin\parameters;


use App\Entity\SpeakerEmail;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SpeakerEmailAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('speakerName',TextType::class)
            ->add('email', EmailType::class)
            ->add('context', CollectionType::class,[
                'type_options' => [
                    'delete' => false,
                    'delete_options' => [
                        'type'         => HiddenType::class,
                        'type_options' => [
                            'mapped'   => true,
                            'required' => true,
                        ]
                    ]
                ]
            ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ]);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->add('id')
            ->add('speakerName')
            ->add('context')
            ->add('email')
            ->add('dateSave');
    }

    public function __toString()
    {
        return $object instanceof SpeakerEmail ?
            $object->getSpeakerName() :
            "Speakers";
    }
}