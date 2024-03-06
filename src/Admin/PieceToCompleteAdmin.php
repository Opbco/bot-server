<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Dossier;
use App\Entity\PieceRequise;
use App\Entity\PieceToComplete;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\DateTimeRangeFilter;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class PieceToCompleteAdmin extends AbstractAdmin
{

    public function toString(object $object): string
    {
        return $object instanceof PieceToComplete
            ? $object->__toString()
            : 'Document To complete'; // shown in the breadcrumb on the create view
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('completed', null, ['label'=>'completed'])
            ->add('dateCompleted', DateTimeRangeFilter::class, ['label'=>'date of completion'] )
            ->add('piece', ModelFilter::class, [
                'field_type' => ModelAutocompleteType::class,
                'label' => 'document',
                'field_options' => ['class' => PieceRequise::class, 'property' => 'namen'],
            ])
            ->add('dossier', ModelFilter::class, [
                'field_type' => ModelAutocompleteType::class,
                'label' => 'application',
                'field_options' => ['class' => Dossier::class, 'property' => 'objet'],
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
        $list->add('id');
            if (!$this->isChild()) {
                $list->add('dossier', null, ['label'=>'application']);
            }
        $list->add('piece', null, ['label'=>'document'])
            ->add('completed', null, ['label'=>'completed'])
            ->add('dateCompleted', null, ['label'=>'date of completion'])
            ->add('date_created', null, ['label'=>'date of submission'])
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
            ->add('dossier', ModelType::class, ['label' => 'application', "disabled" => $this->isChild(), 'required' => true])
            ->add('piece', ModelType::class, ['label' => 'document', 'required' => true])
            ->add('completed', null, ['label'=>'completed'])
            ->add('dateCompleted', DateTimePickerType::class, ['label'=>'date of completion'])
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('dossier', null, ['label' => 'application'])
            ->add('piece', null, ['label' => 'document'])
            ->add('completed', null, ['label'=>'completed'])
            ->add('dateCompleted', null, ['label'=>'date of completion'])
            ->add('date_created', null, ['label' => 'created on'])
            ->add('date_updated', null, ['label' => 'modified on'])
            ->add('user_created.username', null, ['label' => 'created by'])
            ->add('user_updated.username', null, ['label' => 'modified by'])
            ;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {

        if ($this->isChild()) {
            return;
        }

        // This is the route configuration as a parent
        $collection->clearExcept(['create', 'show', 'edit']);
    }
}
