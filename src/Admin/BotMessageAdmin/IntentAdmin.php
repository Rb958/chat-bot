<?php


namespace App\Admin\BotMessageAdmin;


use App\Entity\Intent;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IntentAdmin extends AbstractAdmin
{

    protected function configureListFields(ListMapper $list)
    {
        $list->add('id');
        $list->add("label")
            ->add('Messages',null,['associated_property' => 'getUtterance'])
        ->add("Actions",'actions',array(
            'actions' => [
                'show' => [],
                'edit' => [],
                'delete' => []
            ]
        ));
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show->tab("Messages")
            ->add('label')
            ->end();
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('label',TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('id')
            ->add("label");
    }

    
    


    public function toString($object)
    {
        return $object instanceof Intent ?
            $object->getLabel() :
            "Intent";
    }

}