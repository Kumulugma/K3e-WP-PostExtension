<div class="wrap" id="configuration-page">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('K3e PostExtension', 'k3e'); ?>
    </h1>

    <?php $option = unserialize(get_option(UIClassPostExtension::OPTION_POSTEXTENSION)); ?>
    <?php $postExtension = is_array($option) ? $option : []; ?>


    <div class="card">
        <form method="post" action="options-general.php?page=postextension">
            <fieldset>
                <h3><?=__('Wyłacz taksonomię', 'k3e')?></h3>
                <?php foreach (UIClassPostExtension::POST_TAXONOMIES as $type) { ?>
                        <p>
                            <input type="checkbox" id="<?= $type ?>Form" name="PostExtension[<?= $type ?>]" value="<?= $type ?>" <?= (in_array($type, $postExtension)) ? "checked" : "" ?>>
                            <label for="<?= $type ?>Form"><?php $tax_type_obj = get_taxonomy($type) ?> <?= $tax_type_obj->label; ?> [<?= $type ?>]</label>
                        </p>
                <?php } ?>
                <input type="hidden" value="<?= md5(rand(0, 255)) ?>" name="PostExtension[salt]">
                <button class="button button-primary" type="submit">Zapisz</button>
            </fieldset>
        </form>
    </div>

</div>
