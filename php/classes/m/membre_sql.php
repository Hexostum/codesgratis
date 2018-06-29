<?php
class fp_membre_sql extends fp_enregistrement_sql
{
	function __construct(array $sql)
	{
		parent::__construct($sql,'codesgratis_membres','membre_id');
	}
	public function membre_existe()
	{
		return $this->statut();
	}
}
?>