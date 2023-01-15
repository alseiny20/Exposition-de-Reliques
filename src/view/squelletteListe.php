<h1> <?php echo $this->title;?> </h1>
<ul class = "liste">
<?php 
    foreach ($donnes as $key => $value) {
        echo '<li><a href="'.$this->routeur->getReliqueURL($key).'">'.self::htmlesc($value->getNom()).'</a></li>';
    }
?>
</ul>