<?php

#ロゴ画像＞設定
function theme_customize($wp_customize){

	$wp_customize->add_section( 'logo_section', array(
		'title' => 'ロゴ画像', //セクションのタイトル
		'priority' => 59, //セクションの位置
		'description' => 'ロゴ画像を使用する場合はアップロードしてください。画像を使用しない場合はタイトルがテキストで表示されます。', //セクションの説明
	));

	$wp_customize->add_setting( 'logo_url' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_url', array(
		'label' => 'ロゴ画像',//セッティングのタイトル
		'section' => 'logo_section', //セクションID
		'settings' => 'logo_url', //セッティングID
		'description' => 'ロゴ画像を設定してください。', //セッティングの説明
	)));
}
add_action( 'customize_register', 'theme_customize' );


#ロゴ画像＞取得
function get_the_logo_url(){
	return esc_url( get_theme_mod( 'logo_url' ) );
}


#ログイン画面ロゴ
function set_site_logo() {
  echo '<style type="text/css">.login h1 a {background-image: url('.get_theme_mod( 'logo_url' ).'); width: 320px; background-size: 320px;}</style>';
}
add_action('login_head', 'set_site_logo');


#ヘッダー背景画像
$defaults = array(
    'default-image'          => '',
    'random-default'         => false,
    'width'                  => 1140,
    'height'                 => 450,
    'flex-height'            => true,
    'flex-width'             => true,
    'default-text-color'     => '',
    'header-text'            => true,
    'uploads'                => true,
);
add_theme_support( 'custom-header', $defaults );


#ログイン画面ログURL
function custom_login_logo_url() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'custom_login_logo_url' );


#ログイン画面ロゴタイトル
function custom_login_logo_url_title() {
	return get_bloginfo('name');
}
add_filter( 'login_headertext', 'custom_login_logo_url_title' );


#ajax
function add_my_ajaxurl() {
?>
    <script>
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
    </script>
<?php
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );


#サイト管理者電話番号
function get_site_info(){
	$get_site_info['email'] = 'info@dggr.co.jp';
	$get_site_info['tel'] = '06-6626-9305';
	$get_site_info['wordpress'] = 'wordpress@iepedia.jp';
	return $get_site_info;
}


#ウィジット追加
function set_custom_widget() {
	register_sidebar( array(
		'name' => 'main media link widget',
		'id' => 'widget_main_media_link',
	));
	register_sidebar( array(
		'name' => 'site info widget',
		'id' => 'widget_site_info',
	));
	register_sidebar( array(
		'name' => 'footer media link widget',
		'id' => 'widget_footer_media_link',
	));
}
add_action( 'widgets_init', 'set_custom_widget' );


#言語一覧
function get_lang_list(){
	$lang['en'] = "English";
	$lang['ja'] = "日本語";
	$lang['zh'] = "中文";
	$lang['kr'] = "한국어";
	return $lang;
}


#翻訳＞DB直接取得＞リクエスト中にarticnet_echo_stringが使えないため
function get_field_articnet( $field, $lang=NULL ){
	global $wpdb;
	if( empty( $lang ) ) $lang = qtranxf_getLanguage();
	$lang_column = $lang."_text";
	$row = $wpdb->get_row("SELECT * FROM wp_articnet_translations WHERE string_id = '{$field}'");
	return $row->$lang_column;
}


function get_print_url(){
	global $post;
	return home_url('property_pdf/?url=').home_url('property_print/?property_id=').$post->ID;
}


function get_print_url_admin( $key ){
	global $post;
	return home_url( $key ).'/property_pdf/?url='.home_url( $key ).'/property_print/?property_id='.$post->ID;
}


#リファラ
function get_referer( $login = NULL ){
	global $post;
	$slug = $post->post_name;
	
	if( preg_match( '/'.$slug.'/', wp_get_referer() ) || wp_get_referer()==false ){
		$get_referer = get_home_url();
	}else{
		$get_referer = wp_get_referer();
	}
	if( $login==true ) $get_referer = add_query_arg('login', 'true', $get_referer);
	
	return $get_referer;
}


#ログイン表示用
function get_full_name(){
	$user = wp_get_current_user();
	$get_user_meta = get_user_meta( $user->ID, 'full_name' );
	if( !empty( $get_user_meta[0] ) ) {
		$full_name = $get_user_meta[0];
	}else{
		$full_name = $user->user_login;
	}
	return $full_name;
}


#お問い合わせフォーム＞表示データ取得
function get_inquiry_form(){
	$args = array(
		'taxonomy'=>'inquiry_form',
		'hide_empty'=>false
	);
	$get_terms = get_terms( $args );
	return $get_terms;
}


#お問い合わせ＞フォームタイトル
function get_inquiry_form_title(){
	$get_inquiry_form = get_inquiry_form();
	foreach( $get_inquiry_form as $key => $value ){
		$get_inquiry_form_title[$value->slug] = $value;
	}
	return $get_inquiry_form_title;
}


#お問い合わせ＞フォーム入力値
function get_inquiry_form_value(){
	$get_inquiry_form = get_inquiry_form();
	foreach( $get_inquiry_form as $key => $value ){
		if( $value->parent==0 ){
			$get_inquiry_form_value['parent'][$value->term_id] = $value;
		}else{
			$get_inquiry_form_value['child'][$value->parent][] = $value;
		}
	}
	return $get_inquiry_form_value;
}


#お問い合わせフォーム、プロフィール入力
function set_form_inquiry_input( $get_inquiry_form_title, $type, $keyname, $icon, $required = NULL, $value = NULL ){
	echo '<i class="material-icons prefix">'.$icon.'</i><input type="'.$type.'" name="'.$keyname.'" value="';
	if( !empty( $value ) ) echo $value;
	echo '" id="'.$keyname.'"';
	if( $type=='tel' ) echo ' pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" minlength="10" maxlength="13"';
	if( $required==true ) echo ' class="required required_input" required';
	echo '><label for="'.$keyname.'">'.$get_inquiry_form_title[$keyname]->name;
	if( $required==true ) echo '<span class="red-text">※</span>';
	echo '</label>';
}


#お問い合わせフォーム、プロフィールradio
function set_form_contact_radio( $get_inquiry_form_title, $key_name, $get_inquiry_form_value=NULL, $required=NULL, $checked=NULL ){
	foreach( $get_inquiry_form_value['child'][ $get_inquiry_form_title[ $key_name ]->term_id ] as $key => $value ){
		echo '<label><input type="radio" name="'.$key_name.'" value="'.$value->slug.'"';
		if( $required==true ) echo ' class="required required_radio"';
		if( $required==true && $key==0 ) echo ' required';
		if( !empty( $checked ) && $value->slug==$checked ) echo ' checked';
		echo '><span>'.$value->name.'</span></label>';
	}
}


#内覧予約メールフォームアクション
function set_action_inquiry_form() {
	
	if ( empty( $_REQUEST['set_nonce'] ) ) return;
	if ( !wp_verify_nonce( $_REQUEST['set_nonce'], 'set_nonce_action' ) ) return;
	
    #管理用
    if( !empty( $_REQUEST['form'] ) && $_REQUEST['form']=='information' ){
    	$form_title = "【物件リクエストのお問い合わせ】";
    	$body = "下記内容で物件リクエストのお問い合わせがありました。\n\n";
    }else{
 		$form_title = "【物件のお問い合わせ】";
 		$body = "下記内容で物件のお問い合わせがありました。\n\n";
    }
    
    $subject = $form_title.$_REQUEST['full_name']."さん";
	$body .= set_inquiry_form_mail_body( $_REQUEST, 'admin' );
	$headers = "From: 外国人のお部屋探し・リロケーション <wordpress@kotobuki1753.shop>";
	$admin_res = wp_mail( get_option('admin_email'), $subject, $body , $headers );
	
	#会員用
	if( $admin_res==true ){
	    $subject = get_field_articnet('thanks_mail_title').get_bloginfo('name');
	    $body = get_field_articnet('thanks_mail_body')."\n\n";
	    $body .= set_inquiry_form_mail_body( $_REQUEST, 'member' );
        $body .= "\n\n\n";
        $body .= get_field_articnet('thanks_mail_done');
        $body .= get_mail_body_signature();
		wp_mail( $_REQUEST['user_email'], $subject, $body , get_mail_member_send_header() );
		
		#会員登録処理
		if( !empty( $_REQUEST['user_pass'] ) ){
			$_REQUEST['inquiry_form'] = true;
			set_action_member_register( $_REQUEST );
			echo 'inquiry_regist_done';
			die();
		}else{
			echo 'done';
			die();
		}
	}
}
add_action( 'wp_ajax_set_action_inquiry_form', 'set_action_inquiry_form' );
add_action( 'wp_ajax_nopriv_set_action_inquiry_form', 'set_action_inquiry_form' );


#お問い合わせ完了メールの内容
function set_inquiry_form_mail_body( $request, $mode ){
	
	$get_inquiry_form_title = get_inquiry_form_title();
	$lang = ( $mode=='admin' ) ? 'ja' : qtranxf_getLanguage() ;
	$set_inquiry_form_keys = set_inquiry_form_keys();
	
	if( empty( $request['form'] ) ){
		unset( $set_inquiry_form_keys['information_you_want_to_know'] );
		$request['form'] = '';
		$body = get_inquiry_form_property( $get_inquiry_form_title, $request, $lang );
    }else{
    	$request['form'] .= '|';
    }
    
    foreach( $request as $key => $value ){
    	
    	if( in_array( $key, $set_inquiry_form_keys ) && !empty( $request[ $key ] ) ){
	    	
	    	if( $key=='message' ){
		        $body .= "【".get_inquiry_form_title_trans( $get_inquiry_form_title['message'], $lang )."】\n";
	            $body .= $value;
	            
	        }else if( $key=='desired_date' ){
		        $body .= "\n【".get_inquiry_form_title_trans( $get_inquiry_form_title['desired_date_of_visit'], $lang )."】\n";
		        $desired_time = ( !empty( $request['desired_time'] ) ) ? ' '.$request['desired_time'] : NULL ;
	            $body .= get_inquiry_form_title_trans( $get_inquiry_form_title['first_choice'], $lang ).' : '.$request['desired_date'].$desired_time."\n";
	            unset( $request['desired_time'] );
	            if( empty( $request['desired_date2'] ) ) $body .= "\n";
	            
	        }else if( $key=='desired_date2' ){
	        	$desired_time2 = ( !empty( $request['desired_time2'] ) ) ? ' '.$request['desired_time2'] : NULL ;
	        	$body .= get_inquiry_form_title_trans( $get_inquiry_form_title['second_choice'], $lang ).' : '.$request['desired_date2'].$desired_time2."\n";
	        	unset( $request['desired_time2'] );
	        	$body .= "\n";
	        	
	    	}else if( $key=='floor_plan' ){
	    		$lang_floor_plan = ( $qtranxf_getLanguage != 'ja' ) ? 'en' : 'ja' ;
		    	foreach( $request['floor_plan'] as $fk => $fv ){
			    	$floor_plan[] = get_inquiry_form_title_trans( $get_inquiry_form_title[ $fv ], $lang_floor_plan );
		    	}
	        	$body .= get_inquiry_form_title_trans( $get_inquiry_form_title[ $key ], $lang ).' : '.implode(', ', $floor_plan )."\n";
	        	
	        }else if( $key=='desired_size' ){
	        	$body .= get_inquiry_form_title_trans( $get_inquiry_form_title[ $key ], $lang ).' : '.$value.' '.get_inquiry_form_title_trans( $get_inquiry_form_title['m_or_more'], $lang )."\n";
	        	
	        }else if( preg_match('/'.$request['form'].'guarantor|speak_japanese|visa_type|current_residence|number_of_residents|have_pets/', $key) ){
	        	if( $request['have_pets']=='none' ) unset( $request['type'] );
	        	
	        	$body .= get_inquiry_form_title_trans( $get_inquiry_form_title[ $key ], $lang ).' : '.get_inquiry_form_title_trans( $get_inquiry_form_title[ $value ], $lang )."\n";
	        	
	        }else if( $key=='rent' ){
	        	$body .= get_inquiry_form_title_trans( $get_inquiry_form_title[ $key ], $lang ).' : '.number_format( $request["rent"] ).' '.get_inquiry_form_title_trans( $get_inquiry_form_title['yen_or_less'], $lang )."\n";
	        	
	        }else{
	        	
	        	$body .= get_inquiry_form_title_trans( $get_inquiry_form_title[ $key ], $lang ).' : '.$value."\n";
	        	if( !empty( $request['phone'] ) ){
	        		if( $key=='phone' ) $body .= "\n";
	        	}else{
	        		if( $key=='nationality' ){
	        			$body .= "\n";
	        		}
	        	}
	        	
				if( $key=='profession' ) $body .= "\n";
	        }
	    }
    }
    
	return $body;
}


function get_inquiry_form_property( $get_inquiry_form_title, $request, $lang ){
	$body = NULL;
    if( count($request['property_id'])==1 ){
		$get_post = get_post( $request['property_id'] );
		$property_name = apply_filters('translate_text', $get_post->post_title, $lang=$lang, $flags = 0);
	    $body .= get_inquiry_form_title_trans( $get_inquiry_form_title['property_name'], $lang )." : ".$property_name."\n";
	    $body .= "URL : ".get_permalink( $get_post->ID )."\n\n";
	}else{
		$args = array(
			'post__in' => $request['property_id'],
			'post_type' => 'property'
		);
		$get_posts = get_posts( $args );
		foreach( $get_posts as $key => $value ){
		    $body .= get_inquiry_form_title_trans( $get_inquiry_form_title['property_name'], $lang )." : ".$value->post_title."\n";
		    $body .= "URL : ".get_permalink( $value->ID )."\n";
		    $body .= "ーーーーーーーーーーーーーーーーーーーー\n\n";
		}
	}
	return $body;
}


function set_inquiry_form_keys(){
	
	$get_inquiry_form_title = get_inquiry_form_title();
	foreach( $get_inquiry_form_title as $key => $value ){
		if( $value->parent==0 ){
			$set_inquiry_form_title[] = $value->slug;
		}
	}
	
	$unset_keys[] = 'property_name';
	$unset_keys[] = 'mark_is_required';
	$unset_keys[] = 'desired_date_of_visit';
	$unset_keys[] = 'for_rent';
	$unset_keys[] = 'monthly';
	$unset_keys[] = 'real_estate_investment';
	$unset_keys[] = 'real_estate_purchase';
	$unset_keys[] = 'yes';
	
	$set_inquiry_form_keys = array_diff( $set_inquiry_form_title, $unset_keys );
	$set_inquiry_form_keys = array_values( $set_inquiry_form_keys );
	
	$array_add = array( 'desired_date', 'desired_date2' );
	array_splice( $set_inquiry_form_keys, 4, 0, $array_add );
	
	return $set_inquiry_form_keys;
}


#言語取得＞配列
function get_inquiry_form_title_trans( $get_inquiry_form_title_array, $lang ){
	return $get_inquiry_form_title_array->i18n_config['name']['ts'][$lang];
}

#言語取得＞テキスト
function get_inquiry_form_title_trans_text( $get_inquiry_form_title, $setlang ){
	return apply_filters('translate_text', $get_inquiry_form_title, $lang=$setlang, $flags = 0);
}


#会員登録処理
function set_action_member_register( $request = NULL ){
	
	if( !empty( $_REQUEST ) ) $request = $_REQUEST;
	if( empty( $request['set_nonce'] ) ) return;
	if( !wp_verify_nonce( $request['set_nonce'], 'set_nonce_action' ) ) return;
    if( !empty( $request['user_email'] ) && !empty( $request['user_pass'] ) ) {
    	
    	$user_login = strstr($request['user_email'], '@', true);
    	$user_pass = $request['user_pass'];
    	
		#メールアドレス登録チェック
		$user_email = $request['user_email'];
		$user_id = email_exists( $user_email );
		if( $user_id!==false && empty( $request['inquiry_form'] ) ){
	        echo 'error_email'; // WP_Error() の第二引数
	        die();
		}
	    #問題がなければユーザーを登録する処理を開始
	    $userdata = array(
	        'user_login' => $user_login,       //  ログイン名
	        'user_pass'  => $user_pass,       //  パスワード
	        'user_email' => $user_email,      //  メールアドレス
	    );
	    $user_id = wp_insert_user( $userdata );
	    
	    #ユーザーの作成に失敗した場合
	    if( is_wp_error( $user_id ) && empty( $request['inquiry_form'] ) ){
	        echo $user_id->get_error_code(); // WP_Error() の第一引数
	        echo $user_id->get_error_message(); // WP_Error() の第二引数
	        die();
	    }else{
	    	$set_member_regist_key = set_member_regist_key();
	    	unset( $set_member_regist_key['user_email'], $set_member_regist_key['user_pass'] );
	    	foreach( $request as $key => $value ){
	    		if( in_array( $key, $set_member_regist_key ) ){
			    	$set_user_meta = add_user_meta( $user_id, $key, $value );
			    }
			}
	    	
	    	if( $set_user_meta ){
		    	#登録完了メール、管理者、登録ユーザーへ送信
		    	$regist_comp_send = set_action_member_register_done( $request );
	    		
			    //登録完了後、そのままログインさせる（ 任意 ）
			    if( $regist_comp_send && empty( $request['inquiry_form'] ) ){
				    wp_set_auth_cookie( $user_id, false, is_ssl() );
				    //登録完了ページへ
				    echo 'register';
				    die();
				}
			}
	    }
	    return;
	}
}
add_action( 'wp_ajax_set_action_member_register', 'set_action_member_register' );
add_action( 'wp_ajax_nopriv_set_action_member_register', 'set_action_member_register' );


#会員登録完了メール送信
function set_action_member_register_done( $request ) {
	
    if( !empty( $request ) ) {
    	
    	#管理用
        $subject = "【会員登録のお知らせ】".$request['full_name']."さん";
        $body = get_member_profile_done_mail_body( $request, 'admin' );
        $wordpress_mail = get_site_info()['wordpress'];
        $headers = "From: 外国人のお部屋探し・リロケーション <{$wordpress_mail}>";
        $admin_res = wp_mail( get_option('admin_email'), $subject, $body , $headers );
        
        #会員用
        if( $admin_res==true ){
            $subject = "【".get_field_articnet('member_register_done')."】".get_bloginfo('name');
            $body = get_field_articnet('member_regist_thanks1')."\n\n";
            $body .= get_member_profile_done_mail_body( $request, 'member' );
	        $body .= "\n\n\n";
	        $body .= get_field_articnet('member_regist_thanks2');
	        $body .= get_mail_body_signature();
            return wp_mail( $request['user_email'], $subject, $body , get_mail_member_send_header() );
        }
        
    }
}


function set_member_regist_key(){
	$set_member_regist_key[] = 'full_name';
	$set_member_regist_key[] = 'user_email';
	$set_member_regist_key[] = 'user_pass';
	$set_member_regist_key = array_merge( $set_member_regist_key, set_user_meta() );
	return $set_member_regist_key;
}


#会員登録完了メールの内容
function get_member_profile_done_mail_body( $request, $mode ) {
	
	$lang = ( $mode=='admin' ) ? 'ja' : qtranxf_getLanguage() ;
	$get_inquiry_form_title = get_inquiry_form_title();
	
	$body = "【".get_field_articnet('registration_information', $lang)."】\n";
	
	foreach( set_member_regist_key() as $key => $value ){
		if( !empty( $request[ $value ] ) ){
			if( $value=='user_pass' ){
				if( $mode=='member' ) $body .= get_field_articnet('password')." : ".$request[ $value ]."\n";
			}else if( preg_match('/guarantor|speak_japanese|visa_type/', $value ) ){
				$body .= get_inquiry_form_title_trans( $get_inquiry_form_title[ $value ], $lang )." : ".get_inquiry_form_title_trans( $get_inquiry_form_title[ $request[ $value ] ], $lang )."\n";
			}else{
				if( $value=='nationality' ) $body .= "\n";
				$body .= get_inquiry_form_title_trans( $get_inquiry_form_title[ $value ], $lang )." : ".$request[ $value ]."\n";
			}
		}
	}
	return $body;
}


function get_mail_member_send_header(){
	return "From: ".get_bloginfo('name')." <".get_site_info()['wordpress'].">";
}


function get_mail_body_signature(){
	$body = "\n\n\n\n";
    $body .= get_field_articnet('company_name')."\n";
    $body .= get_bloginfo('name')."\n";
    $body .= get_bloginfo('description')."\n";
    $body .= get_home_url()."\n";
    $body .= get_option('admin_email')."\n";
    $body .= '+81-'.get_site_info()['tel'];
    return $body;
}


#ユーザーメタ
function get_my_user_meta(){
	$user = wp_get_current_user();
	$get_user_meta = get_user_meta( $user->ID );
	$set_user_meta = set_user_meta();
	foreach( $set_user_meta as $key => $value ){
		if( !empty( $get_user_meta[ $value ] ) ){
			$user_meta[$value] = $get_user_meta[ $value ][0];
		}else{
			$user_meta[$value] = '';
		}
	}
	return $user_meta;
}


function set_user_meta(){
	$set_user_meta[] = 'nationality';
	$set_user_meta[] = 'phone';
	$set_user_meta[] = 'guarantor';
	$set_user_meta[] = 'speak_japanese';
	$set_user_meta[] = 'visa_type';
	$set_user_meta[] = 'current_residence';
	$set_user_meta[] = 'profession';
	$set_user_meta[] = 'have_pets';
	$set_user_meta[] = 'type';
	return $set_user_meta;
}


#プロフィール更新
function set_action_profile(){
	if ( empty( $_REQUEST['set_nonce'] ) ) return;
	if ( !wp_verify_nonce( $_REQUEST['set_nonce'], 'set_nonce_action' ) ) return;
	
	$user = wp_get_current_user();
	
	#お名前更新
	if( !empty( $_REQUEST['full_name'] ) && $user->full_name != $_REQUEST['full_name'] ){
		$full_name = $_REQUEST['full_name'];
		update_user_meta( $user->ID, 'full_name', sanitize_text_field( $full_name ) );
		$user->display_name = $full_name;
		$udpate_flg[] = wp_update_user( $user );
		
	}
	
	#メールアドレス更新
	if( !empty( $_REQUEST['user_email'] ) && $user->user_email != $_REQUEST['user_email'] ){
		#メールアドレス登録チェック
		$user_email = $_REQUEST['user_email'];
		$user_id = email_exists( $user_email );
		if ( $user_id !== false ) {
		    echo 'error_email';
		    die();
		}else{
			$user->user_email = $user_email;
			$user->user_login = mb_strstr( $user_email, '@', true);
			$user->user_nicename = $user->user_login;
			$udpate_flg[] = wp_update_user( $user );
			
		}
	}else{
		$user_email = $user->user_email;
	}
	
	foreach( $_REQUEST as $key => $value ){
		if( !empty( $_REQUEST[ $key ] ) && in_array( $key, set_user_meta() ) ){
			if( !empty( get_user_meta( $user->ID, $key ) ) && $_REQUEST[ $key ]!=get_user_meta( $user->ID, $key ) ){
				$udpate_flg[] = update_user_meta( $user->ID, $key, $value );
			}else{
				$udpate_flg[] = add_user_meta( $user->ID, $key, $value );
			}
		}
	}
	
	if( !empty( array_filter( $udpate_flg ) ) ){
		
        $subject = "【".get_field_articnet('update_profile_done')."】".get_bloginfo('name');
        
        $body = get_field_articnet('update_profile_done')."\n\n";
        $body .= get_member_profile_done_mail_body( $_REQUEST, 'member' );
        $body .= "\n\n\n";
        $body .= get_field_articnet('member_regist_thanks2');
        $body .= get_mail_body_signature();
        
        wp_mail( $user_email, $subject, $body , get_mail_member_send_header() );
	}
	echo 'update';
	die();
}
add_action( 'wp_ajax_set_action_profile', 'set_action_profile' );
add_action( 'wp_ajax_nopriv_set_action_profile', 'set_action_profile' );


#パスワード更新
function set_action_password(){
	if ( empty( $_REQUEST['set_nonce'] ) ) return;
	if ( !wp_verify_nonce( $_REQUEST['set_nonce'], 'set_nonce_action' ) ) return;
	$user = wp_get_current_user();
	if( !empty( $_REQUEST['user_pass'] ) ){
		$user_pass = $_REQUEST['user_pass'];
		$user->user_pass = $user_pass;
		$update_user_pass = wp_update_user( $user );
	}
	
	if( $update_user_pass ){
        $to = $user->user_email;
        $subject = "【".get_field_articnet('password_setting_done')."】".get_bloginfo('name');
        
        $body = get_field_articnet('password_setting_done')."\n\n";
        $body .= "【".get_field_articnet('registration_information')."】\n";
        $body .= get_field_articnet('password')." : ".$user_pass."\n";
        $body .= "\n\n\n";
        $body .= get_field_articnet('member_regist_thanks2');
        $body .= get_mail_body_signature();
        
        wp_mail( $to, $subject, $body , get_mail_member_send_header() );
	}
	echo 'update';
}
add_action( 'wp_ajax_set_action_password', 'set_action_password' );
add_action( 'wp_ajax_nopriv_set_action_password', 'set_action_password' );


#ログインチェック
function set_action_login_check(){
	
	if ( empty( $_REQUEST['set_nonce'] ) ) return;
	if ( !wp_verify_nonce( $_REQUEST['set_nonce'], 'set_nonce_action' ) ) return;
    if ( !empty( $_REQUEST['user_email'] ) && !empty( $_REQUEST['user_pass'] ) ) {
    	
	    // ログイン認証
	    $creds = array(
	        'user_login' => $_REQUEST['user_email'],
	        'user_password' => $_REQUEST['user_pass'],
	    );
	    $user = wp_signon( $creds );
		
	    //ログイン失敗時の処理
	    $response = null;
	    if ( is_wp_error( $user ) ) {
	    	$get_error_message = $user->get_error_message();
			$url = '/reset_password';
			$response = preg_replace("/(<a href=\").*?(\".*?>)/", "$1$url$2", $get_error_message);
	    }else{
		    //ログイン成功時の処理
		    $response = 'login';
	    }
	    echo json_encode( $response );
	    die();
	}
}
add_action( 'wp_ajax_set_action_login_check', 'set_action_login_check' );
add_action( 'wp_ajax_nopriv_set_action_login_check', 'set_action_login_check' );


#お気に入り追加
function set_action_add_favorites(){
	
	global $wpdb;
	global $post;
	$user = wp_get_current_user();
	
	$dbname = "wp_members_favorite";
	
	if( !empty( $_REQUEST['action'] ) ){
		
		if( $_REQUEST['mode'] == 'insert' ){
			$set_key[] = 'user_id';
			$set_key[] = 'property_id';
			$set_value[] = $user->ID;
			$set_value[] = $_REQUEST['property_id'];
			
			$insert_key = implode( ',', $set_key );
			$place_holders[] = '(%d, %d)';
			$sql = 'INSERT INTO '.$dbname.' ('.$insert_key.') VALUES '.join(',', $place_holders);
			if( $wpdb->query( $wpdb->prepare( $sql, $set_value ) ) ) {
				echo 'add_favorites';
			}else{
				echo 'error';
			}
		}else if( $_REQUEST['mode']=='delete' ){
			$sql = 'DELETE FROM '.$dbname.' WHERE user_id = '.$user->ID.' AND property_id = '.$_REQUEST['property_id'];
			if( $wpdb->query( $wpdb->prepare( $sql ) ) ) {
				echo 'delete_favorites';
			}else{
				echo 'error';
			}
		}
	}
	die();
}
add_action( 'wp_ajax_set_action_add_favorites', 'set_action_add_favorites' );
add_action( 'wp_ajax_nopriv_set_action_add_favorites', 'set_action_add_favorites' );


#お気に入り一覧
function get_favorite(){
	global $wpdb;
	$user = wp_get_current_user();
	
	$sql = "SELECT * FROM wp_members_favorite 
	LEFT JOIN wp_posts ON wp_members_favorite.property_id = wp_posts.ID 
	WHERE wp_members_favorite.user_id = ".$user->ID;
	
	$get_results = $wpdb->get_results( $sql, OBJECT);
	return $get_results;
}


#お気に入りチェック
function checkFavorite(){
	global $wpdb;
	global $post;
	$user = wp_get_current_user();
	$get_row = $wpdb->get_row("SELECT * FROM wp_members_favorite WHERE user_id = ".$user->ID." AND property_id = ".$post->ID, OBJECT);
	if( !empty( $get_row ) ){
		return true;
	}else{
		return false;
	}
}


#お気に入り削除
function set_action_delete_favorite(){
	
	global $wpdb;
	global $post;
	$user = wp_get_current_user();
	
	$dbname = "wp_members_favorite";
	
	if( count($_REQUEST['property_id'])==1 ){
		$where = 'property_id = '.$_REQUEST['property_id'][0];
	}else{
		$where = 'property_id IN ('.implode(',', $_REQUEST['property_id'] ).')';
	}
	$sql = 'DELETE FROM '.$dbname.' WHERE user_id = '.$user->ID.' AND '.$where;
	
	if( $wpdb->query( $wpdb->prepare( $sql ) ) ) {
		echo 'delete_favorites';
	}
	die();
}
add_action( 'wp_ajax_set_action_delete_favorite', 'set_action_delete_favorite' );
add_action( 'wp_ajax_nopriv_set_action_delete_favorite', 'set_action_delete_favorite' );


#パスワードリセット
function set_action_reset_password(){
	if ( empty( $_REQUEST['set_nonce'] ) ) return;
	if ( !wp_verify_nonce( $_REQUEST['set_nonce'], 'set_nonce_action' ) ) return;
	#メールアドレス登録チェック
	$user_email = $_REQUEST['user_email'];
	$user_id = email_exists( $user_email );
	if ( $user_id == false ) {
	    echo 'error_email';
	    die();
	}else{
		$user = get_user_by( 'email', $user_email );
		$user->user_pass = wp_generate_password( 8, true, true );
		$update_user_pass = wp_update_user( $user );
	}
	
	if( $update_user_pass ){
        $to = $user->user_email;
        $subject = "【".get_field_articnet('password_reset_done')."】".get_bloginfo('name');
        
        $body = get_field_articnet('please_reset_the_password')."\n\n";
        $body .= "【".get_field_articnet('login_password')."】\n";
        $body .= $user->user_pass."\n";
        $body .= "\n\n\n";
        $body .= get_field_articnet('member_regist_thanks2');
        $body .= get_mail_body_signature();
        
        wp_mail( $to, $subject, $body , get_mail_member_send_header() );
	}
	echo 'reset';
	die();
}
add_action( 'wp_ajax_set_action_reset_password', 'set_action_reset_password' );
add_action( 'wp_ajax_nopriv_set_action_reset_password', 'set_action_reset_password' );


//ショートコード＞表示タグ設定
function set_titlebar_shortcode( $atts, $content = null ) {
  return '<div class="titlebar">' . $content . '</div>';
}
add_shortcode( 'titlebar', 'set_titlebar_shortcode' );


function set_action_withdrawal(){
	if ( empty( $_REQUEST['set_nonce'] ) || empty( $_REQUEST['withdrawal'] ) ) return;
	if ( !wp_verify_nonce( $_REQUEST['set_nonce'], 'set_nonce_action' ) ) return;
	
	global $wpdb;
	$user = wp_get_current_user();
	
	if( !empty( get_favorite() ) ){
		$sql = 'DELETE FROM wp_members_favorite WHERE user_id = '.$user->ID;
		$wpdb->query( $wpdb->prepare($sql) );
	}
	
	if( $get_my_user_meta = get_my_user_meta() ){
		foreach( $get_my_user_meta as $key => $value ){
			delete_user_meta( $user->ID, $key );
		}
	}
	
    $to = $user->user_email;
    $subject = "【".get_field_articnet('withdraw_complete')."】".get_bloginfo('name');
    
    $body = get_field_articnet('withdraw_complete')."\n";
    $body .= get_field_articnet('withdraw_thanks')."\n";
    $body .= get_mail_body_signature();
    
    wp_mail( $to, $subject, $body , get_mail_member_send_header() );
	
	require_once(ABSPATH.'wp-admin/includes/user.php' );
	wp_delete_user( $user->ID );
	
	echo 'complete';
	die();
}
add_action( 'wp_ajax_set_action_withdrawal', 'set_action_withdrawal' );
add_action( 'wp_ajax_nopriv_set_action_withdrawal', 'set_action_withdrawal' );


?>