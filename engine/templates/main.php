<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title><?php echo Language::get('main', 'title'); ?></title>
    <link href="css/main.css" type="text/css" rel="stylesheet">
    <!-- jQuery -->
    <!--[if lt IE 9]>
    <script src="js/jquery-1.12.3.min.js" type="text/javascript"></script>
    <![endif]-->
    <!--[if gte IE 9]><!-->
    <script src="js/jquery-2.2.3.min.js" type="text/javascript"></script>
    <!--<![endif]-->
    <script src="js/main.js" type="text/javascript"></script>
</head>
<body>
    <!-- Main container -->
    <div class="gb-main-container">
        <?php include_once 'note_insert.php'; ?>
        <?php include_once 'notes.php'; ?>
        <?php include_once 'notes_more.php'; ?>
    </div>
</body>
</html>