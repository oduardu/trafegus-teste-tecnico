<?php

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class DefaultController extends AbstractActionController
{

    protected function getService($service)
    {
        if (!$this->getServiceLocator()) {
            return;
        }
        return $this->getServiceLocator()->get($service);
    }

    public function resJson($array)
    {
        $res = $this->getResponse();

        $headers = $res->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/json');
        $res->setHeaders($headers);
        $res->setStatusCode(200);
        $res->setContent(json_encode($array));

        return $res;
    }

}