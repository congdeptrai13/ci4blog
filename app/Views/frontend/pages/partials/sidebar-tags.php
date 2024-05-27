<div class="widget">
    <h2 class="section-title mb-3">Categories</h2>
    <div class="widget-body">
        <ul class="widget-list">
            <?php
            
            foreach (get_all_tags() as $tag): ?>
                <li><a href="<?= route_to('tag-post', $tag) ?>"><?= $tag ?></a>
                </li>
                <?php
            endforeach ?>

        </ul>
    </div>
</div>