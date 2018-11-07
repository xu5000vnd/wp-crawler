<?php 
	global $wp;
	$current_url = home_url( add_query_arg( array(), $wp->request ) );
//var_dump($current_url);
?>
<div class="fb-like" data-href="<?php $current_url ?>" data-layout="standard" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
<div class="fb-comments" data-href="<?php $current_url ?>" data-width="100%" data-numposts="5"></div>