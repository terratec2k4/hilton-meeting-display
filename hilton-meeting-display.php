<?php
namespace HMD\Core;
defined('ABSPATH')||exit;
class Application{
    public function boot():void{
        if(is_admin()){
            add_action('admin_menu', function(){
                add_menu_page(
                    'Meeting Display',
                    'Meeting Display',
                    'manage_options',
                    'hmd-dashboard',
                    function(){ echo '<div class="wrap"><h1>Hilton Meeting Display RC3 Alpha</h1><p>Foundation instalada correctamente.</p></div>';},
                    'dashicons-calendar-alt'
                );
            });
        }
    }
}
