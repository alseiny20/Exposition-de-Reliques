<h1> <?php echo $this->title;?> </h1>
<blockquote>
    <form enctype="multipart/form-data" action="<?php echo $fromAction ?>" method="POST">
        <fieldset class="formulaire" >
            <legend>Rensignement de la Relique a creer</legend>
            <div><label>Nom <input type="text" name="nom" value="<?php echo $donneesInit->getData()!=null ? $donneesInit->getData()[NAME_REF] : '' ?>"> <small><?php if (key_exists(NAME_REF, $donneesInit->getError())) {
    echo "".$donneesInit->getError()[NAME_REF];
} ?> </small></label> </div>
            <div><label>Pouvoir      <input type="text" name="pouvoir" value="<?php echo $donneesInit->getData()!=null ? $donneesInit->getData()[POUVOIR_REF] : '' ?>"> <small><?php if (key_exists(POUVOIR_REF, $donneesInit->getError())) {
    echo "".$donneesInit->getError()[POUVOIR_REF];
} ?> </small></label> </div>
            <div><label>Creation     <input type="number" name="creation" value="<?php echo $donneesInit->getData()!=null ? $donneesInit->getData()[CREATION_REF] : '' ?>"> <small><?php if (key_exists(CREATION_REF, $donneesInit->getError())) {
    echo "".$donneesInit->getError()[CREATION_REF];
} ?> </small> </label></div>
            <div><label>Proprietaire <input type="text" name="proprietaire" value="<?php echo $donneesInit->getData()!=null ? $donneesInit->getData()[PROPRIETAIRE_REF] : '' ?>"> <small><?php if (key_exists(PROPRIETAIRE_REF, $donneesInit->getError())) {
    echo "".$donneesInit->getError()[PROPRIETAIRE_REF];
} ?> </small> </label></div>
<div><label>Liens  <input type="file" name="liens"> <small><?php if (key_exists(LIENS_REF, $donneesInit->getError())) {
    echo "".$donneesInit->getError()[LIENS_REF];
} ?> </small> </label></div>
        </fieldset>
		<button >valider</button>
	</form>
</blockquote>
