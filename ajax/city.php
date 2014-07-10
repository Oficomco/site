<?php
header("Access-Control-Allow-Origin: *");
$mageFilename = '../app/Mage.php';
require_once $mageFilename;

Mage::app();

$idCiudad = $_GET['id'];
$DB = Mage::getSingleton('core/resource')->getConnection('core_write');
?>

<div class="inner">
	<label>
		Ciudad:
	</label>
	<select id="city" name="city" class="city">
		<option value=" ">Seleccione</option>
		<?php
			$sql = "select a.city_id city, a.default_name as code from ofi_directory_city as a where region_id= '$idCiudad' order by code";
			
			foreach ($DB->fetchAll($sql) as $rs) { ?>
									
			    <option value="<?php echo $rs['city'] ?>"><?php echo $rs['code'] ?></option>
									
		  <?php } ?>
	</select>
</div>

