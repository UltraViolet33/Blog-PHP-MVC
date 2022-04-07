<?php $this->view("inc/header", $data); ?>
<div class="row justify-content-center">
   <div class="col-8">
       <h1 class="text-center"><?=  validateData($data['post']->name) ?></h1>
       <p>Publié le : <?=  validateData($post->created_at) ?> </p>
       <p>Categorie : <?=  $data['post']->categories?></p>
       <p style="text-align:justify"><?= validateData($post->content) ?></p>
   </div>
</div>
<?php $this->view("inc/footer", $data); ?>



