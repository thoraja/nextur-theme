jQuery(document).ready(function($) {
    var frame;
    var galleryContainer = $('#trip_gallery_container');
    var imgInput = $('#_trip_gallery');
    var addBtn = $('#add_trip_gallery');

    // 1. Open Media Library
    addBtn.on('click', function(e) {
        e.preventDefault();

        // If the frame already exists, re-open it.
        if (frame) {
            frame.open();
            return;
        }

        // Create the media frame.
        frame = wp.media({
            title: 'Select Images for Gallery',
            button: { text: 'Add to Gallery' },
            library: { type: 'image' },
            multiple: true // Allow multiple selection
        });

        // When an image is selected, run a callback.
        frame.on('select', function() {
            var selection = frame.state().get('selection');
            
            selection.map(function(attachment) {
                attachment = attachment.toJSON();
                
                // Append the image to the preview container
                // We use data-id to identify the image later
                var html = `
                    <div class="gallery-item" style="display:inline-block; position:relative; margin:10px;">
                        <img src="${attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url}" style="width:100px; height:100px; object-fit:cover; border-radius:4px; border:1px solid #ddd;">
                        <span class="remove-image" data-id="${attachment.id}" style="position:absolute; top:-5px; right:-5px; background:red; color:white; border-radius:50%; width:20px; height:20px; text-align:center; line-height:18px; cursor:pointer; font-weight:bold;">&times;</span>
                    </div>
                `;
                galleryContainer.append(html);
            });

            updateGalleryInput();
        });

        frame.open();
    });

    // 2. Remove Image
    galleryContainer.on('click', '.remove-image', function() {
        $(this).parent().remove();
        updateGalleryInput();
    });

    // 3. Update Hidden Input with IDs
    function updateGalleryInput() {
        var ids = [];
        galleryContainer.find('.remove-image').each(function() {
            ids.push($(this).data('id'));
        });
        imgInput.val(ids.join(','));
    }
    
    // Sortable (Optional: simple jQuery UI sortable if loaded, otherwise standard append)
    if ($.fn.sortable) {
        galleryContainer.sortable({
            update: function() { updateGalleryInput(); }
        });
    }
});