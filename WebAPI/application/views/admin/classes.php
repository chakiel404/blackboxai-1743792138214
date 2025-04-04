<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
    <div class="container mx-auto mt-5">
        <h1 class="text-2xl font-bold">Class Management</h1>
        <div class="mt-4">
            <a href="add_class.php" class="btn btn-primary">Add Class</a>
        </div>
        <table class="min-w-full mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">Class Name</th>
                    <th class="px-4 py-2">Academic Year</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($class->class_name); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($class->academic_year); ?></td>
                    <td class="border px-4 py-2">
                        <a href="edit_class.php?id=<?php echo $class->class_id; ?>" class="text-blue-500">Edit</a>
                        <form action="delete_class.php" method="POST" style="display:inline;">
                            <input type="hidden" name="class_id" value="<?php echo $class->class_id; ?>">
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