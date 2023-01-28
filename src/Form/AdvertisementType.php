<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertisementType extends AbstractType
{
    public function __construct(EntityManagerInterface $entityManager) {
        $this->em = $entityManager;
    }

    private function getCategorieRepository(): CategorieRepository
    {
        return $this->em->getRepository(Categorie::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('contenu', TextType::class)
            ->add('prix', IntegerType::class)
            ->add('codePostal', IntegerType::class)
            ->add('dateCreation', DateType::class)
            ->add('categorie', ChoiceType::class, [
                'choices' => $this->getCategorieRepository()->findAll()
            ])
            ->add('save', SubmitType::class)
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
