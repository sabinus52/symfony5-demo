<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Controller;

use App\Datatable\ServerDatatable;
use Olix\BackOfficeBundle\Datatable\Response\DatatableResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Controleur des tables.
 */
class TablesController extends AbstractController
{
    /**
     * Lists all Server entities.
     *
     * @Route("/tables/server/list", name="table_server_list")
     */
    public function listServer(Request $request, ServerDatatable $datatable, DatatableResponse $responseService): Response
    {
        $isAjax = $request->isXmlHttpRequest();

        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService->setDatatable($datatable);
            $responseService->getDatatableQueryBuilder();

            return $responseService->getResponse();
        }

        return $this->render('default/server-table.html.twig', [
            'datatable' => $datatable,
        ]);
    }


}
