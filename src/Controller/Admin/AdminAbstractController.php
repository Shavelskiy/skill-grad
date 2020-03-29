<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AdminAbstractController extends AbstractController
{
    protected const ITEMS_ON_PAGE = 20;
}
