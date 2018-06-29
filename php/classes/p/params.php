<?php
/**
 * CLASS PROPS
 *
 * @author Scelzo Patrick
 * @package FinalPortail
 */

/**
 * Classe servant  traiter les tableaux de proprits.
 *
 */
class fp_params extends fp_objet 
{
	/**
	 * Tableau de proprits.
	 *
	 * @var array
	 */
	private $champs;
	
	/**
	 * Constructeur
	 *
	 * @param array $t_props Tableau de proprits.
	 */
	public function __construct(array $t_props)
	{
		$this->trace("PROPS::__CONSTRUCT private.champs = " . print_r($t_props,true) , false );
		$this->champs = $t_props;
	}
	
	public function __get($nom)
	{
		return $this->get_prop($nom,NULL);
	}
	
	/**
	 * Obtenir une proprit
	 *
	 * @param string $s_nom Le nom de la proprit
	 * @param mixed $s_valeur_defaut Valeur par dfaut
	 * @return mixed
	 */
	public function get_prop($s_nom,$s_valeur_defaut=null)
	{
		$this->trace("PROPS::GET_PROP (s_nom = $s_nom) (s_valeur_defaut = $s_valeur_defaut)", false );
		if($this->prop_exists($s_nom)):
			$this->trace("PROPS::GET_PROP $s_nom [OK] return [{$this->champs[$s_nom]}] " , false);
			return $this->champs[$s_nom];
		else:
			$this->trace("PROPS::GET_PROP $s_nom [KO] return [$s_valeur_defaut] " , false );
			return $s_valeur_defaut;
		endif;
	}
	public function prop_exists($s_nom)
	{
		$this->trace("PROPS::PROP_EXISTS (s_nom = $s_nom)", false );
		if(array_key_exists($s_nom , $this->champs)):
			$this->trace("PROPS::PROP_EXISTS return true", false );
			return true;
		else:
			$this->trace("PROPS::PROP_EXISTS return false", false );			
			return false;
		endif;
	}
}
?>