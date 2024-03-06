<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Dossier;
use App\Entity\Personne;
use App\Entity\Service;
use App\Entity\TypeDossier;
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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class DossierAdmin extends AbstractAdmin
{
    public function toString(object $object): string
    {
        return $object instanceof Dossier
            ? $object->__toString()
            : 'Application'; // shown in the breadcrumb on the create view
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('objet', null, ['label' => 'object'])
            ->add('personne', ModelFilter::class, [
                'field_type' => ModelAutocompleteType::class,
                'label' => 'user',
                'field_options' => ['class' => Personne::class, 'property' => 'name'],
            ])
            ->add('service', ModelFilter::class, [
                'field_type' => ModelAutocompleteType::class,
                'label' => 'service (code)',
                'field_options' => ['class' => Service::class, 'property' => 'code'],
            ])
            ->add('typeDossier', ModelFilter::class, [
                'field_type' => ModelAutocompleteType::class,
                'label' => 'type of application',
                'field_options' => ['class' => TypeDossier::class, 'property' => 'subjecten'],
            ])
            ->add('statut', ChoiceFilter::class, [
                'global_search' => true,
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => [
                        'draft' => 'draft',
                        'to complete' => 'incomplete',
                        'complete' => 'complete',
                        'rejecte' => 'rejecte',
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
            ->add('typeDossier', null, ['label'=>'type'])
            ->add('objet', null, ['label'=>'object'])
            ->add('personne', null, ['label'=>'user'])
            ->add('statut', FieldDescriptionInterface::TYPE_CHOICE, [
                'choices' => [
                    'draft' => 'draft',
                    'to complete' => 'incomplete',
                    'complete' => 'complete',
                    'rejecte' => 'rejecte',
                ],
                'label' => 'status'
            ])
            ->add('service', null, ['label'=>'service'])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->tab("Application")
            ->with("details", ['class' => 'col-md-6'])
                ->add('personne', ModelAutocompleteType::class, [
                    'label' => 'user',
                    'required' => true,
                    'property' => 'name',
                ])
                ->add('typeDossier', ModelAutocompleteType::class, [
                    'label' => 'type',
                    'required' => true,
                    'property' => 'subjecten',
                ])
                ->add('objet', null, ['label'=>'object'])
                ->add('service', ModelAutocompleteType::class, [
                    'label' => 'service',
                    'required' => true,
                    'property' => 'code',
                ])
                ->add('statut', ChoiceType::class, array('choices' => [
                    'draft' => 'draft',
                    'to complete' => 'incomplete',
                    'complete' => 'complete',
                    'rejecte' => 'rejecte',
                ], 'label' => 'status', 'required' => true))
            ->end();
            if ($this->isCurrentRoute('edit')) {
                $form->with('list of required documents', ['class' => 'col-md-12'])
                    ->add('pieces', CollectionType::class, [
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
                ->end()
                ->with('list of documents to complete', ['class' => 'col-md-12'])
                    ->add('pieceToCompletes', CollectionType::class, [
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
        $show->tab("Application")
        ->with("details", ['class' => 'col-md-6'])
            ->add('id')
            ->add('typeDossier', null, ['label'=>'type'])
            ->add('objet', null, ['label'=>'object'])
            ->add('personne', null, ['label'=>'user'])
            ->add('service', null, ['label'=>'service'])
            ->add('statut', FieldDescriptionInterface::TYPE_CHOICE, [
                'choices' => [
                    'draft' => 'draft',
                    'to complete' => 'incomplete',
                    'complete' => 'complete',
                    'rejecte' => 'rejecte',
                ],
                'label' => 'status'
            ])
        ->end()
        ->with('list of required documents', ['class' => 'col-md-12'])
            ->add('pieces', FieldDescriptionInterface::TYPE_ONE_TO_MANY, ['label'=>'documents attached'])
        ->end()
        ->with('list of documents to complete', ['class' => 'col-md-12'])
            ->add('pieceToCompletes', FieldDescriptionInterface::TYPE_ONE_TO_MANY, ['label'=>'documents lacking'])
            ->add('dateCompleted', null, ['label'=>'date of completion'])
        ->end()
        ->with('', ['class' => 'col-md-12'])
            ->add('date_created', null, ['label' => 'created on'])
            ->add('date_updated', null, ['label' => 'modified on'])
            ->add('user_created.username', null, ['label' => 'created by'])
            ->add('user_updated.username', null, ['label' => 'modified by'])
        ->end()
        ->end();
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->clearExcept(['create', 'show', 'edit', 'list']);
    }
}
