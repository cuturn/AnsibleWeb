<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title;?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>

<nav class="navbar navbar-default">
<div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Ansible Viewer</a>
    </div>
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li <?php if($page_id==1)echo 'class="active"'; ?>><a href="hosts.php">Hosts_File</a></li>
            <li <?php if($page_id==4)echo 'class="active"'; ?>><a href="facts.php">Facts</a></li>
            <li <?php if($page_id==5)echo 'class="active"'; ?>><a href="hosts_db.php">Hosts_DB</a></li>
            <li <?php if($page_id==2)echo 'class="active"'; ?>><a href="playbooks.php">Playbooks</a></li>
            <li <?php if($page_id==3)echo 'class="active"'; ?>><a href="roles.php">Roles</a></li>
        </ul>
    </div><!--/.nav-collapse -->
</div>
</nav>
<!-- アラートの表示 -->
<?php if(isset($msg)):?>
<div class="alert alert-success" role="alert"><?php echo $msg;?></div>
<?php endif;?>
