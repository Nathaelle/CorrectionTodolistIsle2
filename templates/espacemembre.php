<h1>Bienvenue sur votre espace personnel !</h1>

<form action="index.php?route=inserttask" method="POST">

    <input type="text" placeholder="Tâche à réaliser" name="description">
    <label for="deadline">Avant le : </label>
    <input type="date" name="deadline" id="deadline">
    <input type="submit" value="Ajouter">

</form>