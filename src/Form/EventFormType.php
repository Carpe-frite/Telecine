<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('event_name', null, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom de votre séance',
                ]])
            ->add('event_date')
            ->add('event_movie', null, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Film projeté',
                ]])
            ->add('event_start')
            ->add('event_end')
            ->add('event_detail', null, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Détails de votre séance',
                ]])
            ->add('event_max_participants', null, [
                'required' => true,
                'attr' => [
                    'placeholder' => '1',
                ]])
            ->add('event_movie_year')
            ->add('event_movie_genre')
            ->add('event_movie_picture', null, [
                'required' => false,
            ]);
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($options) {
            $builtEvent = $event->getData();
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}