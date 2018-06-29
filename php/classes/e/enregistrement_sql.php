<?php
class fp_enregistrement_sql extends fp_enregistrement
{
	function __construct($champs,$table,$nom)
	{
		$this->champ_id=$nom;
		$this->valeur_id=$champs[$nom];
		$this->table=$table;
		$this->_champs = $champs;
		if(is_array($this->_champs)):
			$this->statut = true;
		else:
			$this->statut = false;
		endif;
	}
}
?>