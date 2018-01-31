<?php if(!empty($messages)) : ?>
    <?php foreach($messages as $type => $msgs) : ?>
        <?php foreach($msgs as $msg) : ?>
            <span><strong><?= $msg ?></strong></span>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>
<form name="edit_user" action="<?= DOMAIN.'/insert' ?>" method="post">
    <div>
        <label>Username</label>
        <input type="text" name="user_name" value="">
    </div>

    <div>
        <label>Name</label>
        <input type="text" name="name" value="">
    </div>

    <div>
        <label>Last Name</label>
        <input type="text" name="last_name" value="">
    </div>

    <div>
        <label>Is enabled</label>
        <input type="checkbox" name="is_enabled" >
    </div>

    <button value="Submit">Submit</button>
    <a href="<?= DOMAIN ?>">Go back</a>
</form>
