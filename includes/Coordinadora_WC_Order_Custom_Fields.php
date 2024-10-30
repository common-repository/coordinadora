<?php
class Coordinadora_WC_Order_Custom_Fields
{
    public static function init()
    {
        add_action('woocommerce_admin_order_data_after_order_details', __CLASS__ . '::add_tracking_number_field_in_order', 100, 1);
        add_action('woocommerce_process_shop_order_meta', __CLASS__ . '::save_tracking_number_field', 12, 2);
    }

    public static function add_tracking_number_field_in_order($order){
        
        $cm_tracking_number ="";
        $cm_tracking_url = "";
        
        $order_id = $order->get_id(); 
        // Obtener la orden utilizando el ID
        $order = wc_get_order($order_id);
        
        if ($order) {
            $order_meta_data = $order->get_meta_data();
            foreach ($order_meta_data as $meta) {
                if($meta->key === "_coordinadora_tracking_number"){
                   $cm_tracking_number = $meta->value;
                }
                if($meta->key === "_coordinadora_tracking_url"){
                   $cm_tracking_url= $meta->value;
                }
            }
        }

        woocommerce_wp_text_input(array(
            'id' => '_coordinadora_tracking_number',
            'label' => __( 'Guía Coordinadora', 'coordinadora' ),
            'value' => $cm_tracking_number,
            'wrapper_class' => 'form-field-wide'
        ));

        woocommerce_wp_text_input(array(
            'id' => '_coordinadora_tracking_url',
            'label' => __( 'Url seguimiento', 'coordinadora' ),
            'value' => $cm_tracking_url,
            'wrapper_class' => 'form-field-wide'
        ));
    }

    public static function save_tracking_number_field($post_id, $post)
    {
        // Obtiene la instancia de la orden
        $order = wc_get_order($post_id);

        // Define la clave y el nuevo valor del metadato que deseas actualizar
        $meta_key_coordinadora_tracking_number = '_coordinadora_tracking_number';
        $new_meta_value_coordinadora_tracking_number = $_POST['_coordinadora_tracking_number'];
        
        $meta_key_coordinadora_tracking_url = '_coordinadora_tracking_url';
        $new_meta_value_coordinadora_tracking_url = $_POST['_coordinadora_tracking_url'];
        
        // Actualiza el metadato en la orden
        $order->update_meta_data($meta_key_coordinadora_tracking_number, $new_meta_value_coordinadora_tracking_number);
        $order->update_meta_data($meta_key_coordinadora_tracking_url, $new_meta_value_coordinadora_tracking_url);
        
        $order->save();
    }
}
