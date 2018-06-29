<?php
class fp_enregistrement extends fp_objet
{
	protected $table;
	protected $champ_id;
	protected $valeur_id;
	protected $statut;
	protected $_champs = array();
	function __construct($table,$valeur,$nom,$champs='*')
	{
		parent::__construct($valeur);
		$champs = is_array($champs) ? ('`' . implode( '`,`' . $champs) . '`') : $champs;
		$this->champ_id=$nom;
		$this->valeur_id=$valeur;
		$this->trace('['.__function__.'] [ this.champ_id = ['.$nom.'] ]');
		$this->table=$table;
		$this->trace('['.__function__.'] [ this.table = ['.$table.'] ]');
		if($valeur=='' && $nom==''):
			$sql = "SELECT $champs FROM {$this->table} ";
		else:
			$sql = "SELECT $champs FROM {$this->table} where {$this->champ_id}=$valeur";
		endif;
		$sql_query = mysql_query($sql);
		$this->trace('['.__function__.'][SQL]['.$sql.']',mysql_error());
		if(is_resource($sql_query)):
			$this->_champs = mysql_fetch_array($sql_query,MYSQL_ASSOC);
			if(is_array($this->_champs)):				
				$this->trace('['.__function__.'] [ this.statut = [true] ]');
				$this->statut = true;
			else:
				$this->trace('['.__function__.'] [ this.statut = [false] ]','is_array');
				$this->statut = false;
			endif;
		else:
			$this->trace('['.__function__.'] [ this.statut = [false] ]','is_ressource');
			$this->statut=false;
		endif;
	}
	public function statut()
	{
		return $this->statut;
	}
	public function valeur_champ($nom,$fonction=null,$parametres=null,$position=0)
	{
		if($this->statut()):
			if(array_key_exists($nom,$this->_champs)):
				if($fonction==null):
					return $this->_champs[$nom];
				else:
					if($parametres==null):
						return $fonction($this->_champs[$nom]);
					else:
						$parametres[$position] = $this->_champs[$nom];
						return call_user_func_array($fonction,$parametres);
					endif;
				endif;
			else:
				echo ($nom) . "<br>\r\n";
				return null;
			endif;
		else:
			return null;
		endif;
	}
	public function incremente_champ($nom,$valeur=1)
	{
		if($this->statut()):
			if(array_key_exists($nom,$this->_champs)):
				$sql = "UPDATE {$this->table} SET $nom=$nom+$valeur WHERE {$this->champ_id}=".$this->valeur_id;
				$statut = mysql_query( $sql );
				$this->trace('['.__function__.'][SQL]['.$sql.']',!$statut);
				if($statut):
					$this->_champs[$nom] += $valeur;
					$this->trace('['.__function__.'][ this._champs['.$nom.'] = ['.$this->_champs[$nom].'] ]');
					return true;	
				else:
					return false;
				endif;
			else:
				$this->trace('['.__function__.']','array_key_exists('.$nom.')');
				trigger_error("Champ {$nom} inconnu pour {$this->table} !", E_USER_ERROR);
				return false;
			endif;
		else:
			$this->trace('['.__function__.']','this.statut');
			return false;
		endif;
	}
	public function mise_a_jour_champ($nom,$valeur,$string=true)
	{
		if($this->statut):
			if(array_key_exists($nom,$this->_champs)):
				if($string):
					$sql = "UPDATE {$this->table} SET $nom='".mysql_real_escape_string($valeur)."' WHERE {$this->champ_id}=".$this->valeur_id;
				else:
					$sql = "UPDATE {$this->table} SET $nom=$valeur WHERE {$this->champ_id}=".$this->valeur_id;
				endif;
				$statut = mysql_query( $sql );
				$this->trace('['.__function__.'][SQL]['.$sql.']',!$statut);
				if($statut):
					$this->trace('['.__function__.'][ this._champs['.$nom.'] = ['.$valeur.'] ]');
					$this->_champs[$nom] = $valeur;
					return true;	
				else:
					return false;
				endif;
			else:
				$this->trace('['.__function__.']','array_key_exists('.$nom.')');
				trigger_error("Champ {$nom} inconnu pour {$this->table} !", E_USER_ERROR);
				return false;
			endif;
		else:
			$this->trace('['.__function__.']','this.statut');
			return false;
		endif;
	}
	public function __get($nom)
	{
		if($this->statut()):
			if(array_key_exists($nom,$this->_champs)):
				return $this->_champs[$nom];
			else:
				trigger_error("Champ {$nom} inconnu pour {$this->table} !", E_USER_ERROR);
				return null;
			endif;
		else:
			return null;
		endif;
	}
	public function __set($nom,$valeur)
	{
		if($this->statut()):
			if(is_int($valeur) || is_double($valeur)):
				$this->mise_a_jour_champ($nom,$valeur,false);
			elseif(is_null($valeur)):
				$this->mise_a_jour_champ($nom,'NULL',false);
			else:
				$this->mise_a_jour_champ($nom,$valeur);
			endif;
		else:
			return null;
		endif;
	}
	public function __toString()
	{
		$texte = '';
		$texte .= '<div class="debug_infos">' . FP_LIGNE;
		$texte .=  '<h1>'.get_class($this).'</h1>' . FP_LIGNE;
		$texte .= '<table border="1">' . FP_LIGNE;
		$texte .= '<tr><th>Propriété</th><th>Valeur</th></tr>' . FP_LIGNE;
		$texte .= '<tr><td>Parent</td><td>'.	parent::__toString().'</td></tr>'.FP_LIGNE;
		$texte .= '<tr><td> this.table </td><td>'.$this->table.'</td></tr>'.FP_LIGNE;
		$texte .= '<tr><td> this.champ_id </td><td>'.$this->champ_id.'</td></tr>'.FP_LIGNE;
		$texte .= '<tr><td> this.valeur_id </td><td>'.$this->valeur_id.'</td></tr>'.FP_LIGNE;
		$texte .= '<tr><td> this.statut </td><td>'.$this->statut.'</td></tr>'.FP_LIGNE;
		if($this->statut):
			$texte .= '<tr><td> this._champs </td><td>' .FP_LIGNE;
			$texte .= '<table border="1" style="width:100%">' . FP_LIGNE;
			foreach($this->_champs as $clef => $valeur):
				$texte .= '<tr><td> ['.$clef.'] </td><td>'.$valeur.'</td></tr>'.FP_LIGNE;
			endforeach;
			$texte .= '</table>' . FP_LIGNE;	
			$texte .= '</td></tr>' .FP_LIGNE;
		endif;
		$texte .= '</table>' . FP_LIGNE;
		$texte .= '</div>' . FP_LIGNE;
		return $texte;
	}
	public function delete()
	{
		if($this->statut()):
			$sql = "DELETE FROM $this->table WHERE {$this->champ_id} = {$this->valeur_id} ";
			$flag = mysql_query($sql);
			$this->trace('['.__function__.'][SQL]['.$sql.']',mysql_error());
			return $flag;
		else:
			return false;
		endif;
	}
}
?>