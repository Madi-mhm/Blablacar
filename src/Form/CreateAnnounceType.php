<?php

namespace App\Form;

use App\Entity\Ride;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateAnnounceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departure')
            ->add('destination')
            ->add('seats')
            ->add('price')
            ->add('date')
            ->add('rules')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ride::class,
        ]);
    }
}




// , EntityType::class, [
//     'class' => Rule::class,
//     'multiple' => true, 
//     'expanded' => true, 
//     'choice_label' => 'name', 
//     'by_reference' => false, 
//     'query_builder' => function(EntityRepository $er) use ($user){
//         return $er->createQueryBuilder('r')
//         ->where('r.author = :user')
//         ->setParameter('user', $user)
//     }
// ]