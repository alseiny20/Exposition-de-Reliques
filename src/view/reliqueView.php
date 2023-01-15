<div class="description">
    <h1> <?php echo $this->title;?> </h1>
    <p> <strong>Pouvoir</strong>: <?php echo  self::htmlesc($relique->getPouvoir()) ?></p>
    <p> <strong>Creation</strong>     : <?php echo  self::htmlesc($relique->getCreation()) ?></p>
    <p>  <strong>Proprietaire</strong>: <?php echo  self::htmlesc($relique->getProprietaire()) ?></p>
    <img src = "<?php echo "upload/". self::htmlesc($relique->getLiens()) ?>" alt="">
    <div>
        <form action= "<?php echo $this->routeur->getreliqueModifURL($id) ?>" method="POST">
            <button>modifier</button>
        </form>
        <form action= "<?php echo $this->routeur->getReliqueAskDeletionURL($id) ?>" method="POST">
            <button>suprimer</button>
        </form>
    </div>
</div>  
