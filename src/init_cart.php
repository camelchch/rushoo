<?PHP

function init_cart($page, $sql) {
    if (isset($_GET['add'])) {
        $id_add = ceil($_GET['add']);
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }
        if (isset($_SESSION['panier'][$id_add])) {
            $_SESSION['panier'][$id_add]++;
        } else {
            $_SESSION['panier'][$id_add] = 1;
        }
    }
    if (isset($_GET['remove']) && isset($_SESSION['panier'])) {
        $id_add = ceil($_GET['remove']);
        if (isset($_SESSION['panier'][$id_add])) {
            if ($_SESSION['panier'][$id_add] == 1) {
                unset($_SESSION['panier'][$id_add]);
            } else {
                $_SESSION['panier'][$id_add]--;
            }
        }
    }
    if (isset($_GET['delete']) && isset($_SESSION['panier'])) {
        $id_del = ceil($_GET['delete']);
        if (isset($_SESSION['panier'][$id_del])) {
            unset($_SESSION['panier'][$id_del]);
        }
    }
}

function init_validate($page, $sql) {
    if (!ft_logged()) {
        header("Location: page_connexion.php");
        exit;
    }
	$user = mysqli_query($sql, "SELECT * FROM users WHERE id = ".$_SESSION['id']." LIMIT 1");
	if (mysqli_num_rows($user) == 0) {
		unset($_SESSION['id']);
		header("Location: index.php");
		exit;
	}
	$user = mysqli_fetch_array($user);
	if ($user['desactivated']) {
		unset($_SESSION['id']);
		header("Location: index.php");
		exit;
	}
	$user_id = ceil($user['id']);
    if (isset($_POST['validate'])) {
		mysqli_query($sql, "INSERT INTO panier VALUES (NULL, ".$user_id.", '".serialize($_SESSION['panier'])."', 0)");
		unset($_SESSION['panier']);
		header("Location: index.php");
		exit;
	}
}

?>