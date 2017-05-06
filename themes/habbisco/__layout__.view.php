<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $this->title ?></title>

    <!-- Stylesheets -->
    <?php foreach($this->css as $i => $css_url): ?>
        <link rel="stylesheet" href="<?php echo $css_url ?>">
    <?php endforeach; ?>

    <!-- Scripts -->
    <?php foreach($this->js as $i => $js_url): ?>
        <script src="<?php echo $js_url ?>"></script>
    <?php endforeach; ?>
</head>
<body>
<div id="<?= $this->__name ?>">
    <?php $this->__content(); ?>
</div>
</body>
</html>