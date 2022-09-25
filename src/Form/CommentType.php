<?php

namespace App\Form\Type;

use App\Entity\Articles;
use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class commentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Votre commentaire'
            ])
            ->add('article', HiddenType::class)
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer'
            ]);
        
        $builder->get('article')
            ->addModelTransformer(new CallbackTransformer(
                fn (Articles $article) => $article->getId(),
                fn (Articles $article) => $article->getTitle()
            ));
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class' => Comments::class,
            'csrf_token_id' => 'comment-add'
        ]);
    }

}

?>