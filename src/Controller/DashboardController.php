<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $user = $request->request->get('username');
            $pass = $request->request->get('password');

            if ($user === 'admin' && $pass === 'admin') {
                $request->getSession()->set('auth', true);
                return $this->redirectToRoute('app_dashboard');
            }
            $this->addFlash('error', 'Accès refusé');
        }
        return $this->render('dashboard/login.html.twig');
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Request $request): Response
    {
        if (!$request->getSession()->get('auth')) {
            return $this->redirectToRoute('app_login');
        }

        // Récupération des métriques (valeurs par défaut du cours)
        $dette = (float) $request->query->get('dette', 5);
        $coverage = (int) $request->query->get('coverage', 80);
        $complexite = (int) $request->query->get('complexite', 12);

        // Algorithme de Diagnostic Stratégique (Niveau Master)
        $status = 'emerald';
        $label = "Système Sain";
        $impact = "ROI optimal : Le code est modulaire et maintenable.";
        $proposition = "Continuer le déploiement de nouvelles fonctionnalités.";

        if ($dette > 10 || $complexite > 20) {
            $status = 'red';
            $label = "Dette Critique";
            $impact = "Risque d'implosion : La maintenance coûte plus cher que le dev.";
            $proposition = "Stopper le flux et lancer un sprint de refactoring (ISO 25010).";
        } elseif ($coverage < 70) {
            $status = 'amber';
            $label = "Fragilité Technique";
            $impact = "Risque de régressions élevé lors des mises à jour.";
            $proposition = "Prioriser l'écriture de tests unitaires sur les modules critiques.";
        }

        return $this->render('dashboard/index.html.twig', [
            'dette' => $dette,
            'coverage' => $coverage,
            'complexite' => $complexite,
            'status' => $status,
            'label' => $label,
            'impact' => $impact,
            'proposition' => $proposition
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(Request $request): Response {
        $request->getSession()->remove('auth');
        return $this->redirectToRoute('app_login');
    }
}