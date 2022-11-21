<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class UploadFile
{
    private RequestStack $request;
    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    public function encodeImage()
    {
        $request = $this->request->getCurrentRequest();
        $file=$request->files->all()['imageFile'];
        //dd($file->getSize());
        return stream_get_contents(fopen($file->getRealPath(), 'rb'));
    }
}
