<% base_tag %>
<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> | $SiteConfig.Title</title>
<meta name="description" content="<% if $MetaDescription %>$MetaDescription<% else_if Summary %>$Summary<% else %>$SiteConfig.Title Website<% end_if %>">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
