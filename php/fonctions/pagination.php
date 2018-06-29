<?php
function pagination($pages_nombre,$nompage='page')
{
	if($pages_nombre > 1):
		parse_str($_SERVER['QUERY_STRING'],$params);
		unset($params[$nompage]);	
		$str = array();
		$str[] = '<div class="lien_numero_pages">Page : ';
		$str[] = FP_TAB . '<ul class="menu_h">';
		for ($i = 1 ; $i <= $pages_nombre ; $i++):
			if( ($i-1) != @$_GET[$nompage]):
				if($i==1):
					$ces_params = $params;
				else:
					$ces_params = array_merge($params,array($nompage => $i-1));
				endif;
				$str[]= FP_TAB .FP_TAB .'<li><a href="'.$_SERVER['PHP_SELF'].'?'. http_build_query($ces_params) .'">' . $i . '</a></li>';
			else:
				$str[]= FP_TAB .FP_TAB .'<li>'. $i .'</li>';
			endif;
		endfor;
		$str[]= FP_TAB . '</ul>';
		$str[]= '</div>';
		return $str;
	else:
		return array();
	endif;
}
?>