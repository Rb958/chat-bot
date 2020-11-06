<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Flow;
use App\Entity\Block;
use App\Entity\Content;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class BlockAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('type')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('title')
            ->add('type')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('title')
            ->add('type',ChoiceType::class,[
                "choices" => [
                    "Question" => "Question",
                    "Response" => "Response"
                ]
            ])
            ->add('flow',ModelType::class,[
                'class'=>Flow::class,
                'multiple' => false,
                'btn_add' => 'New flow',
                'placeholder' => 'Select a flow'
            ])
            ->add('previousBlock',ModelType::class,[
                'class'       => Block::class,
                'multiple'    => false,
                'required'    => false,
                'placeholder' => "Select the previous Block"
            ])
            ->add('content', ModelType::class,[
                'class' => Content::class,
                'multiple' => false,
                'btn_add' => 'New content',
                'placeholder' => 'Select some contents'
            ])
            ->add('isStarter')
            ;
    }

    public function prePersist($object)
    {
    
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('type')
            ->add('flow')
            ->add('previousBlock')
            ->add('content')
            ->add('nextBlock')
            ->add('isStarter')
            ;
    }
}
