<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Service;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class TypeDossierAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('subject', null, ['label' => 'objet (french version)'])
            ->add('subjecten', null, ['label' => 'subject'])
            ->add('service', null, [
                'label' => 'service',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Service::class,
                    'choice_label' =>
                    'structure.name',
                ],
            ])
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
            ->add('subjecten', null, ['label' => 'subject'])
            ->add('descriptionen', null, ['label' => 'description'])
            ->add('service', null, ['label' => 'service'])
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
        $form->tab('details')
            ->with('subject & description', ['class' => 'col-md-12'])
                ->add('subjecten', null, ['label' => 'subject'])
                ->add('descriptionen', null, ['label' => 'description'])
            ->end()
            ->with('subject & description (french version)', ['class' => 'col-md-12'])
                ->add('subject', null, ['label' => 'objet'])
                ->add('description', null, ['label' => 'description'])
            ->end()
            ->with('service in charge', ['class' => 'col-md-12'])
                ->add('service', null, ['label' => 'service'])
            ->end();
            if ($this->isCurrentRoute('edit')) {
                $form->with('list of required documents', ['class' => 'col-md-12'])
                    ->add('typeDossierPieces', CollectionType::class, [
                        'type_options' => [
                            'delete' => true,
                            'delete_options' => [
                                'type'         => CheckboxType::class,
                                'type_options' => [
                                    'mapped'   => false,
                                    'required' => false,
                                ]
                            ]
                        ]
                    ], [
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ])
                ->end();
            }
            $form->end()
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show  
            ->tab('details')
            ->with('subject & description', ['class' => 'col-md-12'])
                ->add('id')
                ->add('subjecten', null, ['label' => 'subject'])
                ->add('descriptionen', null, ['label' => 'description'])
            ->end()
            ->with('subject & description (french version)', ['class' => 'col-md-12'])
                ->add('subject', null, ['label' => 'objet'])
                ->add('description', null, ['label' => 'description'])
            ->end()
            ->with('service in charge', ['class' => 'col-md-12'])
                ->add('service', null, ['label' => 'service'])
            ->end()
            ->with('administration', ['class' => 'col-md-6'])
                ->add('date_created', null, ['label' => 'created on'])
                ->add('date_updated', null, ['label' => 'modified on'])
                ->add('user_created.username', null, ['label' => 'created by'])
                ->add('user_updated.username', null, ['label' => 'modified by'])
            ->end()
            ->end()
        ;
    }
}
