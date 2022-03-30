# X_ray_lovers
## Projet de recrutement réalisé en 4-5 jours

X_ray_lovers est un projet de réservation de plages horaires pour des hopitaux partageant des équipements d'imagerie médicale. Le projet a été réalisé en quelques jours lors d'un test de recrutement. 

Il a été réalisé à l'aide de Laravel (il n'a pas été mis à jour depuis...)

## Objectif

Permettre à différents hôpitaux de pouvoir organiser les rendez-vous en imagerie médicale de leurs patients.
Les différents équipements (IRM, scanner, radio) étant partagés entre différents hôpitaux d'une même région.

## Fonctionnalité

- Ajout d'un nouveau patient (centralisé entre différents hopitaux)
- Ajout/suppression d'un nouveau rendez-vous
- Listing des rendez-vous (avec un filtre)
- Affichage des rendez-vous dans un calendrier partagé
- Sélection automatique et intelligente de la prochaine date disponible pour un rendez-vous. En fonction de l'urgence de la prise en charge du patient, les dates des scanners, radios, et IRM sont automatiquement trouvées. (Quelques dates proches sont gardées libres pour pouvoir rapidement prendre en charge les patients les plus gravement malade ou blessés).
