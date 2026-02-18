<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="title" content="<?= $title ?>"/>
    <meta name="description" content="<?= $description ?>"/>
    <meta name="author" content="rSanjoSEO"/>
    <link rel="shortcut icon" href="<?= base_url('img/favicon.png') ?>" type="image/png"/>
    <?php if ($this->public_page) : ?>
        <meta name="keywords" content="<?= $keywords ?>"/>
        <meta name="distribution" content="global"/>
        <meta name="Revisit" content="7 days"/>
        <meta name="robots" content="all"/>
        <meta name="rating" content="general"/>
    <?php else : ?>
        <meta name="robots" content="noindex, nofollow"/>
    <?php endif ?>
    <title><?= $title ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <?php
    if (isset($css)) {
        foreach ($css as $item) {
            echo '<link href="' . base_url() . 'css/' . $item . '.css" rel="stylesheet" />';
        }
    }
    ?>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php if (ENVIRONMENT == "production" || ENVIRONMENT == "testing"): // Sólo si estamos en producción, metemos la información de Analytics ?>
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', '<?= _GOOGLE_ANALYTICS_CODE ?>', 'auto');
            ga('send', 'pageview');
        </script>
    <?php endif ?>
</head>
<body<?= (isset($this->protect_close) && $this->protect_close) ? ' onBeforeUnload="return iCanClose()"' : '' ?>>
<nav id="top-bar" class="navbar navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img id='logo' alt='S&H Dental SL' src="<?= base_url('/img/shdental.png') ?>"/>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li<?= $this->uri->segment(1) == '' ? ' class="active"' : ''; ?>><a
                            href="<?= site_url('/') ?>">Inicio</a></li>
                <?php if ($this->is_admin): ?>
                    <li<?= $this->uri->segment(1) == 'configuracion' ? ' class="active"' : ''; ?>><a
                                href="<?= site_url('/configuracion') ?>">Configuración</a></li>
                <?php endif ?>
                <?php if ($this->is_supervisor): ?>
                    <li<?= $this->uri->segment(1) == 'supervision' ? ' class="active"' : ''; ?>><a
                                href="<?= site_url('/supervision') ?>">Supervisión</a></li>
                <?php endif ?>
                <?php if (isset($this->user)): ?>
                    <li<?= $this->uri->segment(1) == 'informes' ? ' class="active"' : ''; ?>><a
                                href="<?= site_url('/informes') ?>">Informes</a></li>
                <?php endif ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($this->user) && $this->user !== false) : ?>
                    <li>
                        <a href="<?= site_url('auth/edit/' . $this->user['username']) ?>"><?= $this->user['username'] ?? '?' ?></a>
                    </li>
                    <li><a href="<?= site_url('auth/logout') ?>"><span class="glyphicon glyphicon-log-out"></span>
                            Logout</a></li>
                <?php else : ?>
                    <li<?= $this->uri->segment(1) == 'auth' ? ' class="active"' : ''; ?> ><a
                                href="<?= site_url() ?>auth"><span class="glyphicon glyphicon-log-in"></span> Login</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>