<?php echo $scripts_for_layout; ?>

<script type="text/javascript">
    function proyect_url(){
        return "<?php echo Configure::read('proyect_url') ?>";
    }
</script> 
<script type="text/javascript"><?php echo $content_for_layout; ?></script>