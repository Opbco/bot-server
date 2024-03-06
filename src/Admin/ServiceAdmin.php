<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Service;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class ServiceAdmin extends AbstractAdmin
{
    public function toString(object $object): string
    {
        return $object instanceof Service
            ? $object->__toString()
            : 'Service'; // shown in the breadcrumb on the create view
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('code', null, ['label'=>'code'])
            ->add('porte', null, ['label'=>'door'])
            ->add('structure', ModelFilter::class, [
                'label' => 'structure',
                'field_type' => ModelAutocompleteType::class,
                'field_options' => [
                    'property' => 'name',
                ],
            ])
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('code', null, ['label'=>'code'])
            ->add('porte', null, ['label'=>'door'])
            ->add('structure', null, ['label'=>'structure'])
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
        $form->tab("Service")
            ->with('details', ['class' => 'col-md-12'])
                ->add('code', null, ['label'=>'code', 'required' => true])
                ->add('porte', null, ['label'=>'door', 'required' => true])
                ->add('structure', ModelAutocompleteType::class, [
                    'label' => 'structure',
                    'required' => true,
                    'property' => 'name',
                ])
            ->end();
            if ($this->isCurrentRoute('edit')) {
                $form->with('details', ['class' => 'col-md-12'])
                    ->add('typeDocuments', CollectionType::class, [
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
            $form->end();
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('code', null, ['label'=>'code'])
            ->add('porte', null, ['label'=>'door'])
            ->add('structure', null, ['label' => 'structure'])
            ->add('date_created', null, ['label' => 'created on'])
            ->add('date_updated', null, ['label' => 'modified on'])
            ->add('user_created.username', null, ['label' => 'created by'])
            ->add('user_updated.username', null, ['label' => 'modified by'])
            ;
    }
}
