<?php

namespace App\Payload;

use Symfony\Component\Validator\Constraints\Type;

class CreateGamePayload
{
  public function __construct(
    #[Type("string")]
    public readonly ?string $title
  )
  {}
}