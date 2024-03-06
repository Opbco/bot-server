<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Category;
use App\Entity\Division;
use App\Entity\FormStructure;
use App\Entity\Langue;
use App\Entity\Order;
use App\Entity\Region;
use App\Entity\Structure;
use App\Entity\SubDivision;
use App\Entity\TypeStructure;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class StructureAdmin extends AbstractAdmin
{
    public function toString(object $object): string
    {
        return $object instanceof Structure
            ? $object->__toString()
            : 'Structure'; // shown in the breadcrumb on the create view
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('code', null, ['label'=>'registration number'])
            ->add('name', null, ['label'=>'name'])
            ->add('codeHierarchic', null, ['label'=>'hierarchical code'])
            ->add('adresse', null, ['label'=>'address'])
            ->add('contacts', null, ['label'=>'contacts'])
            ->add('langue', null, [
                'label' => 'language|sub-system',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Langue::class,
                    'choice_label' => 'label',
                ],
            ])
            ->add('forme', null, [
                'label' => 'form',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => FormStructure::class,
                    'choice_label' => 'name',
                ],
            ])
            ->add('ordre', null, [
                'label' => 'order',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Order::class,
                    'choice_label' => 'name',
                ],
            ])
            ->add('typeStructure', null, [
                'label' => 'type',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => TypeStructure::class,
                    'choice_label' => 'name',
                ],
            ])
            ->add('typeStructure.category', null, [
                'label' => 'category',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Category::class,
                    'choice_label' => 'name',
                ],
            ])
            ->add('subdivision', null, [
                'label' => 'sub-division',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => SubDivision::class,
                    'choice_label' =>
                    'name',
                ],
            ])
            ->add('subdivision.division', null, [
                'label' => 'Département',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Division::class,
                    'choice_label' =>
                    'name',
                ],
            ])
            ->add('subdivision.division.region', null, [
                'label' => 'Région',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Region::class,
                    'choice_label' =>
                    'name',
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
            ->add('code', null, ['label'=>'registration number'])
            ->add('name', null, ['label'=>'name'])
            ->add('codeHierarchic', null, ['label'=>'hierarchical code'])
            ->add('typeStructure', null, ['label'=>'type'])
            ->add('forme', null, ['label'=>'form'])
            ->add('subdivision', null, ['label'=>'sub-division'])
            ->add('subdivision.division', null, ['label'=>'division'])
            ->add('subdivision.division.region', null, ['label'=>'region'])
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
            ->add('code', null, ['label'=>'registration number'])
            ->add('name', null, ['label'=>'name'])
            ->add('codeHierarchic', null, ['label'=>'hierarchical code'])
            ->add('adresse', null, ['label'=>'address'])
            ->add('contacts', null, ['label'=>'contacts'])
            ->add('typeStructure', ModelType::class, ['label'=>'type', 'required' => true])
            ->add('langue', ModelType::class, ['label'=>'language|sub-system', 'required' => true])
            ->add('forme', ModelType::class, ['label'=>'form', 'required' => true])
            ->add('ordre', ModelType::class, ['label'=>'order', 'required' => true])
            ->add('subdivision', ModelType::class, ['label'=>'sub-division', 'required' => true])
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('code', null, ['label'=>'registration number'])
            ->add('name', null, ['label'=>'name'])
            ->add('codeHierarchic', null, ['label'=>'hierarchical code'])
            ->add('adresse', null, ['label'=>'address'])
            ->add('contacts', null, ['label'=>'contacts'])
            ->add('typeStructure', null, ['label'=>'type'])
            ->add('langue', null, ['label'=>'language|sub-system'])
            ->add('forme', null, ['label'=>'form'])
            ->add('ordre', null, ['label'=>'order'])
            ->add('subdivision', null, ['label'=>'sub-division'])
            ->add('date_created', null, ['label' => 'created on'])
            ->add('date_updated', null, ['label' => 'modified on'])
            ->add('user_created.username', null, ['label' => 'created by'])
            ->add('user_updated.username', null, ['label' => 'modified by'])
            ;
    }
}
