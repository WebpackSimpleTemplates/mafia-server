<?php

namespace App\Payload;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CreateGamePayload
{
  public function __construct(
    #[NotBlank]
    #[Type("string")]
    public readonly string $title,
    #[NotBlank]
    #[Type("int")]
    public readonly int $maxGamers,
    #[Type("string")]
    public readonly ?string $start,
  )
  {}
}
