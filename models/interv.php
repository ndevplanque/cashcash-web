<?php
function get_intervention_by_id($id_intervention)
{
  include_once 'models/db_config.php';
  // se connecter
  $conn = getConnexion();

  // préparer la requête et l'exécuter
  $sql = "SELECT i.id, i.date_heure, e.libelle AS e_libelle, e.etat AS e_id, t.matricule,
    t.nom AS t_nom, t.prenom AS t_prenom, c.raison_sociale AS client, c.code_agence
    FROM intervention i LEFT JOIN technicien t ON i.matricule=t.matricule, client c, etat e
    WHERE i.id_client=c.id AND i.etat=e.etat
    AND i.id=:id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id_intervention, PDO::PARAM_INT);
  $stmt->execute();

  // demander un retour sous forme de tableau associatif
  $result = $stmt->fetch();

  // fermer la connexion
  $conn = null;
  return $result;
}

function affecter_a($id_intervention, $matricule)
{
  if ($matricule == null) return false;
  
  include_once 'models/db_config.php';
  // se connecter
  $conn = getConnexion();

  // préparer la requête et l'exécuter
  $sql = "UPDATE intervention
    SET matricule=:matricule, etat=2, date_heure=date_heure
    WHERE id=:id AND etat=1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id_intervention, PDO::PARAM_INT);
  $stmt->bindParam(':matricule', $matricule, PDO::PARAM_STR);
  $result = $stmt->execute();

  // fermer la connexion
  $conn = null;
  return $result;
}

function update_intervention($id_intervention, $date_heure, $matricule)
{
  include_once 'db_config.php';
  // se connecter
  $conn = getConnexion();

  // préparer la requête et l'exécuter
  $sql = "UPDATE intervention
    SET date_heure=:date_heure, matricule=:matricule
    WHERE id=:id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id_intervention, PDO::PARAM_INT);
  $stmt->bindParam(':date_heure', $date_heure, PDO::PARAM_STR);
  $stmt->bindParam(':matricule', $matricule, PDO::PARAM_STR);
  $result = $stmt->execute();

  // fermer la connexion
  $conn = null;
  return $result;
}
