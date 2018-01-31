<div>
<?php if(!empty($messages)) : ?>
    <?php foreach($messages as $type => $msgs) : ?>
        <?php foreach($msgs as $msg) : ?>
            <span><strong><?= $msg ?></strong></span>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>
</div>

<a href="<?= DOMAIN.'/add' ?>">Add User</a>
<a href="<?= DOMAIN.'/clear-cache' ?>">Clear cache</a>
<form name="delete" action="<?= DOMAIN ?>/delete" method="post">
    <button value="Delete user">Delete user</button>
    <table class="table table-striped table-hover margin-top-20">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Is Enabled</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($data['list'])) : ?>
                <?php foreach ($data['list'] as $user) : ?>
                    <tr>
                        <td><input type="checkbox" name="delete[]" value="<?= $user['id'] ?>"></td>
                        <td><?= $user['id'] ?></td>
                        <td><a href="<?= DOMAIN.'/edit?id='.$user['id'] ?>" ><?= $user['name'].'&nbsp'.$user['last_name'] ?></a></td>
                        <td><?= $user['user_name'] ?></td>
                        <td><?= $user['is_enabled'] == 1 ? 'YES' : 'NO' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <div>
        <?= $data['paginate'] ?>
    </div>
</form>