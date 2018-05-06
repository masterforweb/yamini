<?php




function yamini2array($params, $method = '') {

	$params['id'] = COUNTER;
	$params['oauth_token'] = TOKEN;

	if ($method !== '')
		$method = '/'.$method;

	$url = 'https://api-metrika.yandex.ru/stat/v1/data'.$method.'?'.http_build_query($params);
	
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
	curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$metrika = curl_exec ($ch);
	curl_close($ch);
 

	return  json_decode($metrika, True);


}



function yamini_day($filter = '', $date1='yesterday', $date2='yesterday'){

	$params = [
		'metrics' => 'ym:s:pageviews,ym:s:visits,ym:s:users',
    	'dimensions'  => 'ym:s:date',
    	'date1'       =>  $date1,
    	'date2'       =>  $date2,
    	'sort'        => 'ym:s:date',
    	'group'		  => 'day'	
    ];


    if ($filter !== '')
    	$params['filters'] = $filter;

    $yesterday = yamini2array($params);

    if (is_array($yesterday))
    	$result = $yesterday['data'][0]['metrics'];
    else
    	$result = False;
   

    return $result;

}