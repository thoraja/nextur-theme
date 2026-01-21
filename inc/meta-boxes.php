<?php
/**
 * Meta Boxes & Save Logic
 */

// 2. Register Meta Boxes
function nextur_add_meta_boxes() {
    add_meta_box('trip_header_box', '1. Header & Taxonomy', 'render_trip_header_box', 'trip', 'side', 'high');
    add_meta_box('trip_context_box', '2. Subtitle & Highlights', 'render_trip_context_box', 'trip', 'normal', 'high');
    add_meta_box('trip_itinerary_box', '3. Dynamic Itinerary', 'render_trip_itinerary_box', 'trip', 'normal', 'high');
    add_meta_box('trip_financial_box', '4. Financials & Rules', 'render_trip_financial_box', 'trip', 'normal', 'high');
    add_meta_box('trip_details_box', '5. Full Details', 'render_trip_details_box', 'trip', 'normal', 'high');
    // RESTORED: Gallery Box
    add_meta_box('trip_gallery_box', '6. Trip Gallery', 'render_trip_gallery_box', 'trip', 'normal', 'high');
}
add_action('add_meta_boxes', 'nextur_add_meta_boxes');

/* --- RENDER CALLBACKS --- */
function render_trip_header_box($post) {
    wp_nonce_field('save_trip_meta', 'trip_nonce');
    $year = get_post_meta($post->ID, '_trip_tag_year', true);
    $airline = get_post_meta($post->ID, '_trip_airline', true);
    $route = get_post_meta($post->ID, '_trip_route', true);
    $price = get_post_meta($post->ID, '_trip_price', true);
    ?>
    <p><label><strong>Tag/Year</strong></label><input type="text" name="_trip_tag_year" value="<?php echo esc_attr($year); ?>" class="widefat"></p>
    <p><label><strong>Airline</strong></label><input type="text" name="_trip_airline" value="<?php echo esc_attr($airline); ?>" class="widefat"></p>
    <p><label><strong>Route</strong></label><input type="text" name="_trip_route" value="<?php echo esc_attr($route); ?>" class="widefat"></p>
    <p><label><strong>Start Price (IDR)</strong></label><input type="number" name="_trip_price" value="<?php echo esc_attr($price); ?>" class="widefat"></p>
    <?php
    $featured = get_post_meta($post->ID, '_trip_is_featured', true);
    ?>
    <p>
        <label><strong>Featured on Homepage?</strong></label>
        <br>
        <label>
            <input type="checkbox" name="_trip_is_featured" value="1" <?php checked($featured, '1'); ?>>
            Yes, show in Hero Slider
        </label>
    </p>
    <?php
}

function render_trip_context_box($post) {
    $subtitle = get_post_meta($post->ID, '_trip_subtitle', true);
    $highlights = get_post_meta($post->ID, '_trip_highlights', true);
    ?>
    <p><label><strong>Subtitle</strong></label><input type="text" name="_trip_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="widefat"></p>
    <p><label><strong>Highlights</strong> (Comma separated)</label><textarea name="_trip_highlights" rows="3" class="widefat"><?php echo esc_textarea($highlights); ?></textarea></p>
    <?php
}

function render_trip_itinerary_box($post) {
    $itinerary = get_post_meta($post->ID, '_trip_itinerary', true);
    if (!$itinerary || !is_array($itinerary)) $itinerary = array(array('day'=>'Day 1','title'=>'','flight'=>'','meals'=>'','desc'=>''));
    ?>
    <div id="itinerary-wrapper">
        <?php foreach ($itinerary as $i => $row) : ?>
        <div class="itinerary-row" style="background:#f8f9fa; padding:15px; margin-bottom:15px; border:1px solid #ddd; border-left:4px solid #2271b1;">
            <div style="display:flex; gap:10px; margin-bottom:10px;">
                <input type="text" name="itinerary[<?php echo $i; ?>][day]" value="<?php echo esc_attr($row['day']); ?>" placeholder="Day 1" style="width:15%;">
                <input type="text" name="itinerary[<?php echo $i; ?>][title]" value="<?php echo esc_attr($row['title']); ?>" placeholder="Title" style="width:85%;">
            </div>
            <div style="display:flex; gap:10px; margin-bottom:10px;">
                <input type="text" name="itinerary[<?php echo $i; ?>][flight]" value="<?php echo esc_attr($row['flight_info'] ?? ''); ?>" placeholder="Flight Info" style="width:70%;">
                <input type="text" name="itinerary[<?php echo $i; ?>][meals]" value="<?php echo esc_attr($row['meals']); ?>" placeholder="Meals" style="width:30%;">
            </div>
            <textarea name="itinerary[<?php echo $i; ?>][desc]" rows="4" style="width:100%;"><?php echo esc_textarea($row['desc']); ?></textarea>
            <button type="button" class="button remove-row" style="margin-top:10px; color:#b32d2e;">Remove Day</button>
        </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-day" class="button button-primary">+ Add Day</button>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrap = document.getElementById('itinerary-wrapper');
        document.getElementById('add-day').addEventListener('click', () => {
            const count = wrap.querySelectorAll('.itinerary-row').length;
            const html = `
                <div class="itinerary-row" style="background:#f8f9fa; padding:15px; margin-bottom:15px; border:1px solid #ddd; border-left:4px solid #2271b1;">
                    <div style="display:flex; gap:10px; margin-bottom:10px;">
                        <input type="text" name="itinerary[${count}][day]" value="Day ${count+1}" style="width:15%;">
                        <input type="text" name="itinerary[${count}][title]" placeholder="Title" style="width:85%;">
                    </div>
                    <div style="display:flex; gap:10px; margin-bottom:10px;">
                        <input type="text" name="itinerary[${count}][flight]" placeholder="Flight Info" style="width:70%;">
                        <input type="text" name="itinerary[${count}][meals]" placeholder="Meals" style="width:30%;">
                    </div>
                    <textarea name="itinerary[${count}][desc]" rows="4" style="width:100%;"></textarea>
                    <button type="button" class="button remove-row" style="margin-top:10px; color:#b32d2e;">Remove Day</button>
                </div>`;
            wrap.insertAdjacentHTML('beforeend', html);
        });
        wrap.addEventListener('click', e => { if(e.target.classList.contains('remove-row')) e.target.closest('.itinerary-row').remove(); });
    });
    </script>
    <?php
}

function render_trip_financial_box($post) {
    $min_pax = get_post_meta($post->ID, '_trip_min_pax', true);
    $deposit = get_post_meta($post->ID, '_trip_deposit', true);
    $infant = get_post_meta($post->ID, '_trip_infant_price', true);
    $visa = get_post_meta($post->ID, '_trip_visa_note', true);
    $terms = get_post_meta($post->ID, '_trip_payment_terms', true);
    ?>
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
        <p><label><strong>Min Pax</strong></label><br><input type="text" name="_trip_min_pax" value="<?php echo esc_attr($min_pax); ?>" class="widefat"></p>
        <p><label><strong>Deposit Amount</strong></label><br><input type="text" name="_trip_deposit" value="<?php echo esc_attr($deposit); ?>" class="widefat"></p>
        <p><label><strong>Infant Price</strong></label><br><input type="text" name="_trip_infant_price" value="<?php echo esc_attr($infant); ?>" class="widefat"></p>
        <p><label><strong>Visa Note</strong></label><br><input type="text" name="_trip_visa_note" value="<?php echo esc_attr($visa); ?>" class="widefat"></p>
    </div>
    <p><label><strong>Payment Terms Note</strong></label><br><textarea name="_trip_payment_terms" rows="3" class="widefat"><?php echo esc_textarea($terms); ?></textarea></p>
    <?php
}

function render_trip_details_box($post) {
    $includes = get_post_meta($post->ID, '_trip_includes', true);
    $excludes = get_post_meta($post->ID, '_trip_excludes', true);
    $optional = get_post_meta($post->ID, '_trip_optional', true);
    $terms = get_post_meta($post->ID, '_trip_terms', true);
    $args = array('textarea_rows' => 6, 'media_buttons' => false, 'teeny' => true);
    echo '<h4>Includes</h4>'; wp_editor($includes, '_trip_includes', $args);
    echo '<hr><h4>Excludes</h4>'; wp_editor($excludes, '_trip_excludes', $args);
    echo '<hr><h4>Optional / Add-ons</h4>'; wp_editor($optional, '_trip_optional', $args);
    echo '<hr><h4>Terms & Conditions</h4>'; wp_editor($terms, '_trip_terms', $args);
}

// RESTORED: Gallery Render Callback
function render_trip_gallery_box($post) {
    $gallery_ids = get_post_meta($post->ID, '_trip_gallery', true);
    ?>
    <div id="trip_gallery_wrapper">
        <input type="hidden" id="trip_gallery" name="_trip_gallery" value="<?php echo esc_attr($gallery_ids); ?>">
        <div id="gallery_preview" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:10px;">
            <?php if($gallery_ids):
                $ids = explode(',', $gallery_ids);
                foreach($ids as $id):
                    $img = wp_get_attachment_image_url($id, 'thumbnail');
                    if($img) echo '<div style="position:relative;"><img src="'.$img.'" style="width:80px; height:80px; object-fit:cover; border-radius:4px; border:1px solid #ddd;"></div>';
                endforeach;
            endif; ?>
        </div>
        <button type="button" class="button" id="manage_gallery">Select/Edit Images</button>
        <p class="description">Select multiple images to appear in the "Gallery" tab.</p>
    </div>
    <script>
    jQuery(document).ready(function($){
        var frame;
        $('#manage_gallery').click(function(e){
            e.preventDefault();
            if(frame) { frame.open(); return; }
            frame = wp.media({
                title: 'Select Trip Gallery Images',
                button: { text: 'Use these images' },
                multiple: true
            });
            frame.on('select', function(){
                var selection = frame.state().get('selection');
                var ids = [];
                $('#gallery_preview').html('');
                selection.map(function(attachment){
                    attachment = attachment.toJSON();
                    ids.push(attachment.id);
                    if(attachment.type === 'image'){
                        var url = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                        $('#gallery_preview').append('<img src="'+url+'" style="width:80px; height:80px; object-fit:cover; border-radius:4px; border:1px solid #ddd; margin-right:5px;">');
                    }
                });
                $('#trip_gallery').val(ids.join(','));
            });
            frame.open();
        });
    });
    </script>
    <?php
}

/* --- SAVE LOGIC (FIXED) --- */
function save_trip_meta($post_id) {
    if (!isset($_POST['trip_nonce']) || !wp_verify_nonce($_POST['trip_nonce'], 'save_trip_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // 1. Handle Checkbox Explicitly (The Fix)
    // If the box is checked, $_POST has '1'. If unchecked, it has nothing.
    // We must force '0' if it is missing.
    $featured = isset($_POST['_trip_is_featured']) ? '1' : '0';
    update_post_meta($post_id, '_trip_is_featured', $featured);

    // 2. Handle Text Fields (Removed _trip_is_featured from this list)
    $fields = ['_trip_tag_year', '_trip_airline', '_trip_route', '_trip_price', '_trip_subtitle', '_trip_highlights', '_trip_min_pax', '_trip_deposit', '_trip_infant_price', '_trip_visa_note', '_trip_payment_terms', '_trip_gallery'];
    foreach($fields as $f) { 
        if(isset($_POST[$f])) {
            update_post_meta($post_id, $f, sanitize_text_field($_POST[$f])); 
        }
    }

    // 3. Handle Rich Text Areas
    $rich = ['_trip_includes', '_trip_excludes', '_trip_optional', '_trip_terms'];
    foreach($rich as $r) { 
        if(isset($_POST[$r])) {
            update_post_meta($post_id, $r, wp_kses_post($_POST[$r])); 
        }
    }

    // 4. Handle Itinerary (Array)
    if(isset($_POST['itinerary']) && is_array($_POST['itinerary'])) {
        $clean = [];
        foreach($_POST['itinerary'] as $day) {
            if(!empty($day['title'])) {
                $clean[] = [
                    'day' => sanitize_text_field($day['day']),
                    'title' => sanitize_text_field($day['title']),
                    'flight_info' => sanitize_text_field($day['flight']),
                    'meals' => sanitize_text_field($day['meals']),
                    'desc' => sanitize_textarea_field($day['desc'])
                ];
            }
        }
        update_post_meta($post_id, '_trip_itinerary', $clean);
    }
}
add_action('save_post', 'save_trip_meta');

// 2. Add Link Meta Box (Gallery Item)
function nextur_add_gallery_meta() {
    add_meta_box('gallery_link_box', 'Destination Link', 'nextur_render_gallery_meta', 'gallery_item', 'normal', 'high');
}
function nextur_render_gallery_meta($post) {
    $link = get_post_meta($post->ID, '_gallery_link', true);
    ?>
    <p>
        <label style="font-weight:bold; display:block; margin-bottom:5px;">Target URL</label>
        <input type="text" name="_gallery_link" value="<?php echo esc_attr($link); ?>" class="widefat" placeholder="e.g. https://nextur.com/trips/bali or #">
        <span class="description">Enter the URL this card should link to.</span>
    </p>
    <?php
}
function nextur_save_gallery_meta($post_id) {
    if (isset($_POST['_gallery_link'])) {
        update_post_meta($post_id, '_gallery_link', sanitize_text_field($_POST['_gallery_link']));
    }
}
add_action('add_meta_boxes', 'nextur_add_gallery_meta');
add_action('save_post', 'nextur_save_gallery_meta');
