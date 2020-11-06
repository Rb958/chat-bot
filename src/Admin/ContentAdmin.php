<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Block;
use App\Entity\Button;
use App\Entity\Media;
use App\Entity\SonataMediaMedia;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\MediaBundle\Form\Type\MediaType;

final class ContentAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('text')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('text')
            ->add('_action', null, [
                'actions' => [
                    'show'     => [],
                    'edit'     => [],
                    'delete'   => []
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('text')
            ->add('block',ModelType::class, [
                'class' => Block::class,
                'placeholder' => 'Select the block',
                'required' => false,
                'multiple' => false,
                'btn_add' => "New Block"
            ])
            ->add('attachment',ModelType::class,[
                'class' => SonataMediaMedia::class,
                'placeholder' => 'Select some attachments',
                'required' => false,
                'multiple' => true,
                'btn_add' => "New Attachment"
            ])
            ->add('buttons', ModelType::class, [
                'class' => Button::class,
                'placeholder' => 'Select some buttons',
                'required' => false,
                'multiple' => true,
                'btn_add' => "New Button"
            ])
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('text')
            ->add('buttons')
            ;
    }
}
