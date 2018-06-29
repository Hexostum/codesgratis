<?php
class fp_session extends fp_objet
{
	public $session_id;
	protected $my_membre;
	
	public function __construct()
	{
		$this->cookie();
		
		session_start();
		$this->trace('SESSION START');
		$this->session_id = session_id();
		$this->trace('this.session_id = ' . $this->session_id);
		$this->cookie_envoyer ($this->session_id,60*60*24*30);
		
		$my_session = new fp_enregistrement('codesgratis_sessions' , sql_champ_texte ($this->session_id) , 'session_id' );
		if
			(
				$my_session->statut()
			)
		:
			$my_session->session_date = time();
			if(is_null($my_session->membre_id)):
				$my_membre = new fp_membre(NULL);
			else:
				$my_membre = new fp_membre($my_session->membre_id);
			endif;
			if
				(
					$my_membre->membre_existe()
				)
			:
				mysql_query('DELETE FROM codesgratis_sessions WHERE membre_id='.$my_session->membre_id.' AND session_id <> \'' . $this->session_id . '\'');
			else:
				$my_session->membre_id = NULL;
			endif;
		else:
			$sql = sql_insert
			(
				'codesgratis_sessions',
				array
				(
					'session_id' => sql_champ_texte($this->session_id),
					'session_ip' => sql_champ_texte($_SERVER['REMOTE_ADDR']),
					'session_date' => time(),
					'membre_id' => 'NULL',
					'session_referer' => sql_champ_texte(@$_SERVER['HTTP_REFERER']),
					'session_page'=> sql_champ_texte($_SERVER['PHP_SELF'])
						
				)
			);
			mysql_query($sql);
			$my_membre = new fp_membre(NULL);
		endif;
		$this->my_membre = $my_membre;
	}
	
	public function cookie()
	{
		if
			(
				isset($_COOKIE['session_id'])
			)
		:
			$this->trace('$_COOKIE[SESSION_ID] [OK]');
			$this->trace('SESSION ID ['.$_COOKIE['session_id'].']');
			session_id($_COOKIE['session_id']);
		else:
			$this->trace('$_COOKIE[SESSION_ID] [KO]');
		endif;
	}
	
	public function connectes_nombre($time)
	{
		return sql_result('SELECT COUNT(session_id) FROM codesgratis_sessions WHERE session_date > '. (time() - $time)  );
	}
	
	public function cookie_envoyer($session_id , $duree)
	{
		setcookie('session_id', $session_id , time()+$duree );		
		$this->trace('SET_COOKIE(session_id, '.$session_id.' , '.(time()+$duree).')');
	}
	
	public function my_membre()
	{
		return $this->my_membre;
	}
	
	public function purger($purge_time)
	{
		$time = time() - ($purge_time);
		$sql = 'DELETE FROM codesgratis_sessions WHERE membre_id is null AND session_date < '. $time;
		mysql_query($sql);
	}
}
?>