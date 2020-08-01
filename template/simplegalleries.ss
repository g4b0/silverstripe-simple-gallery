<% loop $SortedGalleries %>
<div class="simplegallery">
    <article>
        <h3>$Name</h3>
        $Description
        <div>
            <% loop $SortedImages %>
                <% if $CustomLink %>
                    <a href="$CustomLink">$Image</a>
                <% else %>
                    $Image
                <% end_if %>
            <% end_loop %>
        </div>
    </article>
</div>
<% end_loop %>
