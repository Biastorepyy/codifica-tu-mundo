<?php
session_start();
if (isset($_SESSION["bti_admin"]) && $_SESSION["bti_admin"] === true) {
    header("Location: panel_bti.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");
    
    // Convertir el nombre de usuario a mayúsculas para evitar problemas de case en teléfonos
    if (strtoupper($username) === "BTI" && $password === "BTI026CDE") {
        // PREVENCIÓN DE SESSION FIXATION
        session_regenerate_id(true);
        $_SESSION["bti_admin"] = true;
        header("Location: panel_bti.php");
        exit;
    } else {
        $error = "Credenciales incorrectas.";
    }
}

$pageTitle = "Acceso BTI";
require_once __DIR__ . "/includes/header.php";
?>
<main class="main-content" style="display: flex; justify-content: center; align-items: center; min-height: 70vh;">
    <div style="background-color: #ffffff; border: 1px solid var(--color-border); border-radius: 12px; padding: 2.5rem; box-shadow: 0 4px 20px var(--color-shadow); width: 100%; max-width: 400px; text-align: center;">
        <h2 style="color: var(--color-primary); font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">Acceso al Panel BTI</h2>
        
        <?php if ($error): ?>
            <div style="background-color: #fce8e6; border: 1px solid #e53e3e; color: #e53e3e; padding: 0.75rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.9rem;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem; text-align: left;">
            <div>
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--color-secondary); margin-bottom: 0.5rem; display: block;">Usuario</label>
                <input type="text" name="username" required autocomplete="off" autocapitalize="none" autocorrect="off" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 6px; outline: none;">
            </div>
            <div>
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--color-secondary); margin-bottom: 0.5rem; display: block;">Contrase&ntilde;a</label>
                <input type="password" name="password" required autocomplete="off" autocapitalize="none" autocorrect="off" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 6px; outline: none;">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 0.5rem; width: 100%; justify-content: center;">Ingresar al Panel</button>
        </form>
    </div>
</main>
<?php
require_once __DIR__ . "/includes/footer.php";
?>
