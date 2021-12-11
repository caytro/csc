<?php
/**
 * Plugin Name: 			Formulaire de contact Lineac
 * Description:       	Widget Formulaire de contact et envoi par mail
 * Version:           	0.0.1
 * Author:            	lin&ac
 * Text Domain:       	formulaire-contact-lineac
 **/
 
 /**
 * Functions
 **/
 
 /**
 * Vérifie que le plugin est bien chargé par le cor de wp
 **/
 
 defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

 
 /** 
 * Création de la table dans laquelle seront stockés les messages
 **/
 
register_activation_hook( __FILE__, 'lineac_plugin_form_c2lbab' );
 
 function lineac_plugin_form_c2lbab () {
   global $wpdb;

   $table_name = $wpdb->prefix . "lineac_form_contact_c2lbab"; 
   $charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	  nom varchar(64) DEFAULT 'Nom' NOT NULL,
	  prenom varchar(64) DEFAULT 'Prenom' NOT NULL,
	  email varchar(64) DEFAULT 'email' NOT NULL,
	  sujet varchar(256) DEFAULT 'Sujet' NOT NULL,
	  message varchar(2048) DEFAULT 'Message' NOT NULL,
	  PRIMARY KEY  (id)
	) $charset_collate;";
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}



 
 /**
  * Enregistrement du plugin comme widget
  **/ 
 
 add_action("widgets_init",'lineac_widget_form_c2lbab_init');
 
 function lineac_widget_form_c2lbab_init(){
 		register_widget('Lineac_form_c2lbab_widget');
 }
 
 /**
 * insertion de la feuille de style
 **/
 
 wp_enqueue_style( 'lineac_form_c2lbab', plugin_dir_url( __FILE__ ) . 'public/css/lineac-form-contact-style.css');
 	
 
 
 class Lineac_form_c2lbab_widget extends WP_Widget{

	
	public function __construct() {
		parent::__construct('lineac_form_c2lbab_widget','Formulaire de contact Lineac',array('description'=>"Formulaire de contact et d'inscription aux stages et évènements"));
		$this->plugin_name="Formulaire de contact";
		//add_action( 'wp_loaded', 'your callback function' );
	}
	
	public function widget($args,$instance){
		
		extract( $args );
		$options = get_option( 'lineac_form_c2lbab_widget' );
		
		$title = ! empty( $instance['title'] ) ? $instance['title'] : $this->get_widget_html_title();
		echo $before_widget;
		echo $before_title . $title  . $after_title;
		if (isset($_POST["submitLineacFormContact"])){
			$this->envoiMail($instance);
			echo '<p>Merci '.$_POST["prenom"].' '.$_POST["nom"] . ' !</p><p>Votre message est en chemin...</p>';
			$this->storeMessage();
		}

		echo $this->get_widget_public_html_content();
		echo $after_widget;
		
	}
	
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		$dest_mail_adress = ! empty( $instance['dest_mail_adress'] ) ? $instance['dest_mail_adress'] : esc_html__( 'snadaud@free.fr', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		<label for="<?php echo esc_attr( $this->get_field_id( 'dest_mail_adress' ) ); ?>"><?php esc_attr_e( 'Adresse mail des destinataires:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'dest_mail_adress' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dest_mail_adress' ) ); ?>" type="text" value="<?php echo esc_attr( $dest_mail_adress ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['dest_mail_adress'] = ( ! empty( $new_instance['dest_mail_adress'] ) ) ? sanitize_text_field( $new_instance['dest_mail_adress'] ) : '';

		return $instance;
	}
	
	private function envoiMail($instance){
		
		//$to="snadaud@free.fr,magalune@protonmail.com";
		//$to="snadaud@free.fr";
		$to=$instance['dest_mail_adress'];
		$email=(isset($_POST["email"]) && is_email($_POST["email"])?$_POST["email"]:'adresse.invalide@email.com');
		$from=$_POST["prenom"].' '.$_POST["nom"].' <'.$email.'>';
		$subject = "Message du site ".get_bloginfo("name")." : ".$_POST["sujet"];
		$headers= array("From: ".$from);
		$headers[]='Content-Type: text/html; charset=utf-8';
		$message=get_bloginfo("name")."<br>";
		$message.=stripslashes("Message envoyé par ".$_POST["prenom"].' '.$_POST["nom"])." :<br><br>";
		$message.=stripslashes($_POST["message"]);
		wp_mail( $to, $subject, $message, $headers );
	} 
	
	function storeMessage(){
		global $wpdb;
		$table=$wpdb->prefix . "lineac_form_contact_c2lbab"; 
		$data=array();
		$data["prenom"]=$_POST["prenom"];
		$data["nom"]=$_POST["nom"];
		$email=(isset($_POST["email"]) && is_email($_POST["email"])?$_POST["email"]:'adresse.invalide@email.com');
		$data["sujet"]=$_POST["sujet"];
		$data["message"]=$_POST["message"];
		$data["time"]=current_time('mysql');
		
		$result=$wpdb->insert( $table, $data);
		echo "<p>Insertion dans la db : ".($result?"Réussite":"Echec")."</p>";
		}
	
	private function get_widget_public_html_content(){

/*		
		$content =
			"<div id='lineacFormContactWidget' class='lineacFormContacLabel'>\n".

				"<form method='POST' action=''".home_url()."/".get_page_uri()."'>\n".
					"<div class='form-group'>\n".
					"<input type='hidden' name='pageRetour' value='".home_url()."/".get_page_uri()."'/>\n".
					"<label for='prenom' >Prénom : </label><input type='text' name='prenom' placeholder='Prénom' />\n".
					"<label for='nom'>Nom : </label><input type='text' name='nom' placeholder='Nom'/>\n".
					"<label for='email'>Votre adresse mail : </label><input type='text' name='email' placeholder='Email'/>\n".
					"<label for='sujet'>Sujet : </label><input type='text' name='sujet' placeholder='Sujet' />\n".
					"<label for='message' >Message : </label><textarea name='message' rows='10' placeholder='Votre Message' ></textarea>\n".
					"<input type='submit' name='submitLineacFormContact' />\n".
					"</div>\n".
				"</form>\n".
			"</div>\n";
			
*/
		$content =
			"<div id='lineacFormContactWidget' class='lineacFormContacLabel'>\n".

				"<form method='POST' action=''".home_url()."/".get_page_uri()."'>\n".
					"<div class='form-group'>\n".
					"<input type='hidden' name='pageRetour' value='".home_url()."/".get_page_uri()."'/>\n".
					"<input type='text' name='prenom' placeholder='Prénom' />\n".
					"<input type='text' name='nom' placeholder='Nom'/>\n".
					"<input type='text' name='email' placeholder='Email'/>\n".
					"<input type='text' name='sujet' placeholder='Sujet' />\n".
					"<textarea name='message' rows='10' placeholder='Votre Message' ></textarea>\n".
					"<input type='submit' name='submitLineacFormContact' />\n".
					"</div>\n".
				"</form>\n".
			"</div>\n";
		return $content;
	}
	private function get_widget_html_title(){
		return "Envoyez-nous un message";
	}
}