🛡️ QualiGuard : Dashboard Stratégique de Qualimétrie
QualiGuard est une application d'aide à la décision basée sur le framework Symfony 7. Elle permet de piloter la santé d'un patrimoine logiciel en transformant des métriques techniques brutes en Indicateurs Clés de Performance (KPI) exploitables.

🎯 Objectifs du Projet
L'objectif est de répondre à la problématique : "Comment arbitrer entre le développement de nouvelles fonctionnalités et la réduction de la dette technique ?" Le dashboard s'appuie sur les 5 piliers de la qualité identifiés dans le cadre du module :

Code (Interne) : Maîtrise du taux de défauts.

Sécurité (Risque) : Gestion proactive de la dette technique.

Robustesse : Fiabilité via la couverture de tests.

Process (Vitesse) : Optimisation du Lead Time for Changes.

Usage (Externe) : Mesure de la satisfaction utilisateur (NPS).

🧠 Architecture & Logique Métier
Le projet respecte les principes du Clean Code et de la Clean Architecture :

Contrôleur Centralisé : Gestion de l'authentification et moteur de calcul des KPIs.

Normalisation des données : Transformation des saisies hétérogènes (jours, pourcentages, scores) en une base 100 commune pour une lecture immédiate.

Algorithme de Diagnostic : Évaluation automatique du score global pour générer des recommandations stratégiques (Performance, Vigilance ou Alerte).

🚀 Fonctionnalités
Authentification Sécurisée : Accès restreint via un portail admin (Login: admin / Password: admin).

Simulation en Temps Réel : Curseurs dynamiques permettant de tester différents scénarios de santé logicielle.

UI "Glassmorphism" 2026 : Interface moderne, responsive et épurée utilisant Tailwind CSS.

Indicateurs Calculés :

Indice de Qualité Intrinsèque (basé sur le taux de bugs).

Score de Maintenabilité (basé sur la dette).

Trust Score (Fiabilité combinée).

🛠️ Stack Technique
Backend : PHP 8.2+ / Symfony 7

Frontend : Twig / Tailwind CSS / FontAwesome

Norme de référence : ISO/IEC 25010

📦 Installation
Cloner le projet : git clone https://github.com/votre-pseudo/qualiguard.git

Installer les dépendances : composer install

Lancer le serveur : symfony serve ou php -S localhost:8000 -t public

Accès : Rendez-vous sur http://localhost:8000
