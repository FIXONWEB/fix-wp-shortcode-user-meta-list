<?php
/**
 * Plugin Name:     Fix User Meta List
 * Plugin URI:      https://github.com/fixonweb/fix-wp-shortcode-user-meta-list
 * Description:     Listagem de usuarios.
 * Author:          FIXONWEB
 * Author URI:      https://github.com/fixonweb
 * Text Domain:     fix-wp-shortcode-user-meta-list
 * Domain Path:     /languages
 * Version:         0.1.4
 *
 * @package         Fix_Wp_Shortcode_User_Meta_List
 */

/* Código de identificação deste plugin fix158713 */

/* ATUALIZAÇÃO DESTE PLUGIN VIA GITHUB */
require 'plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/fixonweb/fix-wp-shortcode-user-meta-list',
	__FILE__, 
	'fix-wp-shortcode-user-meta-list/fix-wp-shortcode-user-meta-list'
);

add_shortcode("fix158713_user_list", "fix158713_user_list");
function fix158713_user_list($atts, $content = null){
	$go = 0;
	if(current_user_can('administrator')) $go = 1;
	if(current_user_can('fix-administrativo')) $go = 1;
	if(!$go) return '';

	extract(shortcode_atts(array(
		"name" => 'nada',
		"style" => ''
	), $atts));
	// global $post;
	// print_r($post);


	$args = array(
		'order'          => 'ASC',
		'orderby'        => 'user_login',
	);

	global $wpdb;

	$sql = "
	select 
		u.user_email, 
		m1.meta_value first_name, 
		m2.meta_value last_name,
		m3.meta_value fone,
		m4.meta_value ramal,
		m5.meta_value setor,
		m6.meta_value departamento
		
	from $wpdb->users u
	INNER JOIN $wpdb->usermeta m1 ON u.ID = m1.user_id and m1.meta_key = 'first_name' 
	INNER JOIN $wpdb->usermeta m2 ON u.ID = m2.user_id and m2.meta_key = 'last_name' 
	LEFT JOIN $wpdb->usermeta m3 ON u.ID = m3.user_id and m3.meta_key = 'fix_telefone' 
	LEFT JOIN $wpdb->usermeta m4 ON u.ID = m4.user_id and m4.meta_key = 'fix_ramal' 
	LEFT JOIN $wpdb->usermeta m5 ON u.ID = m5.user_id and m5.meta_key = 'fix_setor' 
	LEFT JOIN $wpdb->usermeta m6 ON u.ID = m6.user_id and m6.meta_key = 'fix_departamento' 
	";
	// echo $sql;

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$result = mysqli_query($mysqli, $sql);
	// print_r($result);

	ob_start();
	if($result){
		?>
		<table>
			<tr>
				<th>E-mail</th>
				<th>Nome</th>
				<th>Sobrenome</th>
				<th>Fone</th>
				<th>Ramal</th>
				<th>Setor</th>
				<th>Departamento</th>
			</tr>
		<?php
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			?>
			<tr>
				<td><?=$row['user_email'] ?></td>
				<td><?=$row['first_name'] ?></td>
				<td><?=$row['last_name'] ?></td>
				<td><?=$row['fone'] ?></td>
				<td><?=$row['ramal'] ?></td>
				<td><?=$row['setor'] ?></td>
				<td><?=$row['departamento'] ?></td>
			</tr>
			<?php
			// echo '<pre>';
			// print_r($row);
			// echo '</pre>';
		}

		?>
		</table>
		<?php


}
	


	return ob_get_clean();
}
