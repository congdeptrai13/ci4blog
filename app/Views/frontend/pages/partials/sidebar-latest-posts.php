<div class="widget">
    <h2 class="section-title mb-3">Latest Posts</h2>
    <div class="widget-body">
        <div class="widget-list">
            <?php foreach (get_latest_posts() as $latest_post): ?>
                <a class="media align-items-center" href="article.html">
                    <img loading="lazy" decoding="async" src="/images/posts/<?= $latest_post->featured_image ?>"
                        alt="<?= $latest_post->title ?>" class="w-100">
                    <div class="media-body ml-3">
                        <h3 style="margin-top:-5px"><?= $latest_post->title ?></h3>
                        <p class="mb-0 small"><?= wrapper_limit_text($latest_post->content,6) ?></p>
                    </div>
                </a>
            <?php endforeach ?>
        </div>
    </div>
</div>