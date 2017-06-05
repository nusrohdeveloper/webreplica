<script type="text/javascript">

//  var stok = <?php //echo json_encode($stok); ?>;
  // alert(stok);
  // alert(stok.find("Aisya LoverHitamS"));
  function checkModel(select_input, select_warna) {
    $(select_input).change(function(){
      // alert('yolooo');
      var standard = $("select"+select_input+" option:selected").val();
      if(standard == 'Syahira Signature')
      {
        $(select_warna).hide();
        $(select_warna+'_hitam').removeClass('hidden');
      }
      else{
        $(select_warna).show();
        $(select_warna+'_hitam').addClass('hidden');
      }
    });
  }
  function checkStok(select_input, input_kuantiti) {
    $(select_input+"_saiz").change(function(){
      // alert('yolooo');
      var nama = $("select"+select_input+"_nama option:selected").val();
      var warna = $("select"+select_input+"_warna option:selected").val();
      var saiz = $("select"+select_input+"_saiz option:selected").val();
      $(input_kuantiti).attr('placeholder', stok[nama+warna+saiz]);
    });
  }
  // function appendInput() {
  //   $('#todo').append('<div>' + $('.input-value').val() + '</div>');
  // }

  function addGoods(target, the_input, modal, hidden_inputs, pengedar) {
    // alert(input + "" + target);
    // $('#todo').append('<div>' + $('.input-value').val() + '</div>');
    var nama = $(the_input+'_nama').val();
    var warna = $(the_input+'_warna').val() || $(the_input+'_warna_hitam').val();
    var saiz = $(the_input+'_saiz').val();
    var quantity = $(the_input+'_quantity').val();
    // var stok = parseInt(stok[nama+warna+saiz]);
    var harga = 0;

    if(nama == 'Aisya Lover' || nama == 'Aisya Pearl'){
      if (pengedar == '1'){ harga = 13;} else{ harga = 23;}
    }else if(nama == 'Iysya Execlusive' || nama == 'Iysya Biasa' || nama == 'Syahira Execlusive'){
      if (pengedar == '1'){ harga = 10;} else{ harga = 20;}
    }else{
      if (pengedar == '1'){ harga = 8;} else{ harga = 18;}
    }
    // if (nama != '' && warna != '' && saiz != ''){
    // }

    if(nama != '' && warna != '' && saiz != '' && warna != '' && quantity != '' && quantity < parseInt(stok[nama+warna+saiz]) ){
      // $(target).append('<li>' + $(the_input+'_nama').val() + '|'  + $(the_input+'_warna').val() + '|'  + $(the_input+'_saiz').val() + '|'  + $(the_input+'_quantity').val() + '| RM'  + $(the_input+'_quantity').val()*10 + '</li>');
      $(target).append('<div class="row"><div class="col-xs-4">' + nama + '</div><div class="col-xs-3">' + warna + '</div><div class="col-xs-1">' + saiz + '</div><div class="col-xs-2 text-right qty">' + quantity + '</div><div class="col-xs-2 totalprice">' + quantity*harga + '</div></div>');
      $(hidden_inputs).append('<input name="nama[]" type="hidden" value="' + nama + '"/><input name="warna[]" type="hidden" value="' + warna + '"/><input name="saiz[]" type="hidden" value="' + saiz + '"/><input name="quantity[]" type="hidden" value="' + quantity + '"/><input name="jumlah[]" type="hidden" value="' + quantity*harga + '"/>');
      var newstok = parseInt(stok[nama+warna+saiz]) - quantity ;
      stok[nama+warna+saiz] = newstok;
      $(the_input+'_nama').val('');
      $(the_input+'_warna').val('');
      $(the_input+'_saiz').val('');
      $(the_input+'_quantity').val('');
      $(modal+' .close').click();
    }
    else if (quantity > parseInt(stok[nama+warna+saiz]) ) {
      alert('Kuantiti melebihi stok, Stok semasa: '+  parseInt(stok[nama+warna+saiz]));
      return false;
    }
    else {
      return false;
    }
    var sum = 0;
    var total_qty = 0;
    $('.totalprice').each(function()
    {
        sum += parseInt($(this).text());
    });
    $('.qty').each(function()
    {
        total_qty += parseInt($(this).text());
    });
    if( total_qty >= 30){
      var button_ada = $(hidden_inputs).find('#rekod_pembelian');
      if(button_ada.length == 0) {
        $(hidden_inputs).append('<button id = "rekod_pembelian" name = "rekod_pembelian" type="submit" class="btn btn-lg green pull-left">Tempah</button>');
      }
    }
    $('.jumlah_harga').text('');
    $('.jumlah_harga').append(sum);

  }
  function kosPenghantaran(qty, kos_penghantaran) {
    if(qty > 100){
      kos_penghantaran = Math.floor(qty /100) * 20;
      kosPenghantaran(qty%100, kos_penghantaran);
    }
    if(qty <= 100 && qty > 50){
      return kos_penghantaran +=  20;
    }
    if(qty <= 50 && qty > 30){
      return kos_penghantaran +=  15;
    }
    if(qty <= 30 && qty > 10){
      return kos_penghantaran +=  10;
    }
    if(qty <= 10 && qty >= 1){
      return kos_penghantaran +=  7;
    }
    if(qty == 0){
      return 0;
    }

  }

  function addGoodsToTempahan(target, the_input, modal, hidden_inputs, pengedar) {
    // alert(input + "" + target);
    // $('#todo').append('<div>' + $('.input-value').val() + '</div>');
    var nama = $(the_input+'_nama').val();
    var warna = $(the_input+'_warna').val() || $(the_input+'_warna_hitam').val();
    var saiz = $(the_input+'_saiz').val();
    var quantity = $(the_input+'_quantity').val();
    var name_for_class = nama+warna+saiz+quantity;
    name_for_class = name_for_class.replace(/\s/g, '').toLowerCase() + Math.floor(Math.random() * 100) + 1
    // var stok = parseInt(stok[nama+warna+saiz]);
    var harga = 0;

    if(nama == 'Aisya Lover' || nama == 'Aisya Pearl'){
      if (pengedar == '1'){ harga = 13;} else{ harga = 23;}
    }else if(nama == 'Iysya Execlusive' || nama == 'Iysya Biasa' || nama == 'Syahira Execlusive'){
      if (pengedar == '1'){ harga = 10;} else{ harga = 20;}
    }else{
      if (pengedar == '1'){ harga = 8;} else{ harga = 18;}
    }
    // if (nama != '' && warna != '' && saiz != ''){
    // }

    if(nama != '' && warna != '' && saiz != '' && warna != '' && quantity != '' ){
      // $(target).append('<li>' + $(the_input+'_nama').val() + '|'  + $(the_input+'_warna').val() + '|'  + $(the_input+'_saiz').val() + '|'  + $(the_input+'_quantity').val() + '| RM'  + $(the_input+'_quantity').val()*10 + '</li>');
      $(target).append('<div class="row '+name_for_class+'"><div class="col-xs-1"><button class="btn btn-sm btn-circle red" onclick="delete_all(`'+name_for_class+'`, '+quantity+', '+quantity*harga+', `'+hidden_inputs+'` )" ><i class="fa fa-close"></i></button></div><div class="col-xs-3">' + nama + '</div><div class="col-xs-3">' + warna + '</div><div class="col-xs-1">' + saiz + '</div><div class="col-xs-2 text-right qty">' + quantity + '</div><div class="col-xs-2 text-right totalprice">' + quantity*harga + '</div></div>');
      // $(target).append('<div class="row"><div class="col-xs-4">' + nama + '</div><div class="col-xs-3">' + warna + '</div><div class="col-xs-1">' + saiz + '</div><div class="col-xs-2 text-right qty">' + quantity + '</div><div class="col-xs-2 totalprice">' + quantity*harga + '</div></div>');
      $(hidden_inputs).append('<div class="'+name_for_class+'"><input name="nama[]" type="hidden" value="' + nama + '"/><input name="warna[]" type="hidden" value="' + warna + '"/><input name="saiz[]" type="hidden" value="' + saiz + '"/><input name="quantity[]" type="hidden" value="' + quantity + '"/><input name="jumlah[]" type="hidden" value="' + quantity*harga + '"/></div>');
      $(the_input+'_nama').val('');
      $(the_input+'_warna').val('');
      $(the_input+'_saiz').val('');
      $(the_input+'_quantity').val('');
      $(modal+' .close').click();
    }
    else {
      return false;
    }
    var sum = 0;
    var total_qty = 0;
    $('.totalprice').each(function()
    {
        sum += parseInt($(this).text());
    });
    $('.qty').each(function()
    {
        total_qty += parseInt($(this).text());
    });
    if( total_qty >= 30){
      var button_ada = $(hidden_inputs).find('#rekod_pembelian');
      if(button_ada.length == 0) {
        $(hidden_inputs).append('<button id = "rekod_pembelian" name = "rekod_pembelian" type="submit" class="btn btn-lg green pull-left">Tempah</button>');
      }
    }
    pos_laju = kosPenghantaran(total_qty, 0);
    $('.kos_penghantaran').text('');
    $('.kos_penghantaran').append(pos_laju);
    $('.kos_penghantaran_input').remove();
    $(hidden_inputs).append('<input name="kos_penghantaran_input" class="kos_penghantaran_input" id="kos_penghantaran_input" type="hidden" value="' + pos_laju + '"/>');

    $('.jumlah_harga').text('');
    $('.jumlah_harga').append(sum);

    $('.jumlah_harga_all').text('');
    $('.jumlah_harga_all').append(sum+pos_laju);

  }
  function delete_all(the_div, qty, minus_kos,hidden_inputs){

    var txt;
    var r = confirm("Adakah anda pasti?");
    if (r == true) {
        $('.'+the_div).remove();
        var pos_laju = 0;
        var total_qty = 0;
        $('.qty').each(function()
        {
            total_qty += parseInt($(this).text());
        });
        // new_qty = total_qty - qty;
        pos_laju = kosPenghantaran(total_qty, 0);
        $('.kos_penghantaran').text('');
        $('.kos_penghantaran').append(pos_laju);
        $('.kos_penghantaran_input').remove();
        $(hidden_inputs).append('<input name="kos_penghantaran_input" class="kos_penghantaran_input" id="kos_penghantaran_input" type="hidden" value="' + pos_laju + '"/>');

        var jumlah_harga = $('.jumlah_harga').last().text();
        $('.jumlah_harga').text('');
        $('.jumlah_harga').append(jumlah_harga - minus_kos);

        // var jumlah_harga_all = $('.jumlah_harga_all').last().text();
        $('.jumlah_harga_all').text('');
        $('.jumlah_harga_all').append(jumlah_harga - minus_kos + pos_laju);

    }
  }
</script>
