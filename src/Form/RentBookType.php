<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Rental;
use App\Entity\User;
use App\Repository\BookRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\QueryBuilder;

class RentBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $date = new \DateTime();

        $builder
            ->add('rentFrom', DateType::class, [
                'attr' => ['min' => $date->format('Y-m-d')],
                'widget' => 'single_text',
            ])
            ->add('rentTo', DateType::class, [
                'attr' => ['min' => $date->modify('+1 day')->format('Y-m-d')],
                'widget' => 'single_text',
            ])            ->add('itemId', EntityType::class, [
                'class' => Book::class,
                'query_builder' => function (BookRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('b')
                        ->addSelect('b')
                        ->leftJoin('b.availability', 'a')
                        ->andWhere("a.available > 0");
                },
                'choice_label' => 'name',
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rental::class,
        ]);
    }
}
