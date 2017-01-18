<?php

namespace IVS\IVStoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use IVS\IVStoreBundle\Entity\Media;
use IVS\IVStoreBundle\Entity\Point;
use IVS\IVStoreBundle\Entity\Zone;
use IVS\IVStoreBundle\Form\ZoneType;
use FOS\RestBundle\Controller\Annotations as Rest; // alias for all annotations
use FOS\RestBundle\View\View as RestView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\View;

class DefaultController  extends FOSRestController
{

    /**
     * Créer une zone.
     *
     * @Rest\Post("/zone", name="api_creer_zone",options={ "method_prefix" = false })
     *
     * @param Request $request
     * @return string
     */
    public function postZoneAction(Request $request)
    {

        $zone = new Zone();

        //create the form and pass the HttpMethod to manage fields requirements
        $oForm = $this->createForm(ZoneType::class,$zone);
        //bind submittedData into the form
        $oForm->submit($request->request->all());
        //dump($oForm->getData());die;

        if ($oForm->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($zone);
            $em->flush();
            return $this->handleView(RestView::create($zone, '200'));
           // return $zone;
        } else {

          //  return $request->request->all();
            return $this->handleView(RestView::create($oForm->getErrors(), '403'));

        }

    }

    /**
     * Récupérer la liste des zones.
     *
     * @Rest\Get("/zones", name="api_liste_zones",options={ "method_prefix" = false })
     *
     *
     * @Rest\QueryParam(name="offset", requirements="\d+", default="", description="Index de début de la pagination")
     * @Rest\QueryParam(name="limit", requirements="\d+", default="", description="Nombre d'éléments à afficher")
     * @Rest\QueryParam(name="sort", requirements="(asc|desc)", nullable=true, description="Ordre de tri (basé sur le nom)")
     *
     * @param Request $request
     * @return string
     */
    public function getZonesAction(Request $request, ParamFetcher $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $sort = $paramFetcher->get('sort');

        $qb = $this->get('doctrine.orm.entity_manager')->createQueryBuilder();
        $qb->select('z')
            ->from('IVStoreBundle:Zone', 'z');

        if ($offset != "") {
            $qb->setFirstResult($offset);
        }

        if ($limit != "") {
            $qb->setMaxResults($limit);
        }

        if (in_array($sort, ['asc', 'desc'])) {
            $qb->orderBy('z.nom', $sort);
        }

        $zones = $qb->getQuery()->getResult();
        return $this->handleView(RestView::create($zones, '200'));
    }

    /**
     * Récupérer une zone.
     *
     * @Rest\Get("/zone/{id_zone}", name="api_zone_details",options={ "method_prefix" = false })
     *
     * @Rest\View(serializerGroups={"all"})
     *
     * @ParamConverter("oZone", class="IVStoreBundle:Zone", options={"id" = "id_zone"})
     *
     * @param Request $request
     * @return string
     */
    public function getZoneDetailsAction(Request $request, Zone $oZone=null)
    {
        return $oZone;
    }


    /**
     * Modifier une zone.
     * @Rest\Put("/zone/{id_zone}", name="api_modifier_zone",options={ "method_prefix" = false }))
     *
     * @ParamConverter("oZone", class="IVStoreBundle:Zone", options={"id" = "id_zone"})
     *
     * @param Request $request
     * @return string
     */
    public function updateZoneAction(Request $request, Zone $oZone=null)
    {
        $aSubmittedData = [
            'nom'=>$request->request->get('nom'),
            'couleur'=>$request->request->get('couleur'),
            'listePoints'=>$request->request->get('listePoints'),
        ];
        //create the form and pass the HttpMethod to manage fields requirements
        $oForm = $this->createForm(ZoneType::class,$oZone);
        //bind submittedData into the form
        $oForm->submit($aSubmittedData);
        //dump($oForm->getData());die;

        if ($oForm->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            /**
             * @var Point $point
             */
            foreach ($oZone->getListePoints() as $point) { $point->setZone($oZone);}

            $em->merge($oZone);
            $em->flush();

            return $this->handleView(RestView::create($oZone, '200'));
            // return $zone;
        } else {
           return $request->request->all();
            return $this->handleView(RestView::create($oForm->getErrors(), '403'));

        }

    }
    /**
     * Supprimer une zone.
     * @Rest\Delete("/zone/{id_zone}", name="api_Supprimer_zone",options={ "method_prefix" = false })
     *
     * @ParamConverter("oZone", class="IVStoreBundle:Zone", options={"id" = "id_zone"})
     *
     * @param Request $request
     * @return string
     */
    public function removeZoneAction(Request $request, Zone $oZone=null)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $em->remove($oZone);
        $em->flush();

        return 'ok';
    }

    /**
     * Récupérer le background .
     *
     * @Rest\Get("/background", name="api_background",options={ "method_prefix" = false })
     *
     * @param Request $request
     * @return string
     */
    public function getBackgroundAction(Request $request)
    {
//        date format y-mm-dd hh:mm:ss   ex: 2017-01-18

        $date= new \DateTime($request->query->get('date'));

//        $media=new Media();
//        $media->setDate($date)
//              ->setUrl('img/background');
//        $em = $this->get('doctrine.orm.entity_manager');
//        $em->persist($media);
//        $em->flush();

        $background = $this->get('doctrine.orm.entity_manager')->getRepository(Media::class)->findOneBy([
          'date'=>$date
        ]);

        return (!is_null($background))?$background->getUrl():'img/background';

    }

}
