<?php
header("Access-Control-Allow-Origin: *");
$mageFilename = '../app/Mage.php';
require_once $mageFilename;

Mage::app();
$ciudad = $_GET['city'];
$depart = $_GET['region'];
$DB = Mage::getSingleton('core/resource') -> getConnection('core_write');


Mage::getSingleton('customer/session')->setMyValue("$depart");


$idciudad = "SELECT code FROM ofi_directory_city where city_id = '$ciudad'";
$resultcity = $DB ->fetchRow($idciudad);
$iddepart = "SELECT default_name FROM directory_country_region where region_id = '$depart'";
$resultdepart = $DB ->fetchRow($iddepart);

$nameciudad = $resultcity['code'].','.$resultdepart['default_name'];

Mage::getSingleton('customer/session')->setMyValue("$nameciudad");





$query = "SELECT canal, tiempo, monto, flete,adicional, f.region_id, f.city_id, c.code, r.default_name
         FROM ofi_flete as f
         LEFT JOIN ofi_directory_city as c ON f.city_id  = c.city_id
         LEFT JOIN directory_country_region as r ON f.region_id  = r.region_id
         WHERE f.region_id = '$depart' and f.city_id='$ciudad'
         ORDER BY monto";
$results = $DB -> fetchAll($query);
$result = $DB ->fetchRow($query);
?>


<h2 class="heading">Información de envío</h2>

   <?php if($result['canal'] == 'TRAYECTO ESPECIAL'): ?>
      <?php $entrega = $result['tiempo'] + $result['adicional']?>
      <table width="100%">
         <tbody>
            <tr>
               <td class="valor-compras">
                  <span class="rango-compra">Por compras entre <br/>$20.000 y $59.999</span>
               </td>
               <td class="valor-flete">
                  <?php $fleteFormat = number_format($result['flete'], 0, ".", "."); ?>
                  <span class="flete-precio"><?php echo '$' . $fleteFormat; ?></span><br />
                  <input type="hidden" name="flete"  id="flete" value="<?php echo $fleteFormat; ?>">
                  <span class="tiempo-entrega"><?php echo $entrega; ?> días de entrega</span> - 
                  <span class="canal-entrega"><?php echo $result['canal']; ?></span>
               </td>
            </tr>
            <tr>
               <td class="valor-compras">
                  <span class="rango-compra">Por compras mayores a <br/>$60.000</span>
               </td>
               <td class="valor-flete">
                  <?php $fleteFormat = number_format($result['flete'], 0, ".", "."); ?>
                  <span class="flete-precio"><?php echo '$' . $fleteFormat . ' +<br /> ($ 2.800 * (Total del Pedido/ $40.000))'; ?></span><br />
                  <span class="tiempo-entrega"><?php echo $entrega; ?> días de entrega</span> - 
                  <span class="canal-entrega"><?php echo $result['canal']; ?></span>
                  <input type="hidden" name="entrega"  id="entrega" value="<?php echo $entrega; ?>">

               </td>
            </tr>
         </tbody>
      </table>

   <?php else: ?>
      <?php $entrega = $result['tiempo'] + $result['adicional']?>
      <table width="100%">
         <tbody>
            <tr>
               <?php 
                  for ($i = 0; $i < count($results); $i++) {
                     $row = $results[$i];
                     if($i == 0):
                        $monto0 = $row['monto']; 
                     endif;
                     if($i == 1):
                        $monto1 = $row['monto']; 
                     endif;
                     if($i == 2):
                        $monto2 = $row['monto']; 
                     endif;
                  }
               ?>

              <?php for ($i = 0; $i < count($results); $i++) { ?>
                  <?php $row = $results[$i]; ?>
                           
                  <?php if($i == 0): ?>
                     <td class="valor-compras">
                        <?php $monto0Format = number_format($monto0, 0, ".", "."); ?>
                        <?php $monto1Format = number_format($monto1-1, 0, ".", "."); ?>
                        <span class="rango-compra"><?php echo 'Por compras entre <br/>$' . $monto0Format . ' y $' . $monto1Format ?></span>
                     </td>
                  <?php endif; ?>

                  <?php if($i == 1): ?>
                     <td class="valor-compras">
                        <?php $monto1Format = number_format($monto1, 0, ".", "."); ?>
                        <?php $monto2Format = number_format($monto2-1, 0, ".", "."); ?>
                        <span class="rango-compra"><?php echo 'Por compras entre <br/>$' . $monto1Format . ' y $' . $monto2Format ?></span>
                     </td>
                  <?php endif; ?>   

                  <?php if($i == 2): ?>
                     <td class="valor-compras">
                        <?php $monto2Format = number_format($monto2, 0, ".", "."); ?>
                        <span class="rango-compra"><?php echo 'Por compras mayores a <br/>$' . $monto2Format ?></span>
                     </td>
                  <?php endif; ?>
                     
               <td class="valor-flete">
                   <?php $fleteFormat = number_format($row['flete'], 0, ".", "."); ?>
                  <span class="flete-precio">$<?php echo $monto = $fleteFormat; ?></span><br />
                  <span class="tiempo-entrega"><?php echo $tiempo = $row['tiempo'] + $row['adicional']; ?> días de entrega</span> - 
                  <span class="canal-entrega"><?php echo $monto = $row['canal']; ?></span>
                  <input type="hidden" name="flete"  id="flete" value="<?php echo $fleteFormat; ?>">
                  <input type="hidden" name="entrega"  id="entrega" value="<?php echo $tiempo; ?>">
               </td>

            </tr>
            <?php } ?>
         </tbody>
      </table>

   <?php endif; ?>