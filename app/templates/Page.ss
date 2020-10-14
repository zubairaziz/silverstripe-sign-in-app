<!doctype html>
<html lang="$ContentLocale">

<head>
  <% include SiteMeta %>
  <% if $IsLive %>
  <style>
    {$SiteLiveCSS.RAW}
  </style>
  <% else %>
  <link rel="preconnect" href="http://localhost:8081" crossorigin>
  $SiteCSS
  <% end_if %>
</head>

<body class="$BodyClasses relative h-screen w-screen" x-data="{ 'showModal': false }"
  @keydown.escape="showModal = false" x-cloak>
  <% if ClassName = 'App\Page\HomePage' %>
  <% include SiteBackground %>
  <% end_if %>
  <main id="main-content" class="absolute inset-0 w-screen h-screen p-4">
    <% if ClassName = 'App\Page\HomePage' %>
    <% include SiteHeader %>
    <% end_if %>
    $Layout
  </main>
  $SiteJS
</body>

</html>
