<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use App\Repository\UtilisateurRepository;
use ContainerREZiCid\getKnpPaginatorService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    private EtablissementRepository $etablissementRepository;

    /**
     * @param EtablissementRepository $etablissementRepository
     */
    public function __construct(EtablissementRepository $etablissementRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
    }


    #[Route('/etablissements', name: 'app_etablissements')]
    public function allEtablissement(PaginatorInterface $paginator, Request $request): Response
    {

        $etablissements = $paginator->paginate(
            $this->etablissementRepository->findBy(["actif"=>'true'],['nom'=>'ASC']),
            $request->query->getInt("page",3),
            3,

        );

        return $this->render('etablissement/index.html.twig', [
            'Etablissements' => $etablissements,
            ]);
    }







    #[Route('/etablissement/{slug}', name: 'app_etablissement_slug')]
    public function EtablissementSlug($slug): Response
    {
        $etablissement = $this->etablissementRepository->findOneBy(["slug"=>$slug]);
        return $this->render('etablissement/etablissement.html.twig', [
            "Etablissement" => $etablissement
        ]);


    }

    #[Route('/etablissement/{slug}/favoris', name: 'app_favoris')]
    public function favorisation($slug, UtilisateurRepository $utilisateurRepository, EntityManagerInterface $manager): Response
    {
        $etablissement = $this->etablissementRepository->findOneBy(["slug"=>$slug]);
        $utilisateur = $utilisateurRepository->find($this->getUser());

        if(in_array($etablissement,$utilisateur->getFavoris()->toArray())){
            $etablissement->removeIdUtilisateur($utilisateur);
        }
        else
        {
            $etablissement->addIdUtilisateur($utilisateur);
        }

        $manager->persist($etablissement);
        $manager->flush();

        return $this->redirectToRoute('app_etablissements');
    }

    #[Route('/etablissements/favoris', name: 'app_list_fav')]
    public function listFavorite( UtilisateurRepository $utilisateurRepository): Response
    {

        $utilisateur = $utilisateurRepository->find($this->getUser());
        $etablissement = $utilisateur->getFavoris();


        return $this->render('etablissement/favoris.html.twig',[
            'Etablissements'=>$etablissement
        ]);
        }
}
