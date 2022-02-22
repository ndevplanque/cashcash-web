<?php
function get_intervention_by_id($id)
{
  include_once 'db_config.php';
  // se connecter
  $conn = getConnexion();

  // préparer la requête et l'exécuter
  $sql = "SELECT i.id, i.date_heure, e.libelle AS etat, t.nom, t.prenom, c.raison_sociale AS client
	FROM intervention i, client c, etat e, technicien t
	WHERE i.id_client=c.id AND i.etat=e.etat AND i.matricule=t.matricule
  AND i.id=:id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();

  // demander un retour sous forme de tableau associatif
  $result = $stmt->fetch();


  // fermer la connexion
  $conn = null;
  return $result;
}
