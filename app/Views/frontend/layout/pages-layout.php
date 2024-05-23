<!DOCTYPE html>

<html lang="en-us">

<head>
    <meta charset="utf-8">
    <title><?= isset($pageTitle) ? $pageTitle : "CI4Blog" ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="description" content="This is meta description">
    <meta name="author" content="Themefisher">
    <?= $this->renderSection('page_meta') ?>
    <link rel="shortcut icon" href="images/blogs/<?= get_settings()->blog_favicon ?>" type="image/x-icon">

    <!-- theme meta -->
    <meta name="theme-name" content="reporter" />

    <!-- # Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Neuton:wght@700&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- # CSS Plugins -->
    <link rel="stylesheet" href="frontend/plugins/bootstrap/bootstrap.min.css">

    <!-- # Main Style Sheet -->
    <link rel="stylesheet" href="frontend/css/style.css">
    <?= $this->renderSection('stylesheets') ?>
</head>

<body>
    <?php include ('inc/header.php') ?>

    <main>
        <section class="section">
            <div class="container">
                <?= $this->renderSection('content') ?>
            </div>
        </section>
    </main>

    <!-- footer  -->
    <?php include ('inc/footer.php') ?>
    <!-- footer  -->

    <!-- # JS Plugins -->
    <script src="frontend/plugins/jquery/jquery.min.js"></script>
    <script src="frontend/plugins/bootstrap/bootstrap.min.js"></script>

    <!-- Main Script -->
    <script src="js/script.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>