<?php global $s;?>
<li id="search">
  <label for="s"></label>   
    <form method="get" name="searchform" id="searchform" action="<?php echo esc_url( home_url() ); ?>/">
	<div>
<input type="text" value="Search" name="s" id="s" onfocus="if (this.value == 'Search') this.value = '';" onblur="if (this.value == '') this.value = 'Search';"/>
 </div>
</form>
</li>