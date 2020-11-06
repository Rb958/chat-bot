<?php


namespace App\Admin\parameters;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class SupportContextAdmin extends AbstractAdmin
{

    protected function configureListFields(ListMapper $list)
    {
        $list->add('id')
            ->add('name')
            ->add('dateSave')
            ->add('Actions', 'actions',[
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => []
                ]
            ]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name');
    }

}