<?php
/**
 * Plugin Name:     Fix User Meta List
 * Plugin URI:      https://github.com/fixonweb/fix-wp-shortcode-user-meta-list
 * Description:     Listagem de usuarios.
 * Author:          FIXONWEB
 * Author URI:      https://github.com/fixonweb
 * Text Domain:     fix-wp-shortcode-user-meta-list
 * Domain Path:     /languages
 * Version:         0.1.10
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


//--request
add_action( 'parse_request', 'fix158713_parse_request');
function fix158713_parse_request( &$wp ) {
	if($wp->request == 'start'){
		if(current_user_can('subscriber')) {
			wp_redirect( home_url().'/vendedor/vendas/listagem' );
			exit;
		}
		wp_redirect( home_url() );
		exit;
	}
}

add_shortcode("fix158713_niver", "fix158713_niver");
function fix158713_niver($atts, $content = null){

	ob_start();
	?>
	<div>
		<div>
			


			<div>
				<div><img src="https://d1587143191.shoppbox.com.br/wp-content/uploads/2020/04/Captura-de-tela-de-2020-04-17-17-09-21.png"></div>
				<div>
					<div>data</div>
					<div>niver</div>
				</div>
			</div>



		</div>
		<div>
			
		</div>
	</div>
	<?php

	return ob_get_clean();
}

add_shortcode("fix158713_user_list", "fix158713_user_list");
function fix158713_user_list($atts, $content = null){
	// $go = 0;
	// if(current_user_can('administrator')) $go = 1;
	// if(current_user_can('fix-administrativo')) $go = 1;
	// if(current_user_can('subscriber')) $go = 1;
	// if(!$go) return '';

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
		m6.meta_value departamento,
		m7.meta_value endereco
		
	from $wpdb->users u
	INNER JOIN $wpdb->usermeta m1 ON u.ID = m1.user_id and m1.meta_key = 'first_name' 
	INNER JOIN $wpdb->usermeta m2 ON u.ID = m2.user_id and m2.meta_key = 'last_name' 
	LEFT JOIN $wpdb->usermeta m3 ON u.ID = m3.user_id and m3.meta_key = 'fix_telefone' 
	LEFT JOIN $wpdb->usermeta m4 ON u.ID = m4.user_id and m4.meta_key = 'fix_ramal' 
	LEFT JOIN $wpdb->usermeta m5 ON u.ID = m5.user_id and m5.meta_key = 'fix_setor' 
	LEFT JOIN $wpdb->usermeta m6 ON u.ID = m6.user_id and m6.meta_key = 'fix_departamento' 
	LEFT JOIN $wpdb->usermeta m7 ON u.ID = m7.user_id and m7.meta_key = 'fix_endereco' 
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
				<th>Nome</th>
				<th>Sobrenome</th>
				<th>Fone</th>
				<th>Ramal</th>
				<th>Setor</th>
				<th>Departamento</th>
				<th>Endereco</th>
			</tr>
		<?php
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			?>
			<tr>
				<td><?=$row['first_name'] ?></td>
				<td><?=$row['last_name'] ?></td>
				<td><?=$row['fone'] ?></td>
				<td><?=$row['ramal'] ?></td>
				<td><?=$row['setor'] ?></td>
				<td><?=$row['departamento'] ?></td>
				<td><?=$row['endereco'] ?></td>
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












function wporg_usermeta_form_field_fix_nascimento( $user ){
    ?>
    <h3>Informações adicionais</h3>
    <table class="form-table">
        <tr>
            <th>
                <label for="fix_nascimento">Nascimento</label>
            </th>
            <td>
                <input type="date"
                       class="regular-text ltr"
                       id="fix_nascimento"
                       name="fix_nascimento"
                       value="<?= esc_attr( get_user_meta( $user->ID, 'fix_nascimento', true ) ) ?>"
                       title="Please use YYYY-MM-DD as the date format."
                       pattern="(19[0-9][0-9]|20[0-9][0-9])-(1[0-2]|0[1-9])-(3[01]|[21][0-9]|0[1-9])"
                       required>
                <p class="description"></p>
            </td>
        </tr>

        <tr>
            <th>
                <label for="fix_telefone">Telefone</label>
            </th>
            <td>
                <input type="text"
                       class="regular-text ltr"
                       id="fix_telefone"
                       name="fix_telefone"
                       value="<?= esc_attr( get_user_meta( $user->ID, 'fix_telefone', true ) ) ?>"
                       title=""
                       pattern=""
                       >
                <p class="description"></p>
            </td>
        </tr>

        <tr>
            <th>
                <label for="fix_ramal">Ramal</label>
            </th>
            <td>
                <input type="text"
                       class="regular-text ltr"
                       id="fix_ramal"
                       name="fix_ramal"
                       value="<?= esc_attr( get_user_meta( $user->ID, 'fix_ramal', true ) ) ?>"
                       title=""
                       pattern=""
                       >
                <p class="description"></p>
            </td>
        </tr>

        <tr>
            <th>
                <label for="fix_setor">Setor</label>
            </th>
            <td>
                <input type="text"
                       class="regular-text ltr"
                       id="fix_setor"
                       name="fix_setor"
                       value="<?= esc_attr( get_user_meta( $user->ID, 'fix_setor', true ) ) ?>"
                       title=""
                       pattern=""
                       >
                <p class="description"></p>
            </td>
        </tr>

        <tr>
            <th>
                <label for="fix_departamento">Departamento</label>
            </th>
            <td>
                <input type="text"
                       class="regular-text ltr"
                       id="fix_departamento"
                       name="fix_departamento"
                       value="<?= esc_attr( get_user_meta( $user->ID, 'fix_departamento', true ) ) ?>"
                       title=""
                       pattern=""
                       >
                <p class="description"></p>
            </td>
        </tr>


        <tr>
            <th>
                <label for="fix_endereco">Endereço</label>
            </th>
            <td>
                <input type="text"
                       class="regular-text ltr"
                       id="fix_endereco"
                       name="fix_endereco"
                       value="<?= esc_attr( get_user_meta( $user->ID, 'fix_endereco', true ) ) ?>"
                       title=""
                       pattern=""
                       >
                <p class="description"></p>
            </td>
        </tr>

    </table>
    <?php
}
  
add_action('show_user_profile', 'wporg_usermeta_form_field_fix_nascimento');
add_action('edit_user_profile','wporg_usermeta_form_field_fix_nascimento');



function wporg_usermeta_form_field_fix_nascimento_update( $user_id ) {
    if ( ! current_user_can( 'edit_user', $user_id ) ) { return false; }
    update_user_meta( $user_id, 'fix_nascimento',  $_POST['fix_nascimento'] );
    update_user_meta( $user_id, 'fix_telefone',  $_POST['fix_telefone'] );
    update_user_meta( $user_id, 'fix_ramal',  $_POST['fix_ramal'] );
    update_user_meta( $user_id, 'fix_setor',  $_POST['fix_setor'] );
    update_user_meta( $user_id, 'fix_departamento',  $_POST['fix_departamento'] );
    update_user_meta( $user_id, 'fix_endereco',  $_POST['fix_endereco'] );
    return true;
}

add_action('personal_options_update','wporg_usermeta_form_field_fix_nascimento_update');
add_action('edit_user_profile_update', 'wporg_usermeta_form_field_fix_nascimento_update');