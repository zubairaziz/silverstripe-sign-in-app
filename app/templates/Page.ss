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

<body class="$BodyClasses">
  <% if $SiteConfig.GoogleID %>
  <% include GoogleTagManager NoScript="true", GoogleID=$SiteConfig.GoogleID %>
  <% end_if %>
  <div class="content-wrapper">
    <main id="main-content" class="page-wrapper">
      $Layout
    </main>
  </div>
  $SiteJS
  <script type="text/javascript" src="//cdn.callrail.com/companies/819978231/59d8105bc90e19ab2c84/12/swap.js"></script>
</body>

</html>
