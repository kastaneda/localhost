<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo gethostname(); ?></title>
    <meta name="viewport" content="width=device-width">
    <style>
      * { margin: 0; padding: 0 }
      li { list-style-type: none }
      html { height: 100% }
      body { min-height: 100%; display: flex }

      ul {
        width: 100%;
        margin: auto;
        padding: 1em;
        display: grid;
        grid-template-columns: repeat(auto-fill, 17em);
        grid-gap: 2em;
        justify-content: center
      }

      a {
        display: block;
        width: 15em;
        padding: 1em;
        background: #aec;
        border-radius: .5em 
      }

      a:hover, a:focus {
        filter: brightness(1.15);
        outline: none;
        box-shadow: 0 0 10pt 1pt #0007
      }

      a:active { color: #fff; background: #444 !important }

      @media (prefers-color-scheme: dark) {
        body { background: #444 }
        a:hover, a:focus { box-shadow: 0 0 10pt #afe7 }
      }
    </style>
  </head>
  <body>
    <ul>
<?php

    switch ($_SERVER['SERVER_NAME'] ?? null) {
        case '127.0.0.1':
        case '[::1]':
        case 'localhost':
            $re = '/^[a-z0-9\-]+\.localhost$/';
            break;

        case gethostname() . '.home':
            $re = '/^[a-z0-9\-]+\.' . gethostname() . '\.home$/';
            break;

        case gethostname() . '.home.kastaneda.kiev.ua':
            $re = '/^[a-z0-9\-]+\.' . gethostname() . '\.home\.kastaneda\.kiev\.ua$/';
            break;

        case 'coder.localhost':
            $re = '/^[a-z0-9\-]+\.coder\.localhost$/';
            break;

        default:
            $mask = '*';
            break;
    }

    $vhosts = array_map('basename', glob('/var/www/vhosts/*'));

    $skipList = [];
    $skipFile = __DIR__ . '/skip-list.txt';
    if (is_file($skipFile)) {
        $skipList = explode("\n", file_get_contents($skipFile));
    }

    foreach($vhosts as $vhost) {
        if (in_array($vhost, $skipList) || !preg_match($re, $vhost)) {
            continue;
        }
        mt_srand(crc32($vhost));
        $hue = mt_rand(0, 359);
        $css = 'style="background: hsl(' . $hue . ', 80%, 80%)"';
        $url = 'http://' . $vhost;
        printf("      <li><a href=\"%s\" %s>%s</a></li>\n", $url, $css, $vhost);
    }
?>
      <li><a href="phpinfo.php">phpinfo();</a></li>
      <!-- li><a href="http://rico.home/">rico.home</a></li -->
    </ul>
  </body>
</html>
