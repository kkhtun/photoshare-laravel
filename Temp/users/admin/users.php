<?php

use Helpers\Helper;
use Libs\Database\User;

$users = User::getAll();
?>
<table class="table">
    <thead>
        <tr>
            <td>#</td>
            <td>Email</td>
            <td>Name</td>
            <td>Slug</td>
            <td>Role</td>
            <td>Created At</td>
            <td>Updated At</td>
            <td>Last Login</td>
            <td>Operations</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users['data'] as $user) : ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->name ?></td>
                <td><?= $user->slug ?></td>
                <td><?= $user->role ?></td>
                <td><?= $user->created_at ?></td>
                <td><?= $user->updated_at ?></td>
                <td class="w-25"><small><?= $user->user_agent ?></small></td>
                <td style="width: 10em;">
                    <a href="<?= Helper::baseUrl() ?>/users/edit.php?user=<?= $user->slug ?>" class="btn btn-outline-info btn-sm">Edit</a>&nbsp;
                    <a href="<?= Helper::baseUrl() ?>/users/delete.php?user=<?= $user->slug ?>" class="btn btn-outline-danger btn-sm">Remove</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>