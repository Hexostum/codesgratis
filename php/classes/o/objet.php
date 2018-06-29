<?php
/**
* @author Scelzo Patrick - Final Séraphin <fs@dimensionrpg.net>
* @package FinalPortail
* @name Objet
* @version $Id: objet.php,v 1.1 2005/07/04 18:37:29 scelzosoft Exp $
* @copyright Final Portail (C) 2000 - 2005
*/
/* --- Début vérification de sécurité --- */

if(!class_exists('fp_objet')):


define( 'FP_CLASSE_objet' , '1.00' );

/**
 * Super Classe destinée à etre héritée
 *
 */
class fp_objet
{
	/**
	 * Identifiant de classe
	 *
	 * @var int
	 */
	protected $objet_id ;
	
	/**
	 * Nombre d'action trace
	 *
	 * @var int
	 */
	protected $action = 0 ;
	/**
	 * Indique la dernire erreur trace
	 *
	 * @var string
	 */
	protected $derniere_erreur = '' ;
	protected $trace=true;
	
	/**
	 * Trace les actions effectus par la classe
	 *
	 * @var array
	 */
	protected $traceur = array() ;
	
	/**
	 * Constructeur
	 *
	 * @return objet
	 */
	function __construct($id=null,$trace=true)
	{
		static $_uid = 0;
		$this->trace = $trace;
		$this->trace('['.__function__.'] [ this.trace = ['.$this->trace.'] ]');
		if(is_null($id)):
			$this->objet_id = get_class($this) . '_'  . $_uid++;
		else:
			$this->objet_id = get_class($this) . '_'  . $id;
		endif;		
		$this->trace('['.__function__.'] [ this.objet_id = ['.$this->objet_id.'] ]');		
	}
	/**
	 * Retourne la classe parente
	 *
	 * @return string
	 */
	function get_parent()
	{
		return get_parent_class($this);
	}
	/**
	 * Trace les actions de la classe
	 *
	 * @param string $s_action
	 * @param string $s_erreur
	 */
	protected function trace($s_action , $s_erreur = false)
	{
		if($this->trace):
			$this->traceur[$this->action]['description'] = $s_action;
			$this->traceur[$this->action]['erreur'] = $s_erreur;
			$this->derniere_erreur = $s_erreur;
			$this->action++;
		endif;
	}
	
	public function __toString()
	{
		$texte = '';
		$texte .=  '<div class="debug_info">' . FP_LIGNE;
		$texte .=  '<h1>'.get_class().'</h1>' . FP_LIGNE;
		$texte .= '<table border="1">' . FP_LIGNE;
		$texte .= '<tr><th>Propriété</th><th>Valeur</th></tr>' . FP_LIGNE;
		$texte .= '<tr><td> this.objet_id </td><td>'.$this->objet_id.'</td></tr>';
		$texte .= '<tr><td> this.action </td><td>'.$this->action.'</td></tr>';
		$texte .= '<tr><td> this.trace </td><td>'.$this->trace.'</td></tr>';
		foreach($this->traceur as $id => $trace):
			$texte .= '<tr><td> this.trace['.$id.'] </td><td>'.$trace['description'] . ' [Erreur][' . $trace['erreur'] .']</td></tr>';
		endforeach;
		$texte .= '</table>' . FP_LIGNE;
		$texte .= '</div>' . FP_LIGNE;
		return $texte;
	}	
}
endif;
?>