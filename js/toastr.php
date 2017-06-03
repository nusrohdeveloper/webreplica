<?php
  if(isset($_GET["s"]))
  {
    ?>

    <script type="text/javascript">
      var token  = '<?php echo $_GET["s"]?>';
      if(token == 'u')
      {
        toastr.success('Data berjaya dikemaskini.');
      }else if (token == 'p') {
        toastr.success('Katalaluan berjaya dikemaskini.');
      }else if (token == 'a') {
        toastr.success('Data telah berjaya ditambah.');
      }else if (token == 'd') {
        toastr.info('Data telah berjaya dipadam.');
      }
    </script>
  <?php
  }
  if(isset($_GET["f"]))
  {
    ?>

    <script type="text/javascript">
      var token  = '<?php echo $_GET["f"]?>';
      if(token == 'a')
      {
        toastr.error('Data tidak berjaya ditambah.');
      }else if (token == 'k') {
        toastr.error('Data tidak berjaya dikemaskini.');
      }
    </script>
  <?php
  }
  if(isset($_GET["w"]))
  {
    ?>

    <script type="text/javascript">
      var token  = '<?php echo $_GET["w"]?>';
      if(token == 'a')
      {
        toastr.warning('Sila Kemaskini Profil anda. Maklumat tidak lengkap');
      }else if (token == 'k') {
        toastr.success('Data tidak berjaya dikemaskini.');
      }
    </script>
  <?php
  }
?>
