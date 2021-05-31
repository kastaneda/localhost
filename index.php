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
    </style>
  </head>
  <body>
    <ul>
<?php
  // To match routeable host names
  // like 'project-name.workstation.home'
  $mask = '*.' . gethostname() . '.home';

  $remote_ip = $_SERVER['REMOTE_ADDR'] ?? '';
  $server_ip = $_SERVER['SERVER_ADDR'] ?? null;
  if (in_array($remote_ip, ['127.0.0.1', '::1', $server_ip])) {
    // To match all host names, except for IPs (127.0.0.1, etc)
    $mask = '*.localhost';
  }

  $vhosts = array_map('basename', glob('/var/www/vhosts/' . $mask));

  foreach($vhosts as $vhost) {
    mt_srand(crc32($vhost));
    $hue = mt_rand(0, 359);
    $css = 'style="background: hsl(' . $hue . ', 80%, 80%)"';
    $url = 'http://' . $vhost;
    printf("      <li><a href=\"%s\" %s>%s</a></li>\n", $url, $css, $vhost);
  }
?>
      <li><a href="phpinfo.php">phpinfo();</a></li>
    </ul>
  </body>
</html>
