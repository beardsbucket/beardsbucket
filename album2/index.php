<?php 
require 'Foto.php';
require 'FotoDal.php';


?>

<html>
<body>
<p><?php echo $foto->getExtensao();?></p>
<img src="<?php echo $foto->getCaminho();?>">
</body>
</html>