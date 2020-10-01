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

  <% if $SiteConfig.GoogleID %>
  <% include GoogleTagManager GoogleID=$SiteConfig.GoogleID %>
  <% end_if %>
</head>

<body class="$BodyClasses h-screen w-screen" x-data="{ 'showModal': false, activeTab: '#tab1' }"
  @keydown.escape="showModal = false" x-cloak>
  <main id="main-content" class="h-screen w-screen p-4">
    <% include SiteHeader %>
    $Layout
  </main>
  $SiteJS
</body>

</html>
