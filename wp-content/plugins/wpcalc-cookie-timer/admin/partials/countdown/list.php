<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="metabox-holder">
<div class="meta-box-sortables">
  <table class="wp-list-table widefat fixed ">
    <thead>
      <tr>
	    <th><u><?php esc_attr_e("ID", "wow-marketing") ?></u></th>
        <th><u><?php esc_attr_e("Shortcode", "wow-marketing") ?></u></th>
        <th><u><?php esc_attr_e("Name", "wow-marketing") ?></u></th>        
        <th></th>
        <th></th>
		<th></th>
      </tr>
    </thead>
    <tbody>
      <?php
           if ($resultat) {
			   $i = 0;
			   foreach ($resultat as $key => $value) {				   
				   $id = $value->id;
				   $title = $value->title;        
                ?>
      <tr>
	    <td><?php echo "$id"; ?></td>
        <td><?php echo "[Countdown id=$id]"; ?></td>
        <td><?php echo $title; ?></td>       
        <td><u><a href="admin.php?page=wow-countdown-free&wow=add&act=update&id=<?php echo $id; ?>"><?php esc_attr_e("Edit", "wow-marketing") ?></a></u></td>
		<td><u><a href="admin.php?page=wow-countdown-free&info=del&did=<?php echo $id; ?>"><?php esc_attr_e("Delete", "wow-marketing") ?></a></u></td>
		<td><?php if($count<2){; ?><u><a href="admin.php?page=wow-countdown-free&wow=add&act=duplicate&id=<?php echo $id; ?>"><?php esc_attr_e("Duplicate", "wow-marketing") ?></a></u><?php } ?></td>        
      </tr>
      <?php
	  $i++;
	  if($i>1) break;
            }
        } else {
            ?>
      <tr>
        <td><?php esc_attr_e("No Record Found!", "wow-marketing") ?></td>
      <tr>
        <?php } ?>
    </tbody>
  </table>
</div>
</div>