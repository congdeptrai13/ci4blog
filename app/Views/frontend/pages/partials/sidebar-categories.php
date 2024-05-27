<div class="widget">
    <h2 class="section-title mb-3">Categories</h2>
    <div class="widget-body">
        <ul class="widget-list">
            <?php foreach (sidebar_subcategories() as $subcategory): ?>

                <li><a href="<?= route_to('category-post', $subcategory->slug) ?>"><?= $subcategory->name ?><span
                            class="ml-auto">(<?= total_posts_subcategory($subcategory->id) ?>)</span></a>
                </li>
            <?php endforeach ?>

        </ul>
    </div>
</div>