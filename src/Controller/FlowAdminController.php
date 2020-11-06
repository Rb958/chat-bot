<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\FlowManager;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class FlowAdminController extends CRUDController
{
    private $flowManager;

    public function __construct(FlowManager $flowManager)
    {
        $this->flowManager = $flowManager;
    }


    public function enableAction($id)
    {
        $object = $this->admin->getSubject();
        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        $object->setIsActivate(true);
        $this->flowManager->save($object);
        
        $this->addFlash('sonata_flash_success', 'successfully Enabled');

        return new RedirectResponse($this->admin->generateUrl('list'));      
    }

    public function disableAction($id)
    {
        $object = $this->admin->getSubject();
        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        $object->setIsActivate(false);
        $this->flowManager->save($object);
        
        $this->addFlash('sonata_flash_success', 'successfully Activated');

        return new RedirectResponse($this->admin->generateUrl('list'));      
    }
}
