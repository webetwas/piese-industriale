<script src="<?=SITE_URL;?>public/scripts/summernote/summernote.min.js" type="text/javascript"></script>

<script type="text/javascript">
$('#prtext, #tprext_orar_ro, #tprext_orar_en').summernote({
  toolbar: [
    ['style', ['style']],
    ['fontsize', ['fontsize']],
    ['font', ['bold', 'italic', 'underline', 'clear']],
    ['fontname', ['fontname']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['insert', ['picture', 'hr']],
    ['table', ['table']]
  ],
  height: 150,                 // set editor height
  minHeight: null,             // set minimum height of editor
  maxHeight: null,             // set maximum height of editor
});
</script>