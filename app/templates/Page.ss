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
  <%-- <% if AnimationDuration %>
    <style>
      .slideshow li span {
      }
    </style>
  <% end_if %> --%>

  <% if $SiteConfig.GoogleID %>
  <% include GoogleTagManager GoogleID=$SiteConfig.GoogleID %>
  <% end_if %>
</head>

<body class="$BodyClasses relative h-screen w-screen" x-data="{ 'showModal': false, activeTab: '#tab1' }"
  @keydown.escape="showModal = false" x-cloak>
  <% if BackgroundImages %>
    <div class="splide absolute z-0 inset-0 w-screen h-screen">
      <div class="splide__track">
        <ul class="splide__list">
          <% loop BackgroundImages %>
          <li class="splide__slide">
            <span>$Image.FocusFill(1920, 1080)</span>
          </li>
          <% end_loop %>
        </ul>
      </div>
    </div>
  <% end_if %>
  <main id="main-content" class="absolute inset-0 h-screen w-screen p-4">
    <% include SiteHeader %>
    $Layout
  </main>
  $SiteJS
</body>

</html>
