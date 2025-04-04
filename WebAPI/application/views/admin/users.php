<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
    <div class="container mx-auto mt-5">
        <h1 class="text-2xl font-bold">User Management</h1>
        <div class="mt-4">
            <a href="add_user.php" class="btn btn-primary">Add User</a>
        </div>
        <table class="min-w-full mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($user->full_name); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($user->email); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($user->role); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($user->status); ?></td>
                    <td class="border px-4 py-2">
                        <a href="edit_user.php?id=<?php echo $user->user_id; ?>" class="text-blue-500">Edit</a>
                        <form action="delete_user.php" method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo $user->user_id; ?>">
                            <button type="submit" class="text-red-500">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>