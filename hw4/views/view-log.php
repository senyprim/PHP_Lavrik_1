<div class="content">
    <h1><?= $titleView ?></h1>
    <table border=1>
        <tr>
            <th>Time</th>
            <th>From</th>
            <th>To</th>
            <th>METHOD</th>
            <th>REFERER</th>
        </tr>
        <?php foreach ($logs as $item) : ?>
            <tr>
                <td><?= $item['time'] ?></td>
                <td><?= $item['ip'] ?></td>
                <td><?= $item['uri'] ?></td>
                <td><?= $item['method'] ?></td>
                <td><?= $item['referer'] ?></td>
            </tr>
        <? endforeach ?>
    </table>
    <br>
    <br>
    <a href="index.php?c=log">Вернутся на предыдущую страницу</a>
</div>