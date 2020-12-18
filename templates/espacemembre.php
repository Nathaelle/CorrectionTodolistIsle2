<?php
var_dump($toTemplate);
// Les données se trouvent dans $toTemplate["datas"]

$tasks = $toTemplate["datas"];

?>

<h1>Bienvenue sur votre espace personnel !</h1>

<form action="index.php?route=inserttask" method="POST">

    <input type="text" placeholder="Tâche à réaliser" name="description">
    <label for="deadline">Avant le : </label>
    <input type="date" name="deadline" id="deadline">
    <input type="submit" value="Ajouter">

</form>


<ul>
    <?php foreach($tasks as $task): ?>

        <li><?= $task->description ?> avant le <?= $task->deadline ?></li>

    <?php endforeach ?>
</ul>