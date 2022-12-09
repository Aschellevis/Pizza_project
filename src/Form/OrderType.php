<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('size', null, [
//                'label' => "Maat",
//                'attr' => [
//                    'class' => "my-0 form-select"
//                ],
//                'row_attr' => [
//                    'class' => "col-md-12 mb-3",
//                ],
//
//            ])
            ->add('firstName', null, [
                'label' => "Voornaam",
                'attr' => [
                    'class' => "my-0"
                ],
                'row_attr' => [
                    'class' => "col-md-12 mb-3"
                ],
            ])
            ->add('lastName', null, [
                'label' => "Achternaam",

                'row_attr' => [
                    'class' => "col-md-12 mb-3"
                ],
            ])
            ->add('street', null, [
               'label' => "Straatnaam",

                'row_attr' => [
                    'class' => "col-md-6 mb-3"
                ],
            ])
            ->add('number', null, [
                'label' => "Huisnr",

                'row_attr' => [
                    'class' => "col-md-3 mb-3"
                ],
            ])
            ->add('addition', null, [
                'label' => "T.v.",

                'row_attr' => [
                    'class' => "col-md-3 mb-3"
                ],
            ])
            ->add('postalCode', null, [
                'label' => "Postcode",

                'row_attr' => [
                    'class' => "col-md-6 mb-3"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
