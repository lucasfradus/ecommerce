<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $configuracion['title']; ?></title>
    <?php
        include("frontend/header.php");
        include("frontend/css.php");
    ?>
    <?php if (!empty($configuracion['google_analytics'])) : ?>
        <?php echo $configuracion['google_analytics'] ?>
    <?php endif ?>
</head>
<body>
    <?php include("frontend/menu.php");?>
    <?php echo $contenido_main; ?>
    <?php include("frontend/footer.php"); ?>
    <SCRIPT TYPE="text/javascript">
        var base_url = '<?php echo base_url() ?>';
    </SCRIPT>
    <?php include("frontend/js.php"); ?>
</body>
</html>
