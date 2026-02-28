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
            if ($request->request->get('username') === 'admin' && $request->request->get('password') === 'admin') {
                $request->getSession()->set('auth', true);
                return $this->redirectToRoute('app_dashboard');
            }
            $this->addFlash('error', 'Identifiants invalides.');
        }
        return $this->render('dashboard/login.html.twig');
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Request $request): Response
    {
        if (!$request->getSession()->get('auth')) return $this->redirectToRoute('app_login');

        // --- 1. SAISIE (Données brutes de l'image) ---
        $bugs       = (float) $request->query->get('bugs', 1.5);    // Code (Interne)
        $dette      = (float) $request->query->get('dette', 4);     // Sécurité (Risque)
        $coverage   = (int)   $request->query->get('coverage', 85);  // Robustesse
        $leadTime   = (int)   $request->query->get('leadtime', 2);   // Process (Vitesse)
        $nps        = (int)   $request->query->get('nps', 25);       // Usage (Externe)

        // --- 2. SORTIE (Calcul des 5 Indicateurs Clés / KPIs) ---
        // On normalise chaque pilier sur 100 pour une lecture "Dashboard"
        $kpiQuality      = max(0, 100 - ($bugs * 10)); 
        $kpiSecurity     = 100 - $dette;               
        $kpiRobustness   = $coverage;                  
        $kpiProcess      = max(0, 100 - ($leadTime * 5)); 
        $kpiUsage        = min(100, max(0, ($nps + 100) / 2)); 

        // Score Global (Moyenne des 5 piliers)
        $globalScore = ($kpiQuality + $kpiSecurity + $kpiRobustness + $kpiProcess + $kpiUsage) / 5;

        // --- 3. DIAGNOSTIC STRATÉGIQUE ---
        $status = 'emerald'; 
        $label = "Performance Optimale";
        $proposition = "Le système respecte les objectifs. Maintenir la vélocité.";

        if ($bugs > 5 || $dette > 10 || $coverage < 70 || $leadTime > 10 || $nps < 0) {
            $status = 'red';
            $label = "Alerte Critique";
            $proposition = "Seuils d'alerte atteints. Priorité : Qualité et Refactoring.";
        } elseif ($globalScore < 80) {
            $status = 'amber';
            $label = "Vigilance Requise";
            $proposition = "Écart constaté. Améliorer les piliers en baisse.";
        }

        return $this->render('dashboard/index.html.twig', [
            'bugs' => $bugs, 'dette' => $dette, 'coverage' => $coverage, 'leadTime' => $leadTime, 'nps' => $nps,
            'kpiQuality' => $kpiQuality, 'kpiSecurity' => $kpiSecurity, 'kpiRobustness' => $kpiRobustness,
            'kpiProcess' => $kpiProcess, 'kpiUsage' => $kpiUsage,
            'globalScore' => $globalScore, 'status' => $status, 'label' => $label, 'proposition' => $proposition
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(Request $request): Response {
        $request->getSession()->remove('auth');
        return $this->redirectToRoute('app_login');
    }
}