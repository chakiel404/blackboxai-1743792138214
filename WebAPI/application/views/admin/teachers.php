<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
    <div class="container mx-auto mt-5">
        <h1 class="text-2xl font-bold">Teacher Management</h1>
        <div class="mt-4">
            <a href="add_teacher.php" class="btn btn-primary">Add Teacher</a>
        </div>
        <table class="min-w-full mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">NIP</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teachers as $teacher): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($teacher->full_name); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($teacher->nip); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($teacher->email); ?></td>
                    <td class="border px-4 py-2">
                        <a href="edit_teacher.php?id=<?php echo $teacher->teacher_id; ?>" class="text-blue-500">Edit</a>
                        <form action="delete_teacher.php" method="POST" style="display:inline;">
                            <input type="hidden" name="teacher_id" value="<?php echo $teacher->teacher_id; ?>">
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