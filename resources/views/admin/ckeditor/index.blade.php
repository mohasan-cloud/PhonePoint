<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Summernote
        $('.editor1').summernote({
            tabsize: 2,
            height: 300,  // Set the editor height
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],  // Add the clear button
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['misc', ['undo', 'redo']],
                ['remove', ['removeFormat']]  // Add removeFormat button
            ]
        });

        // Custom logic to remove font styles on button click
        $(".editor1").on('summernote.keyup', function (e) {
            // Hook into the 'clear' button click or other custom action
            $(".note-btn[data-event='removeFormat']").on('click', function () {
                // Remove font styles from the selected content
                removeFontStyles();
            });
        });

        // Function to remove font styles (custom implementation)
        function removeFontStyles() {
            var editorContent = $('.editor1').summernote('code');  // Get the current editor content

            // Use jQuery to remove inline styles (span, font tags)
            var cleanedContent = $('<div>' + editorContent + '</div>');

            cleanedContent.find('span, font').removeAttr('style').contents().unwrap();

            // Set the cleaned content back to Summernote editor
            $('.editor1').summernote('code', cleanedContent.html());
        }
    });
</script>
