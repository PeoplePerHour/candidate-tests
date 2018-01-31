<?php if(!empty($messages)) : ?>
    <?php foreach($messages as $type => $msgs) : ?>
        <?php foreach($msgs as $msg) : ?>
            <span><strong><?= $msg ?></strong></span>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>

<form name="edit_user" action="<?= DOMAIN.'/update' ?>" method="post">
    <input type="hidden" name="id" value="<?= $data['list'][0]['id'] ?>">
    <div>
        <label>Username</label>
        <input type="text" name="user_name" value="<?= $data['list'][0]['user_name'] ?>">
    </div>

    <div>
        <label>Name</label>
        <input type="text" name="name" value="<?= $data['list'][0]['name'] ?>">
    </div>

    <div>
        <label>Last Name</label>
        <input type="text" name="last_name" value="<?= $data['list'][0]['last_name'] ?>">
    </div>

    <div>
        <label>Is enabled</label>
        <input type="checkbox" name="is_enabled" <?= $data['list'][0]['is_enabled'] == 1 ? 'checked' : '' ?>>
    </div>

    <button value="Submit">Submit</button>
    <a href="<?= DOMAIN ?>">Go back</a>
</form>
