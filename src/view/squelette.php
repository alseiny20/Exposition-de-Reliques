<!DOCTYPE html>
<html lang="fr-FR">
<head>
  <meta  charset="UTF-8" >
  <meta name="author" content="22011830" >
  <link rel="stylesheet" media="screen" href="style/style.css" >
  <title><?php echo $this->title ;?></title>
</head>
<body>

<main>
  <div>
    <ul class=menu>
    <?php
    foreach ($this->menu as $key => $value) {
        echo "<li><a href="."'$key'"."> $value</a></li>";
    }?>
    </ul>
    </div>
  <div><?php echo "$this->feedback";?></div>
	
  <div class="page">
    
    <?php echo $this->content;?>
  </div>

</main>
</body>
</html>
