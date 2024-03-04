<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class PieceRequiseAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('namen', null, ['label'=>'name'])
            ->add('signataireng', null, ['label' => 'signed|certified by'])
            ->add('obligatory', null, ['label'=>'Is the file obligatory?'])
            ->add('date_created', null, ['label' => 'created on'])
            ->add('date_updated', null, ['label' => 'modified on'])
            ->add('user_created', null, [
                'label' => 'created by',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => User::class,
                    'choice_label' =>
                    'username',
                ],
            ])
            ->add('user_updated', null, [
                'label' => 'modified by',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => User::class,
                    'choice_label' => 'username',
                ],
            ])
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('namen', null, ['label' => 'name'])
            ->add('signataireng', null, ['label' => 'signed|certified by'])
            ->add('obligatory', null, ['label'=>'Is Obligatory', 'editable' => true])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name', null, ['label' => 'nom'])
            ->add('namen', null, ['label' => 'name (english version)'])
            ->add('signataire', null, ['label' => 'signataire'])
            ->add('signataireng', null, ['label' => 'signed|certified by (english version)'])
            ->add('obligatory', null, ['label'=>'Is Obligatory'])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('name', null, ['label' => 'nom'])
            ->add('namen', null, ['label' => 'name (english version)'])
            ->add('signataire', null, ['label' => 'signataire'])
            ->add('signataireng', null, ['label' => 'signed|certified by (english version)'])
            ->add('date_created', null, ['label' => 'created on'])
            ->add('date_updated', null, ['label' => 'modified on'])
            ->add('user_created.username', null, ['label' => 'created by'])
            ->add('user_updated.username', null, ['label' => 'modified by'])
        ;
    }
}
