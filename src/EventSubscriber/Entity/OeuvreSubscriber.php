<?php

namespace App\EventSubscriber\Entity;

use App\Entity\Oeuvre;
use App\Service\FileService;
use App\Service\StringService;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OeuvreSubscriber implements EventSubscriber
{
    private $stringService;
    private $fileService;

    public function __construct(StringService $stringService, FileService $fileService)
    {
        $this->stringService = $stringService;
        $this->fileService = $fileService;
    }
    public function prePersist(LifecycleEventArgs $args):void
    {
        // par défaut, les souscripteurs écoutent toutes les entités
        $entity = $args->getObject();

        // si l'entité n'est pas Oeuvre
        if(!$entity instanceof Oeuvre){
            return;
        } else {
            // transfert d'image
            if($entity->getImage() instanceof UploadedFile){
                $this->fileService->upload($entity->getImage(), 'img/oeuvres');

                // mise à jour de la propriété image
                $entity->setImage( $this->fileService->getFileName() );
            }
        }
    }

    public function postLoad(LifecycleEventArgs $args):void
    {
        // par défaut, les souscripteurs écoutent toutes les entités
        $entity = $args->getObject();

        // si l'entité n'est pas Oeuvre
        if(!$entity instanceof Oeuvre){
            return;
        } else {
            // création d'une propriété dynamique pour stocker le nom de l'image
            $entity->prevImage = $entity->getImage();
        }
    }

    public function preUpdate(LifecycleEventArgs $args):void
    {
        // par défaut, les souscripteurs écoutent toutes les entités
        $entity = $args->getObject();

        // si l'entité n'est pas Oeuvre
        if(!$entity instanceof Oeuvre){
            return;
        } else {
            // si une image a été sélectionnée
            if($entity->getImage() instanceof UploadedFile){
                // transfert de la nouvelle image
                $this->fileService->upload($entity->getImage(), 'img/oeuvres');
                $entity->setImage( $this->fileService->getFileName() );

                // supprimer l'ancienne image
                if(file_exists("img/oeuvres/{$entity->prevImage}")) {
                    $this->fileService->remove('img/oeuvres', $entity->prevImage);
                }
            }
            // si aucune image n'a été sélectionnée
            else {
                $entity->setImage( $entity->prevImage );
            }
        }
    }

    public function getSubscribedEvents():array
    {
        return [
            Events::prePersist,
            Events::postLoad,
            Events::preUpdate,
        ];
    }

}
