<div class="simplegallery">
    <% loop $SortedImages %>
        <% if $CustomLink %>
            <a href="$CustomLink">$Image</a>
        <% else %>
            $Image
        <% end_if %>
    <% end_loop %>
</div>
