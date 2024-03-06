<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Bordereau;
use App\Entity\Dossier;
use App\Entity\Service;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ChoiceFilter;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;
use Sonata\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class BordereauAdmin extends AbstractAdmin
{
    public function toString(object $object): string
    {
        return $object instanceof Bordereau
            ? $object->__toString()
            : 'Tansmission'; // shown in the breadcrumb on the create view
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('emetteur', ModelFilter::class, [
                'field_type' => ModelAutocompleteType::class,
                'label' => 'service (transmitting)',
                'field_options' => ['class' => Service::class, 'property' => 'code'],
            ])
            ->add('recepteur', ModelFilter::class, [
                'field_type' => ModelAutocompleteType::class,
                'label' => 'service (receiving)',
                'field_options' => ['class' => Service::class, 'property' => 'code'],
            ])
            ->add('statut', ChoiceFilter::class, [
                'global_search' => true,
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => [
                        'draft' => 'draft',
                        'transmit' => 'transmit',
                        'received' => 'received',
                        'cancelled' => 'cancelled',
                    ]
                ], array('label' => 'status')
            ])
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
            ->add('emetteur', null, ['label'=>'service (transmitting)'])
            ->add('recepteur', null, ['label'=>'service (receiving)'])
            ->add('statut', FieldDescriptionInterface::TYPE_CHOICE, [
                'choices' => [
                    'draft' => 'draft',
                    'transmit' => 'transmit',
                    'received' => 'received',
                    'cancelled' => 'cancelled',
                ],
                'label' => 'status'
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->tab("Transmission")
            ->with("details", ['class' => 'col-md-6'])
                ->add('emetteur', ModelAutocompleteType::class, [
                    'label' => 'service (transmitting)',
                    'required' => true,
                    'property' => 'code',
                ])
                ->add('recepteur', ModelAutocompleteType::class, [
                    'label' => 'service (receiving)',
                    'required' => true,
                    'property' => 'code',
                ])
                ->add('statut', ChoiceType::class, array('choices' => [
                    'draft' => 'draft',
                    'transmit' => 'transmit',
                    'received' => 'received',
                    'cancelled' => 'cancelled',
                ], 'label' => 'status', 'required' => true))
            ->end()
            ->with('list of applications', ['class' => 'col-md-12'])
            ->add('dossiers', ModelAutocompleteType::class, array('property' => 'objet', 'label' => 'applications', 'required' => true, 'multiple' => true, 'by_reference' => false))
            ->end()
            ->end()
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->tab("Transmission")
        ->with("details", ['class' => 'col-md-6'])
            ->add('emetteur', null, ['label' => 'service (transmitting)'])
            ->add('recepteur', null, ['label' => 'service (receiving)'])
            ->add('statut', FieldDescriptionInterface::TYPE_CHOICE, [
                'choices' => [
                    'draft' => 'draft',
                    'transmit' => 'transmit',
                    'received' => 'received',
                    'cancelled' => 'cancelled',
                ],
                'label' => 'status'
            ])
        ->end()
        ->with('list of applications', ['class' => 'col-md-12'])
            ->add('dossiers', FieldDescriptionInterface::TYPE_MANY_TO_MANY, ['label' => 'applications'])
        ->end()
        ->end();
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->clearExcept(['create', 'show', 'edit', 'list']);
    }
}
