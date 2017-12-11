<script type="text/javascript">
  //print slip
  $(document).on('click','#print',function(){
    // console.log('berhasil');

    // $('#header').css('display','none');
    var beforePrint = function() {
         $('#header').css('display','none');
    };
    var afterPrint = function() {
        $('#header').css('display','block');
    };
  });
  // add disabled form master->karyawan->tanggal keluar
  var status_kerja = $('#status_kerja').val();
  if (status_kerja == 'Tetap') {
    $('#tanggal_keluar').attr('disabled','true');
  }
  $('#status_kerja').change(function(){
    var isi = $(this).val();
    if (isi == 'Tetap') {
        $('#tanggal_keluar').attr('disabled','true');
    }
    if (isi != 'Tetap') {
        $('#tanggal_keluar').removeAttr('disabled','false');
    }
  });
  //hapus pph21 di payrol dan slip
  $(document).on('click','#hapus,#slip_hapus',function(){
    // console.log('hapus berhasil') ;
    $('#slip_tr_pph21').toggle();
    $('#payrol_th_pph21').toggle();
    $('#payrol_body tr').find('#payrol_td_pph21').toggle();
    if ($('#payrol_th_potongan').attr('colspan') == 7) {
      isi = $('#payrol_th_potongan').attr('colspan',6);
    }else{
      isi = $('#payrol_th_potongan').attr('colspan',7);
    }
    @php
      session()->put('showPph', request('show-pph') === 'true')
    @endphp
  });

</script>
