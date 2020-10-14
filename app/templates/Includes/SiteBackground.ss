<% if BackgroundColor %>
<div class="absolute inset-0 z-0 w-screen h-screen" style="background-color:#{$BackgroundColor};"></div>
<% else %>
<% if BackgroundVideo %>
<video autoplay muted loop id="bg-video" class="fixed inset-0 z-0 object-cover w-screen h-screen">
  <source src="$BackgroundVideo.AbsoluteURL" type="$BackgroundVideo.MimeType">
</video>
<div class="bg-cover"></div>
<% else %>
<% if BackgroundImages %>
<div class="absolute inset-0 z-0 object-cover w-screen h-screen splide">
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
<div class="absolute inset-0 z-0 w-screen h-screen bg-primary-dark"></div>
<% end_if %>
<% end_if %>
<% end_if %>
