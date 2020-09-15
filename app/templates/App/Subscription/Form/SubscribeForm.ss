<form $AttributesHTML autocomplete="off" class="" novalidate>
  <div class="site-footer__form--inner">
    <div class="site-footer__form-icon">
      $AssetIcon('envelope')
    </div>
    <label for="Email" class="sr-only">Enter email address</label>
    <input type="text" name="Email" placeholder="Enter Email Address...">
    <% loop HiddenFields %>
    $FieldHolder
    <% end_loop %>
    <button type="submit"><span class="sr-only">Subscribe</span>$AssetIcon('arrow-right')</button>
  </div>
  <div class="form-error-message"></div>
  <div class="form-success-message"></div>
</form><!-- /.site-footer__form -->
