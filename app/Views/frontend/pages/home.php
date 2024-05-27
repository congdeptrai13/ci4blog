<?= $this->extend('frontend/layout/pages-layout.php') ?>
<?= $this->section('content') ?>
<div class="row no-gutters-lg">
    <div class="col-12">
        <h2 class="section-title">Latest Articles</h2>
    </div>
    <div class="col-lg-8 mb-5 mb-lg-0">
        <div class="row">
            <div class="col-12 mb-4">
                <article class="card article-card">
                    <a href="<?= route_to('read-post', get_main_post()->slug) ?>">
                        <div class="card-image">
                            <div class="post-info"> <span class="text-uppercase">
                                    <?=
                                        convert_time_dmy(get_main_post()->updated_at)
                                        ?>
                                </span>
                                <span class="text-uppercase"><?= time_to_read(get_main_post()->content) ?> minutes
                                    read</span>
                            </div>
                            <img loading="lazy" decoding="async"
                                src="images/posts/<?= get_main_post()->featured_image ?>" alt="Post Thumbnail"
                                class="w-100">
                        </div>
                    </a>
                    <div class="card-body px-0 pb-1">
                        <h2 class="h1"><a class="post-title"
                                href="<?= route_to('read-post', get_main_post()->slug) ?>"><?= get_main_post()->title ?></a>
                        </h2>
                        <p class="card-text"><?= wrapper_limit_text(get_main_post()->content, 35) ?></p>
                        <div class="content"> <a class="read-more-btn"
                                href="<?= route_to('read-post', get_main_post()->slug) ?>">Read Full Article</a>
                        </div>
                    </div>
                </article>
            </div>
            <?php foreach (get_6_posts() as $post_data): ?>
                <div class="col-md-6 mb-4">
                    <article class="card article-card article-card-sm h-100">
                        <a href="article.html">
                            <div class="card-image">
                                <div class="post-info"> <span class="text-uppercase">
                                        <?=
                                            convert_time_dmy($post_data->updated_at)
                                            ?>
                                    </span>
                                    <span class="text-uppercase"><?= time_to_read($post_data->content) ?> minutes
                                        read</span>
                                </div>
                                <img loading="lazy" decoding="async"
                                    src="images/posts/thumb_<?= $post_data->featured_image ?>" alt="Post Thumbnail"
                                    class="w-100">
                            </div>
                        </a>
                        <div class="card-body px-0 pb-0">
                            <h2><a class="post-title" href="article.html"><?= $post_data->title ?></a></h2>
                            <p class="card-text"><?= wrapper_limit_text($post_data->content) ?></p>
                            <div class="content"> <a class="read-more-btn" href="article.html">Read Full Article</a>
                            </div>
                        </div>
                    </article>
                </div>

            <?php endforeach ?>

        </div>
    </div>
    <div class="col-lg-4">
        <div class="widget-blocks">
            <div class="row">
                <div class="col-lg-12">
                    <div class="widget">
                        <div class="widget-body">
                            <img loading="lazy" decoding="async" src="frontend/images/author.jpg" alt="About Me"
                                class="w-100 author-thumb-sm d-block">
                            <h2 class="widget-title my-3">Hootan Safiyari</h2>
                            <p class="mb-3 pb-2">Hello, I’m Hootan Safiyari. A Content writter, Developer and Story
                                teller. Working as a Content writter at CoolTech Agency. Quam nihil …</p> <a
                                href="about.html" class="btn btn-sm btn-outline-primary">Know
                                More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6">
                    <div class="widget">
                        <h2 class="section-title mb-3">Recommended</h2>
                        <div class="widget-body">
                            <div class="widget-list">
                                <?php if (count(get_random_posts()) >= 4): ?>
                                    <?php foreach (get_random_posts() as $post_random): ?>
                                        <a class="media align-items-center" href="article.html">
                                            <img loading="lazy" decoding="async"
                                                src="images/posts/thumb_<?= $post_random->featured_image ?>"
                                                alt="Post Thumbnail" class="w-100">
                                            <div class="media-body ml-3">
                                                <h3 style="margin-top:-5px"><?= $post_random->title ?></h3>
                                                <p class="mb-0 small"><?= wrapper_limit_text($post_random->content, 6) ?></p>
                                            </div>
                                        </a>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6">
                    <?php include ('partials/sidebar-categories.php') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>