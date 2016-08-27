<?php

/**
 * @file
 * Wrapper class for the Urbano web service.
 */

// define('COMMERCE_URBANO_URL_RATE', 'https://www.urbano.com.ar/urbano3/wbs/consulta_tarifa/');
// define('COMMERCE_URBANO_URL_PICKUP_SANDBOX', 'http://200.0.230.242/urbano3/wbs/carga_cliente/');
// define('COMMERCE_URBANO_URL_PICKUP_LIVE', 'https://www.urbano.com.ar/webservice/carga_cliente/');

define('COMMERCE_SERVI_URL','http://web.servientrega.com:8081/GeneracionGuias.asmx?WSDL');
/**
 * @file
 * Wrapper class for the Urbano service.
 */

/**
 * Urbano connector using the drupal stored credentials.
 */
class CommerceServientregaConnector {
  private $client;
  private $key;
  private $invoice_code;
  private $name;

  public function __construct() {
    $client = variable_get('commerce_servientrega_client', FALSE);
    $key = variable_get('commerce_servientrega_key', FALSE);
    $invoice_code = variable_get('commerce_servientrega_invoice_code', FALSE);
    $name = variable_get('commerce_servientrega_name_code', FALSE);
    if (!$client || !$key) {
      throw new CommerceServientregaException(t('Servientrega credentials not set.'));
    }

    $this->client = $client;
    $this->key = $key;
    $this->invoice_code = $invoice_code;
    $this->name = $name;
  }

  /**
   * Returns the URL to the specified Urbano's API server.
   *
   * @return string
   *   The URL to use to submit requests to the Urbano's API server.
   */
  private function getServer() {
    // $server = variable_get('commerce_urbano_server', 'sandbox');

    // switch ($server) {
    //   case 'sandbox':
    //     return COMMERCE_URBANO_URL_PICKUP_SANDBOX;

    //   case 'live':
    //     return COMMERCE_URBANO_URL_PICKUP_LIVE;
    // }
    return COMMERCE_SERVI_URL;
  }

  public function getPremierShipment($volume,$weight,$price,$currency_code,$city,$department,$proveedor){

    $factor_premier = 222;
    $arr_trayecto = array("TRAYECTO ESPECIAL"=>array("3-kilos"=>'22100',"adicional"=>'5700'),
                          "NACIONAL"=>array("3-kilos"=>'9400',"adicional"=>'2600'),
                          "ZONAL"=>array("3-kilos"=>'6300',"adicional"=>'2100'),
                          "URBANO"=>array("3-kilos"=>'5200',"adicional"=>'1800'),
    );

    $volume_premier = $volume * $factor_premier;

    $shipment_price = 0;
// error_log(print_r($weight,true),3,"/tmp/serv-vars.log");
    // $weight = (float)$weight;
    $weight = $weight['und'][0]['value']/1000;

    if ($volume_premier<$weight) {
      # code...
      $volume_premier=$weight;

    }
    //se redondea al valor mas alto
    $volume_premier=round($volume_premier,0, PHP_ROUND_HALF_EVEN);

    $arr_origen = $this->getCitiesFromCodes($proveedor['locality'],$proveedor['administrative_area'],$proveedor['country']);

    $origen_city=strtoupper($arr_origen['city']);
    $destino_city=strtoupper($city);
    $origen_dep=strtoupper($arr_origen['department']);
    $destino_dep=strtoupper($department);

    $sql = "SELECT * FROM {servientrega_premier} WHERE ciudad_destino like '$destino_city'
            and departamento_destino like '$destino_dep' and ciudad_origen like '$origen_city' LIMIT 1";

    $result = db_query($sql);
    
    if ($result) {
      while ($row = $result->fetchAssoc()) {
        // Do something with:
        //    $row['name']
        $trayecto = $row['tipo_trayecto'];
        //error_log(print_r($row,true),3,"/tmp/serv-query.log");
      }
    }else{

      return -99;
    }

    if ($volume_premier>3) {
      # code...
      $shipment_price = $arr_trayecto[$trayecto]['3-kilos'] + ($volume_premier - 3)*$arr_trayecto[$trayecto]['adicional'];      

    }else{
      $shipment_price = $arr_trayecto[$trayecto]['3-kilos'];
    }

    //Manejo del 0.5% o 300
    $manejo = (($price*0.005)<300) ? 300 : ($price*0.005);

    //error_log("manejo:$manejo + envio:$shipment_price \n",3,"/tmp/serv-price.log");

    return $shipment_price + $manejo;

    // if ($result = $query->execute()) {
    //   error_log(print_r($result,true),3,"/tmp/serv-query.log");
    // }


  }


  public function getCorpShipment($volume,$weight,$price,$currency_code,$city,$department,$proveedor){

    $factor_premier = 400;

    $volume_premier = $volume * $factor_premier;

    $shipment_price = 0;

    // $weight = (float)$weight;
    $weight = $weight['und'][0]['value']/1000;

    if ($volume_premier<$weight) {
      # code...
      $volume_premier=$weight;

    }
    //se redondea al valor mas alto
    $volume_premier=round($volume_premier,0, PHP_ROUND_HALF_EVEN);

    $arr_origen = $this->getCitiesFromCodes($proveedor['locality'],$proveedor['administrative_area'],$proveedor['country']);

    $origen_city=strtoupper($arr_origen['city']);
    $destino_city=strtoupper($city);
    $origen_dep=strtoupper($arr_origen['department']);
    $destino_dep=strtoupper($department);

    $sql = "SELECT * FROM {servientrega_cun_corp} WHERE ciudad_destino like '$destino_city'
            and departamento_destino like '$destino_dep' and ciudad_origen like '$origen_city' LIMIT 1";

    $result = db_query($sql);
    
    if ($result) {
      while ($row = $result->fetchAssoc()) {
        // Do something with:
        //    $row['name']
        $valor_kilo = $row['valor_kilo'];
        //error_log(print_r($row,true),3,"/tmp/serv-query.log");
      }
    }else{

      return -99;
    }

    $shipment_price = (($volume_premier)*$valor_kilo) > 14500 ? (($volume_premier)*$valor_kilo) : 14500;      
    //manejo del 1% o 5700
    $manejo = (($price*0.01)<5700) ? 5700 : ($price*0.01);
 
    //error_log("Corp-manejo:$manejo + Corp-envio:$shipment_price \n",3,"/tmp/serv-price.log");

    return $shipment_price + $manejo;

  }

  public function getShipmentDetails($order){

    $order_wrapper = entity_metadata_wrapper('commerce_order', $order);
    //error_log(print_r($order_wrapper,true),3,"/tmp/serv-order.log");

    $shipping =  $order_wrapper->commerce_customer_shipping->value();
    $country_code = $shipping->commerce_customer_address['und'][0]['country'];
    $department_code = $shipping->commerce_customer_address['und'][0]['administrative_area'];
    $city_code = $shipping->commerce_customer_address['und'][0]['locality'];
    $address = $shipping->commerce_customer_address['und'][0]['thoroughfare'];
    $email = $shipping->field_email_address['und'][0]['value'];
    $name = $shipping->commerce_customer_address['und'][0]['name_line'];
    
    // $department_fullname = _addressfield_tokens_state($country_code, $department_code);
    //error_log(print_r($shipping,true),3,"/tmp/serv-order.log");

    $arr_shipment_detail = $this->getCitiesFromCodes($city_code,$department_code,$country_code);
    $arr_shipment_detail['address']=$address;
    $arr_shipment_detail['email']=$email;
    $arr_shipment_detail['name']=$name;

    return $arr_shipment_detail;
  }

  public function getCitiesFromCodes($city_code,$department_code,$country_code){
    
    if ($country_code=='CO') {
      # code...
      module_load_include('inc','addressfield_co', 'plugins/format/addressfield_co');

      $states = addressfield_co_states_list();
      $cities = addressfield_co_cities_list($department_code);
      $city = $cities[$city_code];
      $department = $states[$department_code];
    
    }else{

      module_load_include('inc', 'addressfield', 'addressfield.administrative_areas');
      $administrative_areas = addressfield_get_administrative_areas($country_code);
      $department = $administrative_areas[$department_code];

    }

    return array('city'=>$city,
                 'department'=>$department,
                 );
  }



  /**
   * Rates the shipping of a Commerce Order.
   */
  public function rateShipping($order) {
    // $order_wrapper = entity_metadata_wrapper('commerce_order', $order);

    $products = $this->extractProducts($order);
    $shipment_details = $this->getShipmentDetails($order);

    //error_log(print_r($shipment_details,true),3,"/tmp/serv-prod.log");
    $global_premier = 0;
    $global_corp = 0;
    foreach ($products as $key => $product) {

      $volume = (($product['field_width']['und'][0]['value'])/100) * (($product['field_height']['und'][0]['value'])/100) * (($product['field_length']['und'][0]['value'])/100);
      
      $ship_premier = $this ->getPremierShipment($volume,$product['field_weight'],$product['price'],$product['currency_code'],$shipment_details['city'],$shipment_details['department'],$product['proveedor']);
      $global_premier += $ship_premier;

      $ship_corp = $this ->getCorpShipment($volume,$product['field_weight'],$product['price'],$product['currency_code'],$shipment_details['city'],$shipment_details['department'],$product['proveedor']);
      $global_corp += $ship_corp;

    }

    $final_shipping = ($global_premier>$global_corp) ? $global_corp : $global_premier;

    // $response=$this->setShippingOrder($order);

    //Redondeo de centenas
    $x=100;
    $final_shipping = round(($final_shipping+$x/2)/$x)*$x;

    return array(
      'amount' => commerce_currency_decimal_to_amount(strval($final_shipping), 'COP'),
      'currency' => 'COP',
    );

    // error_log(print_r($response,true),3,"/tmp/serv-resp.log");

    // $field_name = commerce_physical_order_shipping_field_name($order);
    // error_log(print_r($field_name,true),3,"/tmp/serv-field.log");

    // $weight = commerce_physical_order_weight($order, 'kg');
    // $volume = commerce_physical_order_volume($order, 'cm');

    // error_log("volumen->".$volume,3,"/tmp/serv-field.log");

  }

  

  /**
   * Get information about the shippable products of the order.
   */
  protected function extractProducts($order) {
    $products = array();

    $order_wrapper = entity_metadata_wrapper('commerce_order', $order);

    foreach ($order_wrapper->commerce_line_items as $delta => $line_item_wrapper) {
      $line_item[] = $line_item_wrapper->value();
    }

    foreach ($line_item as $key => $product) {
      # code...
      if ($product->type=='product') {
          # code...
        
        $product_id = $product->commerce_product['und'][0]['product_id'];
        // $product_id = $product_id[0];
        // $product_id = $product_id['product_id'];
        //$product2 = commerce_product_load('92');
        
        //Se cargan los datos del producto
        $product3 = commerce_product_load($product_id);
        
        $sku = $product3->sku;
        $proveedor = $product3->field_providers;
        $commerce_price = $product3->commerce_price['und'][0]['amount'];
        $currency_code = $product3->commerce_price['und'][0]['currency_code'];

        $product_query = commerce_product_load_by_sku($sku);
        $query = new EntityFieldQuery;

        $query->entityCondition('entity_type', 'node', '=')
        ->propertyCondition('type', 'product_display')
        ->fieldCondition('field_product', 'product_id', $product_query->product_id, '=')
        ->range(0, 1);

        if ($result = $query->execute()) {
        //Do stuff with the result
          //error_log(print_r($result,true),3,"/tmp/serv-disp.log");
          foreach ($result['node'] as $key => $value) {
            # code...
            $display_id = $value->nid;
          }

          //Se cargan los datos del display  
          $product_display = node_load($display_id);
          $field_width = $product_display->field_width;
          $field_height = $product_display->field_height;
          $field_length = $product_display->field_product_length;
          $field_weight = $product_display->field_product_weight;

          $arr_proveedor = node_load($proveedor['und'][0]['target_id']);

          //error_log(print_r($product_display,true),3,"/tmp/serv-disp.log");
          //error_log(print_r($arr_proveedor,true),3,"/tmp/serv-ved.log");
        
        }

        $arr_products[]=array('sku'=>$sku, 
                              'price'=>$commerce_price,
                              'proveedor'=>$arr_proveedor->field_postal_address['und'][0],
                              'currency_code'=>$currency_code,
                              'field_width'=>$field_width,
                              'field_height'=>$field_height,
                              'field_length'=>$field_length,
                              'field_weight'=>$field_weight,
                              'full_provider_data'=>$arr_proveedor,
                              );

      }

      //error_log(print_r($arr_products,true),3,"/tmp/serv-field.log");
    }      
    return $arr_products;
  }


  /**
   * Ask for the pickup of the order.
   */
  public function setShippingOrder($order) {
    $order_wrapper = entity_metadata_wrapper('commerce_order', $order);

    $products = $this->extractProducts($order);
    $shipment_details = $this->getShipmentDetails($order);

     watchdog('Servientrega','Ejecuto el llamado automaticamente');

    //se recorren todos los productos y se genera una guia por producto
    foreach ($products as $key => $product) {
      # code...
      // Para agrupar por proveedor
      // $key_prov = $product['full_provider_data']->title;
      // $arr_temp[$key_prov][] = $product;   

      // Se llama el WS por producto
      $response=$this->setParametersUrl($product,$shipment_details);

    }

    // se envian los productos agrupados por proveedor

    // foreach ($arr_temp as $key => $value) {
    //   # code...
    //   $response=$this->setParametersUrl($value,$shipment_details);
    // }
    return true;

  }  

  protected function setParametersUrl($product,$shipping){

    $ns = 'http://tempuri.org/'; //Namespace of the WS.
    $headerbody = array('login' => $this->client,

                       'pwd' => $this->key,

                       'Id_CodFacturacion'=>$this->invoice_code,

                        'Nombre_Cargue'=>$this->name);

    $client = new SoapClient(COMMERCE_SERVI_URL);
    $header = new SOAPHeader($ns, 'AuthHeader', $headerbody);    
    //var_dump($header);
    $client->__setSoapHeaders($header);

    // $arr_products[]=array('sku'=>$sku, 
    //                   'price'=>$commerce_price,
    //                   'proveedor'=>$arr_proveedor->field_postal_address['und'][0],
    //                   'currency_code'=>$currency_code,
    //                   'field_width'=>$field_width,
    //                   'field_height'=>$field_height,
    //                   'field_length'=>$field_length,
    //                   'field_weight'=>$field_weight,
    //                   'full_provider_data'=>$arr_proveedor,
    //                   );

    //error_log(print_r($product,true),3,"/tmp/serv-set.log");     
    //error_log(print_r($shipping,true),3,"/tmp/serv-set.log");

    $arr_origen = $this->getCitiesFromCodes($product['proveedor']['locality'],$product['proveedor']['administrative_area'],$product['proveedor']['country']);

    $weight = ($product['field_weight']['und'][0]['value']/1000)>3 ?  $product['field_weight']['und'][0]['value']/1000 : 3 ;

    $bar1 = new CargueMasivoExternoDTO();

    $bar1->objEnvios[0] = new EnvioExterno();

    $bar1->objEnvios[0]->Num_Guia = 0;

    $bar1->objEnvios[0]->Num_Sobreporte = 0;

    //$bar1->objEnvios[0]->Fec_Creacion = '';

    //$bar1->objEnvios[0]->Fec_TiempoEntrega = '';

    $bar1->objEnvios[0]->Doc_Relacionado = '';

    $bar1->objEnvios[0]->Num_Piezas = 1;

    $bar1->objEnvios[0]->Des_TipoTrayecto = 0;

    $bar1->objEnvios[0]->Ide_Producto = 2;

    $bar1->objEnvios[0]->Ide_Destinatarios = '00000000-0000-0000-0000-000000000000';

    //$bar1->objEnvios[0]->Ide_CodFacturacion = '';

    $bar1->objEnvios[0]->Ide_Manifiesto = '00000000-0000-0000-0000-000000000000';

    $bar1->objEnvios[0]->Des_FormaPago = 2;

    $bar1->objEnvios[0]->Des_MedioTransporte = 1;

    $bar1->objEnvios[0]->Num_PesoTotal = $weight;

    $bar1->objEnvios[0]->Num_ValorDeclaradoTotal = 10000;

    $bar1->objEnvios[0]->Num_VolumenTotal = 0;

    $bar1->objEnvios[0]->Num_BolsaSeguridad = 0;

    $bar1->objEnvios[0]->Num_Precinto = 0;

    $bar1->objEnvios[0]->Des_TipoDuracionTrayecto = 1;

    $bar1->objEnvios[0]->Des_Telefono = '5555555';

    $bar1->objEnvios[0]->Des_Ciudad = '08001000';

    $bar1->objEnvios[0]->Des_Direccion = $shipping['address'];

    $bar1->objEnvios[0]->Nom_Contacto = $shipping['name'];//'Jorge Perez';

    $bar1->objEnvios[0]->Des_VlrCampoPersonalizado1 = '';

    $bar1->objEnvios[0]->Num_ValorLiquidado = 0;

    $bar1->objEnvios[0]->Des_DiceContener = 'POliza SOAT';

    $bar1->objEnvios[0]->Des_TipoGuia = 0;

    //$bar1->objEnvios[0]->Des_CiudadRemitente ='';

    $bar1->objEnvios[0]->Num_VlrSobreflete= 0;

    $bar1->objEnvios[0]->Num_VlrFlete= 0;

    $bar1->objEnvios[0]->Num_Descuento= 0;

    //$bar1->objEnvios[0]->Des_DireccionRecogida = '';

    //$bar1->objEnvios[0]->Des_TelefonoRecogida = '';

    //$bar1->objEnvios[0]->Des_CiudadRecogida = '';

    $bar1->objEnvios[0]->idePaisOrigen= 0;

    $bar1->objEnvios[0]->idePaisDestino= 0;

    //$bar1->objEnvios[0]->Des_IdArchivoOrigen = '';

    //$bar1->objEnvios[0]->Ide_Num_Identific_Dest = '';

    //$bar1->objEnvios[0]->Ide_Num_Referencia_Dest = '';

    $bar1->objEnvios[0]->Des_DireccionRemitente = '';

    $bar1->objEnvios[0]->Num_PesoFacturado = 0;

    //$bar1->objEnvios[0]->Nom_TipoTrayecto = '';

    $bar1->objEnvios[0]->Est_CanalMayorista = 0;

    //$bar1->objEnvios[0]->Nom_Remitente = '';

    $bar1->objEnvios[0]->Num_IdentiRemitente = '';

    $bar1->objEnvios[0]->Num_TelefonoRemitente = '';

    $bar1->objEnvios[0]->Num_Alto = $product['field_height']['und'][0]['value'];

    $bar1->objEnvios[0]->Num_Ancho = $product['field_width']['und'][0]['value'];

    $bar1->objEnvios[0]->Num_Largo = $product['field_length']['und'][0]['value'];

    $bar1->objEnvios[0]->Des_CiudadOrigen = 'BOGOTA';

    //$bar1->objEnvios[0]->Des_DiceContenerSobre= '';

    $bar1->objEnvios[0]->Des_DepartamentoDestino= $shipping['department']; //'DISTRITO CAPITAL';

    $bar1->objEnvios[0]->Des_DepartamentoOrigen= $arr_origen['department'];//'DistritoCapital';

    $bar1->objEnvios[0]->Gen_Cajaporte= 0;

    $bar1->objEnvios[0]->Gen_Sobreporte= 0;

    $bar1->objEnvios[0]->Nom_UnidadEmpaque= 'GENERICA';

    $bar1->objEnvios[0]->Nom_RemitenteCanal= '';

    $bar1->objEnvios[0]->Des_UnidadLongitud= 'cm';

    $bar1->objEnvios[0]->Des_UnidadPeso= 'kg';

    $bar1->objEnvios[0]->Num_ValorDeclaradoSobreTotal= 0;

    $bar1->objEnvios[0]->Num_Factura= '';

    $bar1->objEnvios[0]->Des_CorreoElectronico= $shipping['email']; //'andres16viper@hotmail.com';

    //$bar1->objEnvios[0]->Num_Celular= '';

    //$bar1->objEnvios[0]->Id_ArchivoCargar= '';

    $bar1->objEnvios[0]->Est_EnviarCorreo= ''; 

    $bar1->objEnvios[0]->Num_Recaudo= '';

    $obj2 = array();

    $objEnviar= array($bar1);

    //error_log(print_r($objEnviar,true),3,"/tmp/serv-res.log");     

    //var_dump($bar1);

    $result= $client->CargueMasivoExterno(array('envios'=>$objEnviar));

    watchdog('Servientrega','La guia es: ' . $result->arrayGuias->string);

    //error_log(print_r($result,true),3,"/tmp/serv-res.log");     

    // var_dump($result->arrayGuias->string);

    return $result;

  }



}

/**
 * Custom exception for Servientrega.
 */
class CommerceServientregaException extends Exception {
}




class CargueMasivoExternoDTO{

    public $objEnvios= array();

}

class EnvioExterno {

    var $Num_Guia;

    var $Num_Sobreporte;

    var $Fec_Creacion;

    var $Fec_TiempoEntrega;

    var $Doc_Relacionado;

    var $Num_Piezas;

    var $Des_TipoTrayecto;

    var $Ide_Producto;

    var $Ide_Destinatarios;

    var $Ide_CodFacturacion;

    var $Ide_Manifiesto;

    var $Des_FormaPago;

    var $Des_MedioTransporte;

    var $Num_PesoTotal;

    var $Num_ValorDeclaradoTotal;

    var $Num_VolumenTotal;

    var $Num_BolsaSeguridad;

    var $Num_Precinto;

    var $Des_TipoDuracionTrayecto;

    var $Des_Telefono;

    var $Des_Ciudad;

    var $Des_Direccion;

    var $Nom_Contacto;

    var $Des_VlrCampoPersonalizado1;

    var $Num_ValorLiquidado;

    var $Des_DiceContener;

    var $Des_TipoGuia;

    var $Des_CiudadRemitente;

    var $Num_VlrSobreflete;

    var $Num_VlrFlete;

    var $Num_Descuento;

    var $Des_DireccionRecogida;

    var $Des_TelefonoRecogida;

    var $Des_CiudadRecogida;

    var $idePaisOrigen;

    var $idePaisDestino;

    var $Des_IdArchivoOrigen;

    var $Ide_Num_Identific_Dest;

    var $Ide_Num_Referencia_Dest;

    var $Des_DireccionRemitente;

    var $Num_PesoFacturado;

    var $Nom_TipoTrayecto;

    var $Est_CanalMayorista;

    var $Nom_Remitente;

    var $Num_IdentiRemitente;

    var $Num_TelefonoRemitente;

    var $Num_Alto;

    var $Num_Ancho;

    var $Num_Largo;

    var $Des_CiudadOrigen;

    var $Des_DiceContenerSobre;

    var $Des_DepartamentoDestino;

    var $Des_DepartamentoOrigen;

    var $Gen_Cajaporte;

    var $Gen_Sobreporte;

    var $Nom_UnidadEmpaque;

    var $Nom_RemitenteCanal;

    var $Des_UnidadLongitud;

    var $Des_UnidadPeso;

    var $Num_ValorDeclaradoSobreTotal;

    var $Num_Factura;

    var $Des_CorreoElectronico;

    var $Num_Celular;

    var $Id_ArchivoCargar;

    var $Num_Recaudo;

    var $Est_EnviarCorreo;

}
