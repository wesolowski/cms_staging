<html lang="">
  <head>
    <title>Smarty</title>
  </head>
  <body>
  {foreach name=aussen item=page from=$pages}
  <hr />
  {foreach key=schluessel item=wert from=$page}
  {$schluessel}: {$wert}<br>
  {/foreach}

  {/foreach}

  </body>
</html>
