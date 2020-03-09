<?php

namespace AppBundle\Form;

use AppBundle\Entity\AddressBook;
use AppBundle\Entity\City;
use AppBundle\Entity\Country;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use AppBundle\Repository\AddressBook\CityRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class AddressBookType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('first_name', TextType::class)
        ->add('last_name', TextType::class)
            ->add('birthday', DateType::class, ['widget' => 'single_text'])
            ->add('email', EmailType::class)
            ->add('phone_number', TelType::class)
            ->add('country', CountryType::class)
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'placeholder' => 'Select city',
                'query_builder' => function (CityRepository $repository) {
                    return $repository->createQueryBuilderAll();
                },
            ])
            ->add('zip', TextType::class)
            ->add('street', TextType::class)
            ->add(
                'picture',
                FileType::class,
                [
                'required' => false,
                'data_class' => null,
                'mapped' => false,
                'constraints' => [
                    new Image(),
                    ],
                ]
            )

            ->add('save', SubmitType::class)
            ->getForm();

//        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
//        $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPreSetData']);
    }
    public function onPreSetData(FormEvent $event)
    {
        /** @var Location $location */

        $addressBook = $event->getData();
        $country = $addressBook instanceof  AddressBook ?  $addressBook->getCountry() : null;
        $this->addCity($event->getForm(), $country);
    }

    private function addCity(FormInterface $form, $country = null)
    {
        $form->add('city', EntityType::class, [
            'class' => City::class,
            'choice_label' => 'name',
            'placeholder' => 'Select a city',
            'query_builder' => function (CityRepository $repository) use ($country) {
                return $repository->createAlphabeticalQueryBuilder($country);
            },
        ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => AddressBook::class,
        ]);
    }
}
