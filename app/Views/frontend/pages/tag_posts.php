<?= $this->extend('frontend/layout/pages-layout.php') ?>
<?= $this->section('content') ?>

<div class="row">

    <!-- <div class="col-12">
        <div class="breadcrumbs mb-4"> <a href="index.html">Home</a>
            <span class="mx-1">/</span> <a href="#!">Articles</a>
            <span class="mx-1">/</span> <a href="#!">Travel</a>
        </div>
        <h1 class="mb-4 border-bottom border-primary d-inline-block">Travel</h1>
    </div> -->
    <div class="col-lg-8 mb-5 mb-lg-0">
        <div class="row">
        <div class="col-12">
                <h1 class="mb-4 border-bottom border-primary d-inline-block"><?= $pageTitle ?></h1>
            </div>
            <?php foreach ($post_data as $post): ?>
                <div class="col-md-6 mb-4">
                    <article class="card article-card article-card-sm h-100">
                        <a href="<?= route_to('read-post', $post->slug) ?>">
                            <div class="card-image">
                                <div class="post-info"> <span class="text-uppercase">
                                        <?=
                                            convert_time_dmy($post->updated_at)
                                            ?>
                                    </span>
                                    <span class="text-uppercase"><?= time_to_read($post->content) ?> minutes
                                        read</span>
                                </div>
                                <img loading="lazy" decoding="async"
                                    src="/images/posts/resized_<?= $post->featured_image ?>" alt="Post Thumbnail"
                                    class="w-100" width="420" height="280">
                            </div>
                        </a>
                        <div class="card-body px-0 pb-0">
                            <h2><a class="post-title"
                                    href="<?= route_to('read-post', $post->slug) ?>"><?= $post->title ?></a></h2>
                            <p class="card-text"><?= wrapper_limit_text($post->content, 35) ?></p>
                            <div class="content"> <a class="read-more-btn"
                                    href="<?= route_to('read-post', $post->slug) ?>">Read Full
                                    Article</a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach ?>
            <div class="col-md-12">
                <?php if ($pager && $pager->getPageCount() > 1): ?>
                    <?= $pager->makeLinks($page, $perPage, $total, 'custom_paginate') ?>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="widget-blocks">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <?php include ('partials/sidebar-latest-posts.php') ?>

                </div>
                <div class="col-lg-12 col-md-6">
                    <?php include ('partials/sidebar-categories.php') ?>
                </div>
                <div class="col-lg-12 col-md-6">
                    <?php include ('partials/sidebar-tags.php') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>