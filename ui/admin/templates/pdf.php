<div class="wrap" id="configuration-page">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Wpisy w PDF', 'k3e'); ?>
    </h1>


    <div id="dashboard-widgets-wrap">
        <div id="dashboard-widgets" class="metabox-holder">
            <div class="postbox-container" style="width:100%;">
                <div class="card" style="max-width: none; margin:2px">
                    <div class="k3e_box">
                        <style scoped>
                            .k3e_box{
                                display: grid;
                                grid-template-columns: max-content 1fr;
                                grid-row-gap: 10px;
                                grid-column-gap: 20px;
                            }
                            .k3e_field{
                                display: contents;
                            }
                        </style>
                        <form method="post" action="admin.php?page=post_pdf&save=form">
                            <p class="meta-options k3e_field">
                                <label for="k3e_document_pdf_name"><?= __('Nazwa dokumentu', 'k3e') ?></label>
                                <input id="k3e_document_pdf_name" type="text" name="PostExtension[document_pdf_name]" value='<?= __('Wpisy ', 'k3e') . date('Y-m-d H:i:s') ?>'>
                            </p>
                            <div  style="display: block;">
                                <input type='hidden' name="PostExtension[PDF]" value="<?= md5(rand(0, 255)) ?>"/>
                                <button class="button button-primary"  type="submit">Wygeneruj</button>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <h2><?= __('Wygenerowane dokumenty', 'k3e') ?></h2>
                    <div class="k3e_box">
                        <?php
                        $args = array(
                            'post_type' => 'attachment',
                            'order' => 'DESC',
                            'post_status' => 'inherit',
                            'posts_per_page' => -1,
                            'meta_query' => array(
                                array(
                                    'key' => UIClassPostExtension::OPTION_POSTEXTENSION_DOCUMENT,
                                    'compare' => 'EXISTS'
                                )
                            ),
                        );

                        $files = new WP_Query($args);
                        ?>
                        <table id="growlist" class="display" style="width:100%" data-counter="<?= $files->found_posts ?>">
                            <thead>
                                <tr>
                                    <th style="text-align: left;"><?= __('Lp.', 'k3e') ?></th>
                                    <th style="text-align: left;"><?= __('Dokument', 'k3e') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($files->have_posts()) { ?>
                                    <?php $i = 1; ?>
                                    <?php while ($files->have_posts()) : $files->the_post(); ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><a href="<?= wp_get_attachment_url(get_the_ID()) ?>" style="text-decoration: none;"><?= get_the_title() ?></a></td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endwhile; ?>
                                <?php } else { ?>
                                <td colspan="2" style="text-align: center;"><?= __('Brak wspisów', 'k3e') ?></td>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="text-align: left;"><?= __('Lp.', 'k3e') ?></th>
                                    <th style="text-align: left;"><?= __('Dokument', 'k3e') ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

