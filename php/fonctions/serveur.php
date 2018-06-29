<?php
function page_courante($arg=array(),$replace=false)
{
	if(!$replace):
		parse_str(FP_ARG,$data);
		$data = array_merge($data,$arg);
	else:
		$data = $arg;
	endif;
	if(count($data)>0):
		return FP_PAGE . '?' . http_build_query($data);
	else:
		return FP_PAGE;
	endif;
}
function verif_variables_get (array $list)
{
	$flag = false;
	parse_str(FP_ARG,$data);
	$data2 = array();
	foreach ($data as $clef => $valeur):
		if(in_array($clef,$list,true)):
			$data2[$clef] = $valeur;
		endif;
	endforeach;
	if(count($data)!=count($data2)):
		if(count($data2)>0):
			redirect( FP_PAGE . '?' . http_build_query($data2) );
		else:
			redirect( FP_PAGE );
		endif;
	endif;
}
function redirect( $destination )
{
	header('Status: 301 Moved Permanently', false, 301);
	header('Location: ' . $destination);
}
?>