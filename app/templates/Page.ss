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
  <% if BackgroundVideo %>
    <video autoplay muted loop id="bg-video" class="fixed z-0 inset-0 w-screen h-screen object-cover">
      <source src="$BackgroundVideo.AbsoluteURL" type="$BackgroundVideo.MimeType">
    </video>
    <div class="bg-cover"></div>
  <% else %>
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
  <% else %>
  <div class="absolute z-0 inset-0 w-screen h-screen bg-primary-dark">
  </div>
  <% end_if %>
  <% end_if %>
  <% end_if %>
  <main id="main-content" class="absolute inset-0 h-screen w-screen p-4">
    <% if ClassName = 'App\Page\HomePage' %>
    <% include SiteHeader %>
    <% end_if %>
    $Layout
  </main>
  $SiteJS
</body>

</html>
