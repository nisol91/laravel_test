<h1>staff</h1>
<div>
    <?= $title ?>
</div>
<?php
if (!empty($dataStaff)) {
    foreach ($dataStaff as $person) {
        echo '<h1>' . $person['name'] . ' ' . $person['lastname'] . '</h1>';

        // var_dump($person);
    }
}
?>
