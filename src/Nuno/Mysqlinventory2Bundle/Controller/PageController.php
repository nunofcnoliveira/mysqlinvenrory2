<?php

namespace Nuno\Mysqlinventory2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
	public function indexAction()
	{
		return $this->render('NunoMysqlinventory2Bundle:Page:index.html.twig');
	}
}