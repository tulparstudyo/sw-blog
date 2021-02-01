<?php
if(!function_exists('sw_get_posts')){
	function sw_get_posts($params=[]){
        $query = DB::table('sw_post');
        if(isset($params['type']) && !empty($params['type'])){
            $query->where('type', $params['type']);
        }
        if(isset($params['siteid']) && !empty($params['siteid'])){
            $query->where('siteid', $params['siteid']);
        } else{
            $query->where('siteid', '1.');
        }
        if(isset($params['status']) && !empty($params['status'])){
            $query->where('status', $params['status']);
        } else{
            $query->where('status', 1);
        }
        return json_decode(json_encode($query->get()->all()), 1) ;
    }
}
if(!function_exists('sw_get_post')){
	function sw_get_post($id){
		$ctx = \Aimeos\Shop\Facades\Shop::get('swordbros/swpost');
		$swpost = $ctx->getPost($id);
		return($swpost);
	}
}

