<?php

namespace  AppBundle\Service;

use Symfony\Component\HttpFoundation\Request;

class RequestFormatterService
{
    /**
     * @param Request $request
     * @return array
     */
    public function format(Request $request): array
    {
        $picture = $request->files->get('picture');
        $inputs = $request->request->all();
        $inputs["picture"] = $picture;
        unset($inputs['token']);
        return $inputs;
    }
}
