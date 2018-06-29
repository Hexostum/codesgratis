<?php
class fp_membre extends fp_enregistrement
{
	function __construct($valeur,$nom='membre_id',$champs='*')
	{
		parent::__construct('codesgratis_membres',$valeur,$nom,$champs);
	}
	public function membre_existe()
	{
		return $this->statut();
	}
}
?>