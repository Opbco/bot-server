<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\PieceRequise;
use App\Entity\TypeDossier;
use App\Entity\TypeDossierPieces;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class TypeDossierPiecesAdmin extends AbstractAdmin
{

    public function toString(object $object): string
    {
        return $object instanceof TypeDossierPieces
            ? $object->__toString()
            : 'Type of application & document'; // shown in the breadcrumb on the create view
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('nbPiece', null, ['label'=>'number of copies'])
            ->add('pieceRequise', ModelFilter::class, [
                'field_type' => ModelAutocompleteType::class,
                'label' => 'document',
                'field_options' => ['class' => PieceRequise::class, 'property' => 'namen'],
            ])
            ->add('typeDossier', ModelFilter::class, [
                'field_type' => ModelAutocompleteType::class,
                'label' => 'Type of application',
                'field_options' => ['class' => TypeDossier::class, 'property' => 'subjecten'],
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
            if ($this->isChild()) {
                $list->add('typeDossier', null, ['label'=>'application']);
            }
        $list->add('pieceRequise', null, ['label'=>'document'])
            ->add('nbPiece', null, ['label'=>'number of copies'])
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
            ->add('typeDossier', ModelType::class, ['label' => 'application', "disabled" => true, 'required' => true])
            ->add('pieceRequise', ModelType::class, ['label' => 'document', 'required' => true])
            ->add('nbPiece', null, ['label'=>'number of copies', 'required' => true])
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('typeDossier.subjecten', null, ['label' => 'application'])
            ->add('pieceRequise.namen', null, ['label' => 'document'])
            ->add('nbPiece', null, ['label'=>'number of copies'])
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
