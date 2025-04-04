<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
    <div class="container mx-auto mt-5">
        <h1 class="text-2xl font-bold">System Settings</h1>
        <form method="POST" action="update_settings.php" class="mt-4">
            <div class="grid grid-cols-1 gap-4">
                <?php foreach ($settings as $key => $value): ?>
                <div class="form-group">
                    <label><?php echo htmlspecialchars($key); ?></label>
                    <input type="text" name="settings[<?php echo $key; ?>]" class="form-control" value="<?php echo htmlspecialchars($value); ?>" required>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Save Settings</button>
        </form>
    </div>
</body>
</html>