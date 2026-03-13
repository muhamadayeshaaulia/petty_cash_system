<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Petty Cash</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 50px; text-align: center;">
    <h2>Login Sistem Petty Cash <br> PT 716_Production</h2>
    <?php if (session()->getFlashdata('error')): ?>
        <?php endif; ?>

        <form action="<? base_url('auth/process')?>"method="POST" style="display: inline-block; text-align: left;border: 1px solid #ccc; padding: 20px;">
            <? csrf_field()?>
            <div style="margin-bottom: 10px;">
                <label>Username</label> <br>
                <input type="text" name="username" required>
            </div>
            <div style="margin-bottom: 20px;">
                <label>Password</label> <br>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>

</body>
</html>