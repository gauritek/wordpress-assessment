<?php
$terms = get_terms( array(
    'taxonomy'   => 'project_type',
    'hide_empty' => true,
) );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
    <select id="project-type-filter">
        <option value="">All Project Types</option>
        <?php foreach ( $terms as $term ) : ?>
            <option value="<?php echo esc_attr( $term->term_id ); ?>">
                <?php echo esc_html( $term->name ); ?>
            </option>
        <?php endforeach; ?>
    </select>
<?php endif; ?>
