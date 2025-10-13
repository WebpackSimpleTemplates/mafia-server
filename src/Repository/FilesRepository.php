<?php

namespace App\Repository;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

class FilesRepository {
  public function __construct(private KernelInterface $kernel, private LoggerInterface $logger) {}
  
  public function saveFile(UploadedFile $file)
  {
    $filename = bin2hex(random_bytes(10)).'_'.$file->getClientOriginalName();

    $file->move($this->kernel->getProjectDir().'/public/uploads', $filename);

    return '/uploads'.'/'.$filename;
  }

  public function getFromRequest(Request $request, string $fieldname)
  {
    if($request->get($fieldname) !== null) {
      return $request->get($fieldname);
    }

    if ($request->files->get($fieldname)) {
      return $this->saveFile($request->files->get($fieldname));
    }

    return null;
  }
}