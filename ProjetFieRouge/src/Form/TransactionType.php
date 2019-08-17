<?php

namespace App\Form;

use App\Entity\Envoyeur;
use App\Entity\Transaction;
use App\Entity\Beneficiaire;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('caissier')
            ->add('code')
            ->add('montant')
            ->add('frais')
            ->add('total')
            ->add('commissionsup')
            ->add('commissionparte')
            ->add('commissionetat')
           // ->add('datedenvoie')
            //->add('dateretrait')
            ->add('typedoperation')
            ->add('numerotransacion')
            ->add('envoyeur', EntityType::class,['class'=>Envoyeur::class])
            ->add('caissier', EntityType::class, ['class' => User::class])
            ->add('beneficiaire', EntityType::class,['class'=>Beneficiaire::class]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
