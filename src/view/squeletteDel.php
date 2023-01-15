<h1> <?php echo $this->title;?> </h1>
<p>La reliqiue <strong> <?php echo $cname ?>»</strong> va être supprimée.</p>
<form action="<?php echo $this->routeur->getReliqueDeletionURL($id)?>" method="POST">
    <button>Confirmer</button>
</form>