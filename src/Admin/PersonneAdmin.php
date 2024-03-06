<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Personne;
use App\Entity\Service;
use App\Entity\Structure;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ChoiceFilter;
use Sonata\DoctrineORMAdminBundle\Filter\DateFilter;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class PersonneAdmin extends AbstractAdmin
{
    public function toString(object $object): string
    {
        return $object instanceof Personne
            ? $object->__toString()
            : 'Personnel|USager'; // shown in the breadcrumb on the create view
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('matricule', null, ['label'=>'service number'])
            ->add('name', null, ['label'=>'name'])
            ->add('datenaiss', DateFilter::class, ['label'=>'date of birth'])
            ->add('lieunaiss', null, ['label'=>'place of birth'])
            ->add('address', null, ['label'=>'address'])
            ->add('mobile', null, ['label'=>'phone'])
            ->add('email', null, ['label'=>'email'])
            ->add('whatsapp', null, ['label'=>'whatsapp'])
            ->add('telegram', null, ['label'=>'telegram'])
            ->add('category', ChoiceFilter::class, [
                'global_search' => true,
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => [
                        'organisme' => 'organisme', 
                        'personnel' => 'personnel', 
                        'autre' => 'autre'
                    ]
                ], array('label' => 'category')
            ])
            ->add('service', null, [
                'label' => 'service',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Service::class,
                    'choice_label' => 'code',
                ],
            ])
            ->add('structure', ModelFilter::class, [
                'label' => 'structure',
                'field_type' => ModelAutocompleteType::class,
                'field_options' => [
                    'property' => 'name',
                ],
            ])
            ->add('fonction', ModelFilter::class, [
                'label' => 'position',
                'field_type' => ModelAutocompleteType::class,
                'field_options' => [
                    'property' => 'name',
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
            ->add('category', FieldDescriptionInterface::TYPE_CHOICE, [
                'choices' => [
                    'organisme' => 'organisme', 
                    'personnel' => 'personnel', 
                    'autre' => 'autre'
                ],
            ])
            ->add('matricule', null, ['label'=>'service number'])
            ->add('name', null, ['label'=>'name'])
            ->add('datenaiss', null, ['label'=>'date of birth'])
            ->add('lieunaiss', null, ['label'=>'place of birth'])
            ->add('mobile', null, ['label'=>'phone'])
            ->add('email', null, ['label'=>'email'])
            ->add('whatsapp', null, ['label'=>'whatsapp'])
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
        $form->tab('usager|personnel details')
            ->with('Identification', ['class' => 'col-md-6'])
                ->add('category', ChoiceFieldMaskType::class, [
                    'choices' => [ 
                        'personnel' => 'personnel',
                        'internal user' => 'agent',
                        'external user' => 'autre'
                    ],
                    'map' => [
                        'agent' => ['matricule', 'datenaiss', 'lieunaiss', 'structure', 'fonction'],
                        'personnel' => ['matricule', 'datenaiss', 'lieunaiss', 'fonction', 'service'],
                        'autre' => [],
                    ],
                    'placeholder' => 'category',
                    'required' => true
                ])
                ->add('matricule', null, ['label'=>'service number', 'required'=>false])
                ->add('name', null, ['label'=>'name', 'required'=>true])
                ->add('datenaiss', null, ['label'=>'date of birth', 'required'=>false])
                ->add('lieunaiss', null, ['label'=>'place of birth', 'required'=>false])
            ->end()
            ->with('Localisation', ['class' => 'col-md-6'])
                ->add('structure', ModelAutocompleteType::class, [
                    'label' => 'structure',
                    'required' => false,
                    'property' => 'name',
                ])
                ->add('address', TextareaType::class, ['label' => "Adresse", 'required' => false])
                ->add('mobile', null, ['label'=>'phone', 'required' => true])
                ->add('email', null, ['label'=>'email', 'required' => false])
                ->add('whatsapp', null, ['label'=>'whatsapp', 'required' => false])
                ->add('telegram', null, ['label'=>'telegram', 'required' => false])
            ->end()
            ->with('details service | position', ['class' => 'col-md-12'])
                ->add('fonction', ModelAutocompleteType::class, [
                    'label' => 'position',
                    'required' => false,
                    'property' => 'name',
                ])
                ->add('service', ModelAutocompleteType::class, [
                    'label' => 'service',
                    'required' => false,
                    'property' => 'code',
                ])
            ->end()
            ->end()
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->tab('usager|personnel details')
        ->with('Identification', ['class' => 'col-md-6'])
            ->add('id')
            ->add('category', null, array('label' => 'category'))
            ->add('matricule', null, ['label'=>'service number'])
            ->add('name', null, ['label'=>'name'])
            ->add('datenaiss', null, ['label'=>'date of birth'])
            ->add('lieunaiss', null, ['label'=>'place of birth'])
        ->end()
        ->with('Localisation', ['class' => 'col-md-6'])
            ->add('structure', null, ['label' => 'structure'])
            ->add('address', null, ['label' => "Adresse"])
            ->add('mobile', null, ['label'=>'phone'])
            ->add('email', null, ['label'=>'email'])
            ->add('whatsapp', null, ['label'=>'whatsapp'])
            ->add('telegram', null, ['label'=>'telegram'])
        ->end()
        ->with('details service | position', ['class' => 'col-md-12'])
            ->add('fonction', null, ['label' => 'position'])
            ->add('service', null, ['label' => 'service'])
            ->add('date_created', null, ['label' => 'created on'])
            ->add('date_updated', null, ['label' => 'modified on'])
            ->add('user_created.username', null, ['label' => 'created by'])
            ->add('user_updated.username', null, ['label' => 'modified by'])
        ->end()
        ->end();
    }
}