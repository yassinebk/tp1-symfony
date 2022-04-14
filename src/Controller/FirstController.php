<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\HttpFoundation\Response;


class FirstController
{

  #[Route("/first")]


  public function first()
  {

    return new Response("Hello there");
  }
}
