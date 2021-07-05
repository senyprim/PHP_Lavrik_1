<div class="content">
    <? if (!!$logs) : ?>
        <h2><?= $title ?></h2>
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Time</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">METHOD</th>
                        <th scope="col">REFERER</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $item) : ?>
                        <tr>
                            <td><?= $item['time'] ?></td>
                            <td><?= $item['ip'] ?></td>
                            <td><?= $item['uri'] ?></td>
                            <td><?= $item['method'] ?></td>
                            <td><?= $item['referer'] ?></td>
                        </tr>
                    <? endforeach ?>
                </tbody>
            </table>
        <? else : ?>
            <h2>Лог файл не выбран</h2>
        <? endif ?>
</div>