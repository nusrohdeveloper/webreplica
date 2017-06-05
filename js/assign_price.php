<script type="text/javascript">

  function assignPrice(form) {
    // alert('haha');
    $(form+' #nama').change(function(){
      var harga_pengedar, harga;
      var nama = $("select#nama option:selected").val();
      if(nama == ''){
        harga_pengedar = '';
        harga = '';
      }else if(nama == 'Aisya Lover' || nama == 'Aisya Pearl'){
        harga_pengedar = 13;
        harga = 23;
      }else if(nama == 'Iysya Execlusive' || nama == 'Iysya' || nama == 'Syahira Execlusive'){
        harga_pengedar = 10;
        harga = 20;
      }else{
        harga_pengedar = 8;
        harga = 18;
      }
      $(form+' #harga_pengedar').val(harga_pengedar);
      $(form+' #harga_runcit').val(harga);

    });
  }

</script>
